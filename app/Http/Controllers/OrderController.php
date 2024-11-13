<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Unit;
use App\Models\Category;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Customer;
use App\Models\CustomerSource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStage;
use App\Models\Quote;
use App\Models\QuoteDetail;
use App\Models\Lead;
use App\Models\PropertyType;
use App\Models\Project;
use App\Models\OrderEmi;
use App\Models\Company;
use App\Models\CustomerPayment;
use App\Models\DefaultContent;


use DataTables;
use Auth;
use PDF;
use DB;


class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$products = Product::where('status', 1)->pluck('name', 'id')->toArray();

    	$phones = Customer::where('status', 1)->pluck('phone')->toArray();

    	$sources = CustomerSource::where('status', 1)->pluck('name', 'id')->toArray();

        return view('pages.order.order_create', compact('products', 'phones', 'sources'));
    }



    public function create(Request $request, $id)
    {
        $customer = Customer::find($id);
        $stages = OrderStage::pluck('stage', 'id')->toArray();

        $property_types = PropertyType::where('status', 1)->pluck('name', 'id')->toArray();
        $projects = Project::where('status', 1)->pluck('title', 'id')->toArray();

        return view('pages.order.order_create', compact('customer', 'stages', 'projects', 'property_types'));    
    }


    public function calculate_emi(Request $request)
    {
        $this->validate($request,[
            'amount' => 'required|numeric',
            'rate' => 'required|numeric',
            'months' => 'required|numeric',
        ],
        [
            'amount.required' => 'Amount is required.',
            'rate.required' => 'Interest Rate is required.',
            'rate.numeric' => 'Interest Rate must be numeric.',
            'months.required' => 'No of months is required.',
        ]);

        $amount = $request->amount;
        $rate = $request->rate;
        $months = $request->months;
        
        $emi = $this->getEmi($amount, $rate, $months);

        return response()->json(['emi' => $emi]); 
    }


    private function getEmi($amount, $rate, $months) 
    {
        if($rate != 0){
            $r = $rate / (12 * 100);    
            $x = round(pow(($r +1), $months), 4);
            $emi = $amount*$r*$x / ($x-1);
        }
        else {
            $emi = ceil($amount / $months);
        }

        return (int)$emi;
    }


    private function get_invoice_start_date()
    {
        $x = 3;
        $due_after_days = 15;
        $start_date = $x;

        if($start_date == 0){
            $d = date('d');
        }
        else {
            $d = $start_date;
        }

        $y = date('Y-m').'-'.$d;

        return ['date'=>date('Y-m-d', strtotime($y)), 'due_after_days'=>$due_after_days];
    }



    public function store_order(Request $request)
    {

        // dd($request->toArray());
        
        $this->validate($request, [
            'customer_id' => 'required',
            'project_id' => 'required',
            'property_type_id' => 'required',
            'property_id' => 'required',
            'cost' => 'required|numeric',
            'advance_payment' => 'required|numeric',
            'balance_payment' => 'required|numeric',
            'interest_rate' => 'numeric',
            'months' => 'numeric',
            'monthly_emi' => 'numeric',
        ],[
            'customer_id' => 'Customer Details are not Valid',
        ]);



        $invoice_start_date = '';

        /*
        Invoice Terms:
        1. On 1st of every month                        1
        2. On 7th of every month                        7
        3. On 10th of every Month                       10
        4. On Accont creation date of every month       0 (date('d');)
        */

        
        $invoice_date_settings = $this->get_invoice_start_date();

        $invoice_date = $invoice_date_settings['date'];
        $due_after_days = $invoice_date_settings['due_after_days'];

        $due_date = date('Y-m-d', strtotime($invoice_date.' + '.$due_after_days.' days'));

        //dd($invoice_date_settings);





        DB::beginTransaction();

        try {
            $obj = new Order();
            $obj->customer_id = $request->customer_id;
            $obj->project_id = $request->project_id;
            $obj->property_type_id = $request->property_type_id;
            $obj->property_id = $request->property_id;
            $obj->total_amount = trim($request->cost);
            $obj->advance_amount = trim($request->advance_payment);
            $obj->current_balance = 0;
            $obj->status = 1;
            // $obj->order_date = $date;
            $obj->order_stage = 1;
            $obj->is_quoted = 1;

            $amount = trim($request->cost) - trim($request->advance_payment);

            if(!empty($request->months) || !empty($request->monthly_emi)) {
                $emi = $this->getEmi($amount, $request->rate, $request->months);

                $obj->months = $request->months;
                $obj->rate = $request->interest_rate;
                $obj->monthly_emi = $emi;
                $obj->payment_type = 1;
            }

            if($obj->save()) {

                // Store the advance payment
                $advance_payment_date = date('Y-m-d');
                $advance_payment_data = [
                    'company_id'=>Auth::user()->company_id,
                    'order_id' => $obj->id,
                    'customer_id' => $obj->customer_id,
                    'month' => 0,
                    'emi_amount' => $obj->advance_amount,
                    'invoice_date' => date('Y-m-d', strtotime($advance_payment_date)),
                    'due_date' => date('Y-m-d', strtotime($advance_payment_date.' + '.$due_after_days.' days')),
                    'status' => 0
                ];

                $advance_payment_obj = OrderEmi::create($advance_payment_data);

                
                // Store the emi payments
                for($i=1; $i<=$obj->months; $i++){

                    $data = [
                        'company_id'=>Auth::user()->company_id,
                        'order_id' => $obj->id,
                        'customer_id' => $obj->customer_id,
                        'month' => $i,
                        'emi_amount' => $obj->monthly_emi,
                        'invoice_date' => date('Y-m-d', strtotime($invoice_date.' + '.$i.' months')),
                        'due_date' => date('Y-m-d', strtotime($due_date.' + '.$i.' months')),
                        'status' => 0
                    ];

                    $emi_obj = OrderEmi::create($data);
                }

            }

            $msg = 'Order Has Been Generated Successfully!';

        } 
        catch(\Exception $e)
        {
            DB::rollback();
            // throw $e;
            $msg = "There might be some error. Try Again!";

        }

        DB::commit();
        
        return response()->json(['msg'=>$msg]);
    }



    public function order_details(Request $request) {
        $order = Order::with(['property:id,title,size', 'project:id,title,city,address,pincode', 'property_type:id,name'])->find($request->id);

        $data = [
            'project' => $order->project->title,
            'location' => $order->project->address.', '.$order->project->city.' - '.$order->project->pincode,
            'property' => $order->property->title.' ('.$order->property->size.')',
            'property_type' => $order->property_type->name,
            'order_ref' => $order->order_ref,
            'amount' => 'Rs. '.number_format($order->total_amount),
            'advance' => 'Rs. '.number_format($order->advance_amount),
            'months' => $order->months,
            'emi_amount' => 'Rs. '.number_format($order->monthly_emi),
            'order_date' => date('d M, Y', strtotime($order->order_date)),
            'emi_paid' => $order->emi_paid,
            'upcoming_emi_date' => date('d M, Y', strtotime($order->upcoming_emi_date)),
        ];


        return $data;
    }



    public function emi_details(Request $request) 
    {
        $data = OrderEmi::where('order_id', $request->id)
                        ->when($request->status, function ($query) {
                            $query->where('status', $request->status);
                        })
                        ->orderBy('month')
                        ->get();

        $change = 0;

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("backend_assets/images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('emi_month', function($row){ 
                        return strtoupper(date('M-y', strtotime($row->due_date)));                     
                        }) 
                ->editColumn('month', function($row){ 
                        if($row->month == 0) {
                            return "<span class='badge bg-info text-end' >Advance Payment</span>";
                        }
                        else {
                            return "<span class='badge bg-primary text-end' >EMI: ".$row->month ."</span>";
                        }                                      
                        }) 
                ->editColumn('due_date', function($row){ 
                        return date('d M, Y', strtotime($row->due_date));                     
                        }) 
                ->editColumn('emi_amount', function($row){ 
                        return 'Rs. '.number_format($row->emi_amount);                     
                        }) 
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                        }) 
                ->addColumn('action', function($row) use (&$change){

                        $btn = '';

                        if($row->status == 0 && $change == 0) {
                            $btn = $btn.' <button type="button" onclick="show_invoice('.$row->id.')" title="Invoice" class="btn btn-primary btn-sm"><i class="fa fa-file-invoice"></i> Invoice</button>';

                            $change = 1;
                        }
                        
                        
                        if($row->status == 1) {
                            $btn = $btn.' <button type="button" onclick="show_receipt('.$row->id.')" title="Reciept" class="btn btn-primary btn-sm"><i class="fas fa-receipt"></i> Receipt</button>';
                        }

                        return $btn;
                })
                ->rawColumns(['country','month', 'status', 'action'])
                ->make(true);
        
        return response()->json($data);
    }

    


    public function save_order(Request $request)
    {
        $data = session()->get('data');

        $current_order = Quote::where('lead_id_fk', '=', $request->lead_id)->where('status', '=', 1)->get()->first();

        $order_id = null;
        if($current_order){
            $order_id = $current_order->id;

            if($current_order->is_quoted == 1) {
                $delete_order = Quote::find($current_order->id)->delete();
                $delete = QuoteDetail::where('quote_id_fk', '=', $order_id)->delete();
            }
            else {
                $delete = QuoteDetail::where('quote_id_fk', '=', $order_id)->forceDelete();
            }
        }

        $res = Quote::updateOrCreate(
                        ['id' => $order_id, 'is_quoted'=>0],
                        [
                            'lead_id_fk'=>$request->lead_id,
                            'customer_id_fk'=>$request->customer_id,
                            'quote_stage'=>1,
                            'quote_date'=>date('Y-m-d H:i:s'),
                            'due_date'=>date('Y-m-d', strtotime('+7 days')),
                            'created_by'=>Auth::user()->id,
                            'status'=>1
                        ]
                    );

        $cnt = Quote::where('lead_id_fk', $request->lead_id)->withTrashed()->get()->count();
        $cnt_padded = sprintf("%02d", $cnt);
        $quote_name = "QUO".$request->lead_id.'-'.$cnt_padded;

        foreach($data['cart'] as $key => $value)
        {
            $item = new QuoteDetail();
            $item->quote_id_fk = $res->id;
            $item->product_id_fk = $key;
            $item->name = $value['name'];
            $item->quantity = $value['quantity'];
            $item->price = $value['unit_price'];
            $item->tax = $value['tax'];
            $item->tax_amount = $value['tax_amount'];
            $item->cost = $value['sales_price']*$value['quantity'];
            $item->save();
        }

        $amount = $this->total_quote_cost($res->id);
        $update = Quote::where('id', '=', $res->id)->update(['amount'=>$amount, 'quote_name'=>$quote_name]);
        session()->put('cart', []);

        return response()->json(['msg'=>'Quote Has Been Generated Successfully!']);
    }

    public function total_quote_cost($quote_id)
    {
        $order = Quote::find($quote_id);

        $objects = QuoteDetail::where('quote_id_fk', '=', $quote_id)->get();

        $amount = 0;

        foreach($objects as $obj)
        {
            $amount += $obj->cost;
        }

        return $amount;
    }

    public function total_order_cost($order_id)
    {
        $order = Order::find($order_id);

        $objects = OrderDetail::where('order_id_fk', '=', $order_id)->get();

        $amount = 0;

        foreach($objects as $obj)
        {
            $amount += $obj->cost;
        }

        return $amount;
    }



    public function lead_order(Request $request, $lead_id)
    {
        $cart = array();
        $quote = Quote::where('status', '=', 1)->where('lead_id_fk', '=', $lead_id)->get()->first();

        $customer_id = '';

        if(!is_null($quote))
        {
        	$customer_id = $quote->customer_id;

            $quote_items = QuoteDetail::where('quote_id_fk', '=', $quote->id)->select('name', 'price', 'quantity', 'tax', 'tax_amount', 'cost', 'product_id_fk as product_id', 'id')->get();

            foreach($quote_items as $item)
            {
                $cart[$item->product_id] = [
                        "name" => $item->name,
                        "quantity" => $item->quantity,
                        "unit_price" => $item->price,
                        "sales_price" => $item->cost/$item->quantity,
                        "tax" => $item->tax,
                        "tax_amount" => $item->tax_amount,
                        "total_sales_price" => $item->cost,
                        "id" => $item->product_id_fk,
                        "order_detail_id" => $item->id
                    ];
            }
        }

        $data = array('cart'=>$cart);
        session()->put('data', $data);


        $stages = OrderStage::pluck('stage', 'id')->toArray();
        $stage_bg = OrderStage::pluck('stage_bg', 'id')->toArray();
        $products = Product::where('status', 1)->pluck('name', 'id')->toArray();
        $lead = Lead::find($lead_id);
        //$deleted_quotes = $this->deleted_quotes($lead_id);
        return view('pages/lead/lead_order', compact('lead', 'lead_id', 'quote', 'cart', 'stages', 'stage_bg', 'products', 'customer_id'));
    }


    public function lead_order_ajax($lead_id)
    {
        $data = session()->get('data');
        $products = Product::where('status', 1)->pluck('name', 'id')->toArray();
        $lead = Lead::find($lead_id);
        //$deleted_quotes = $this->deleted_quotes($lead_id);
        return view('pages/lead/lead_order', compact('lead', 'lead_id', 'products', 'data'));
    }


    public function lead_quotes(Request $request, $lead_id)
    {
        $cart = array();
        $quote = Quote::with('user')->where('status', '=', 1)
                ->where('lead_id_fk', '=', $lead_id)->get()->first();

        $lead = Lead::find($lead_id);

        if(!is_null($quote))
        {
            $quote_items = QuoteDetail::where('quote_id_fk', '=', $quote->id)->select('name', 'price', 'quantity', 'tax', 'tax_amount', 'product_id_fk as id', 'cost')->get()->toArray();

            foreach($quote_items as $item)
            {
                $cart[$item['id']] = $item;
            }
        }

        $stages = OrderStage::pluck('stage', 'id')->toArray();
        $stage_bg = OrderStage::pluck('stage_bg', 'id')->toArray();

        $deleted_quotes = $this->deleted_quotes($lead_id);
        //$deleted_quotes = [];
        return view('pages/lead/lead_quote', compact('lead_id', 'lead', 'quote', 'stage_bg', 'cart', 'deleted_quotes', 'stages'));
    }



    public function send_mail(Request $request)
    {
        $to_name = 'Shivam Kashyap';
        $to_email = 'cool.shivi8@gmail.com';
        $data = array('name' => 'Laravel', 'body' => 'A test Mail');

        Mail::send('mails.quote_mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Laravel Test Mail');
            $message->from('shivam15mar@gmail.com', 'Test Mail');
        });
    }




    public function deleted_quotes($lead_id)
    {
        $deleted_orders = array();
        $orders = Quote::where('lead_id_fk', '=', $lead_id)->orderBy('created_at', 'desc')->onlyTrashed()->get();

        if(!is_null($orders))
        {
            foreach($orders as $order)
            {
                $cart = array();
                $order_items = QuoteDetail::where('quote_id_fk', '=', $order->id)->select('name', 'cost', 'quantity', 'product_id_fk as id')->onlyTrashed()->get()->toArray();

                foreach($order_items as $item)
                {
                    $cart[] = $item;
                }
                $data = array('order'=>$order, 'cart'=>$cart);
                $deleted_orders[] = $data;
            }
        }
        return $deleted_orders;

    }



    public function create_quote(Request $request, $order_id)
    {
        $amount = $this->total_order_cost($order_id);

        $this->validate($request, [
               'created_at' => 'required',
               'due_date' => 'required',
            ],[

               'created_at.required' => 'Creation Date is required.',
               'due_date.required' => 'Due Date is required.',
            ]);

        $obj = SaleOrdersModel::find($order_id);
        $obj->created_at = $request->created_at;
        $obj->due_date = $request->due_date;
        $obj->subject = $request->mail_subject;
        $obj->instructions = $request->instructions;
        $obj->amount = $amount;
        $obj->order_stage = $request->order_stage;
        $obj->status = 1;
        $obj->created_by = 1;
        $obj->active = 1;
        $obj->save();




        return redirect()->back()->with('success', 'Quote has been created successfully. Thankyou!');

    }


    public function view_invoice()
    {
        
    }


    public function generatePDF(Request $request)
    {
        
        $emi_id = $request->e;

        $emi_data = OrderEmi::find($emi_id);

        $company_data = Company::find($emi_data->company_id);

        $order_data = Order::with(['property:id,title,size'])->find($emi_data->order_id);

        $customer_data = Customer::find($emi_data->customer_id);

        $invoice_terms = DefaultContent::where('type', 'INVOICE_TERMS')->where('status', 1)->first();
        $invoice_footer = DefaultContent::where('type', 'INVOICE_FOOTER')->where('status', 1)->first();

        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'emi_data' => $emi_data,
            'company_data' => $company_data,
            'order_data' => $order_data,
            'customer_data' => $customer_data,
            'invoice_terms' => !is_null($invoice_terms) ?  $invoice_terms->content : '',
            'invoice_footer' => !is_null($invoice_footer) ? $invoice_footer->content : ''
        ];

        if(isset($request->export) && $request->export == 'pdf') {
            view()->share('data',$data);

            $pdf = PDF::loadView('view-modals/emi_invoice');

            return $pdf->download('emi_invoice.pdf');
        }
        else {
            return view('view-modals/emi_invoice', compact('data'));
        }

        
    }



    public function generateReceipt(Request $request)
    {
        $payment_id = $request->e;

        $payment_data = CustomerPayment::find($payment_id);

        if(is_null($payment_data)) {
            // Emi id is not found || Incorrect EMI ID
            return response()->json(['success' => FALSE, 'message' => "Invalid EMI Details"]);
        }
        else {
            if($payment_data->status == 0) {
                // Payment has not verified yet.
                return response()->json(['success' => FALSE, 'message' => "Payment Details not Verified Yet"]); 
            }
            elseif($payment_data->status == 4) {
                // Incorrect Payment Details.
                return response()->json(['success' => FALSE, 'message' => "Incorrect Payment Details"]); 
            }
            else {
                $emi_data = OrderEmi::find($payment_data->emi_id);
                $company_data = Company::find($emi_data->company_id);
                $order_data = Order::with(['property:id,title,size'])->find($emi_data->order_id);
                $customer_data = Customer::find($emi_data->customer_id);
                $invoice_terms = DefaultContent::where('type', 'INVOICE_TERMS')->where('status', 1)->first();
                $invoice_footer = DefaultContent::where('type', 'INVOICE_FOOTER')->where('status', 1)->first();

    
                $data = [
                    'title' => 'Welcome to ItSolutionStuff.com',
                    'date' => date('m/d/Y'),
                    'emi_data' => $emi_data,
                    'company_data' => $company_data,
                    'order_data' => $order_data,
                    'customer_data' => $customer_data,
                    'payment_data' => $payment_data,
                    'invoice_terms' => !is_null($invoice_terms) ?  $invoice_terms->content : '',
                    'invoice_footer' => !is_null($invoice_footer) ? $invoice_footer->content : ''
                ];
    
                if(isset($request->export) && $request->export == 'pdf') {
                    view()->share('data',$data);
                    $pdf = PDF::loadView('view-modals/emi_receipt');
                    return $pdf->download('emi_receipt.pdf');
                }
                else {
                    return view('view-modals/emi_receipt', compact('data'));
                }
            }
        }
        
    }



    public function receive_payments(Request $request)
    {
        $customers = Customer::where('status', 1)
                        ->when($request->cid, function ($query) use ($request) {
                            $query->where('id', $request->cid);
                        })
                        ->select("id", DB::raw("CONCAT(customers.first_name,' ',customers.last_name,' - ',customers.company) as full_name"))
                        ->orderBy('customers.first_name')->pluck('full_name', 'id')->toArray();

        $cid = isset($request->cid) ? $request->cid : false;
        
        return view('pages/order/receive_payments', compact('customers', 'cid'));
        
    }



    public function get_customer_orders_data(Request $request, $id) 
    {
        $orders_data = Order::with(['property:id,title,size', 'project:id,title,city'])->where('customer_id', $id)->get();

        $orders = [];
        foreach($orders_data as $order){
            $orders[$order->id] = $order->order_ref.' | '.$order->property->title.' - '.$order->project->city;
        }

        if(!empty($orders)) {
            return response()->json(['success' => TRUE, 'data' => $orders, 'msg' => "Data Found"]);
        }
        else {
            return response()->json(['success' => FALSE, 'data' => NULL, 'msg' => "No Data Found"]);
        }

    }
    


    public function get_order_emi_details(Request $request, $id)
    {
        $order = Order::with(['property:id,title,size', 'project:id,title,city,address,pincode', 'property_type:id,name'])->find($id);
        $customer = Customer::find($order->customer_id);
        $emi = OrderEmi::where('order_id', $id)->where('status', 0)->orderBy('id')->get()->first();
 
        if(!is_null($customer) &&  !is_null($emi) && !is_null($order)) {

            $check_payment = CustomerPayment::where('order_id', $id)->where('status', 0)->get()->count();

            if($check_payment == 0){
                $data = ['customer' => $customer, 'emi' => $emi, 'order' => $order];
                return response()->json(['success' => TRUE, 'data' => $data]);
            }
            else {
                return response()->json(['success' => FALSE, 'msg' => 'Previous Payments are pending to approve. Please approve!', 'data' => NULL]);
            }    
        }
        else {
            return response()->json(['success' => FALSE, 'data' => NULL]);
        }

    }


    public function store_payment(Request $request)
    {
        $this->validate($request, [
            'emi_id' => 'required',
            'customer_id' => 'required',
            'order_id' => 'required',
            'emi_amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'net_payable' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'payment_mode' => 'required',
            'payment_date' => 'required',
        ],[

            'emi_id.required' => 'Invalid data. Emi details missing.',
            'customer_id.required' => 'Invalid data. Customer details missing.',
            'emi_amount.required' => 'Invalid data. Emi amount details missing.',
            'payment_mode.required' => 'Mode of payment is required.',
            'payment_date.required' => 'Payment date Date is required.',
        ]);

        $emi_details = OrderEmi::find($request->emi_id);
        $emi_amount = $emi_details->emi_amount;

        $order_data = Order::find($request->order_id);
        $previous_balance = $order_data->current_balance;

        if($request->total_amount != $emi_amount + $previous_balance || $request->net_payable != $emi_amount + $previous_balance + $request->extra_charges) {
            $msg = "Invalid Emi Details";
            $success = false;
        }
        else {
            $data = new CustomerPayment();

            $balance = $request->net_payable - $request->amount_paid;

            $data->emi_id = $request->emi_id;
            $data->customer_id = $request->customer_id;
            $data->order_id = $request->order_id;
            $data->emi_amount = $request->emi_amount;
            $data->previous_balance = $request->previous_balance;
            $data->total_amount = $request->total_amount;
            $data->extra_charges = $request->extra_charges;
            $data->net_payable = $request->net_payable;
            $data->amount_paid = $request->amount_paid;
            $data->balance = $balance;
            $data->payment_mode = $request->payment_mode;
            $data->payment_date = $request->payment_date;
            $data->payment_ref_no = strtoupper($request->payment_ref_no);
            $data->payment_type = 1;
            $data->status = 0;
            $data->remarks = $request->remarks;

            if($data->save()) {
                $msg = "Payment Recieved Successfully";
                $success = true;
            }
            else {
                $msg = "Internal Server Error";
                $success = false;
            }

        }
        return response()->json(['success' => TRUE, 'msg' => $msg, 'data' => $data]);
    }




    public function confirm_payments(Request $request)
    {
        return view('pages.order.confirm_payments');    
    }



    public function get_awaited_payments_data(Request $request) 
    {
        $data = DB::table('customer_payments as c')
                    ->leftJoin('order_emis as e', 'c.emi_id', '=', 'e.id')
                    ->leftJoin('customers as cs', 'c.customer_id', '=', 'cs.id')
                    ->where('c.status', 0)
                    ->select('c.id', 'c.customer_id as customer_id', 'e.order_id', 'c.emi_id', 'e.month', 'c.amount_paid', 'c.payment_mode', 'c.payment_date', 'c.payment_type', 'c.status', 'cs.first_name', 'cs.last_name', 'cs.phone', 'c.remarks', 'c.payment_ref_no')
                    ->get();


        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){ 
                        return ucwords(strtolower($row->first_name).' '.strtolower($row->last_name));
                        }) 
                ->editColumn('payment_date', function($row){ 
                    return date('d M, Y', strtotime($row->payment_date));                     
                }) 
                ->editColumn('payment_ref_no', function($row){ 

                    $btn = ' <button type="button" title="'.$row->remarks.'" data-bs-toggle="tooltip" class="btn btn-info btn-sm">'.strtoupper($row->payment_ref_no).'</button>';
                    return  $btn;                     
                })
                ->editColumn('payment_mode', function($row){ 
                    return  ucwords($row->payment_mode);                     
                })  
                ->editColumn('amount_paid', function($row){ 
                    return 'Rs. '.number_format($row->amount_paid);                     
                }) 
                ->addColumn('months', function($row){ 
                    $btn = '';
                    if($row->payment_type == 1) {
                        $btn = $btn.' <span class="badge bg-primary"><strong>'.$row->month.' EMI</strong></span>';
                    }
                    else {
                        $btn = $btn.' <span class="badge bg-warning"><strong>Balance</strong></span>';
                    } 
                    return $btn;                 
                }) 
                
                ->addColumn('action', function($row){

                        $btn = "";
                        $btn = $btn.' <button type="button" onclick="view_payment('.$row->id.')" title="Accept Payment" data-bs-toggle="tooltip" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Approove</button>';
                         
                        $btn = $btn.' <button type="button" onclick="reject_payment('.$row->id.')" title="Reject Payment" data-bs-toggle="tooltip" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Reject</button>';
                        
                        
                        return $btn;
                })
                ->rawColumns(['status', 'action', 'months', 'payment_ref_no'])
                ->make(true);
        
        return response()->json($data);
    }




    public function view_payment_details(Request $request) 
    {
        $data['amount_paid'] = 55555;
        return view('view-modals/payment_details', compact('data'));
    }


    public function comfirm_payment_store(Request $request)
    {
        $id = $request->id;
        $remarks = $request->remarks;

        $obj = CustomerPayment::find($id);

        $check_previous = CustomerPayment::where('order_id', $obj->order_id)->where('emi_id', '<', $obj->emi_id)->where('status', 0)->get()->count();

        if($check_previous == 0) {
            $obj->audit_remarks = $remarks;
            $obj->audit_by = Auth::user()->id;
            $obj->audit_at = date('Y-m-d H:i:s');
            $obj->status = 1;
            
            if($obj->save()) {

                // Update Status on EMI Table
                $emi = OrderEmi::find($obj->emi_id);
                $emi->status = 1;
                $emi->balance = $obj->balance;
                $emi->transaction_id = $obj->id;
                $emi->save();

                // Update Balance on Order Table
                $order = Order::find($obj->order_id);
                $order->current_balance = $obj->balance;
                $order->save();
                
                $success = true;
                $msg = "Payment Confirmed Successfully";
            }
            else {
                $success = false;
                $msg = "Internal Server Error";
            }
        }
        else {
            $success = false;
            $msg = "Please confirm previous payments first";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg]);

    }




    public function reject_payment_store(Request $request)
    {
        $id = $request->id;
        $remarks = $request->remarks;

        $obj = CustomerPayment::find($id);
        $obj->audit_remarks = $remarks;
        $obj->audit_by = Auth::user()->id;
        $obj->audit_at = date('Y-m-d H:i:s');
        $obj->status = 4;
        
        if($obj->save()) {
            $success = true;
            $msg = "Payment Rejected Successfully";
        }
        else {
            $success = false;
            $msg = "Internal Server Error";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg]);

    }

}
