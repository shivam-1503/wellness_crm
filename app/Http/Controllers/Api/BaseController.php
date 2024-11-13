<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }


    

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function post_curl($data, $url)
    {
        // $access_token = isset($session_data && $session_data['token']) ? $session_data['token']:'';
        $access_token = '';

        try {
            $post_data = json_encode(['number' => $data]);

            $headers = array(
                                'cache-control: no-cache',
                                'Content-Type: application/json',
                            );
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curl, CURLOPT_USERPWD, env("RZ_KEY_ID") . ':' . env("RZ_SECRET_KEY"));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                echo "CURL Error #:" . $err;
            } 
            else {
                return response()->json(["code"=>$httpcode, "response"=>$response], TRUE);
            }
        } 
        catch(\Exception $e)
        {
            throw $e;
        }

        return response()->json($response);
    }


}