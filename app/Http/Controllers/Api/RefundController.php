<?php

namespace App\Http\Controllers\Api;

use App\Models\Refund;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Validator;

use DB;

     

class RefundController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reimbursement_list()
    {
        $id = auth('api')->user()->id;

        $refund = Refund::select('id', 'reimbursement_type', 'claim_amount', 'bill_amount','end_date')
        ->where('created_by', $id)
        ->get();
        
         // Return the leads as a JSON response
         return response()->json([
             'success' => true,
             'data' => $refund
         ], 200);
    }

    public function request_reimbursement(Request $request)
    {
        $this->validate($request,[
            'reimbursement_type' => 'required',
            'bill_number' => 'required',
            'bill_amount' => 'required',
            'claim_amount' => 'required',
            'start_date' => 'required',
        ],
        [
            'reimbursement_type.required' => 'Reimbursement type is required.',
            'bill_number.required' => 'Bill number is required.',
            'bill_amount.required' => 'Bill amount is required.',
            'claim_amount.required' => 'Claim amount is required',
            'start_date.required' => 'Date is required',
        ]);
        $id = auth('api')->user()->id;

        $refund = new Refund;
        $refund->reimbursement_type = $request->reimbursement_type;
        $refund->bill_number = $request->bill_number;
        $refund->bill_amount = $request->bill_amount;
        $refund->claim_amount = $request->claim_amount;
        $refund->start_date = $request->start_date;
        $refund->end_date = $request->end_date;
        $refund->remarks = $request->remarks;
        $refund->created_by = $id;
        $refund->save();

        return response()->json([
            'message' => 'Reinmbursement Posted Succesfully',
            'Reimbursement' => $refund
        ], 200);
    }
   
    public function reimbursement_details(request $request, $id)
    {
        $refund = Refund::select('reimbursement_type','bill_number','bill_amount','claim_amount','start_date','end_date','remarks','bill_attachment')->find($id);        
        if($refund){
            return response()->json([
                'success' => true,
                'data'=> $refund
            ], 200);
        }
    }
}