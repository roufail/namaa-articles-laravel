<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data,$message){
        $response = [
            'response' => $data,
            'message'  => $message
        ];
        return response()->json($response,200);
    }



    public function error($data,$message,$code=400){
    	$response = [
            'success' => false,
            'message' => $message,
        ];
        if(!empty($data)){
            $response['response'] = $data;
        }
        return response()->json($response, $code);
    }
    
}
