<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function send_response($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function send_error($error, $err_message = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($err_message)){
            $response['data'] = $err_message;
        }
        
        return response()->json($response, $code);
    }

    function upload_file($filename="",$file) {
		$tujuan_upload = 'uploads';

		$file->move($tujuan_upload, $filename);
	}

    function izrand($length = 32, $numeric = false) {

		$random_string = "";
		while(strlen($random_string)<$length && $length > 0) {
			if($numeric === false) {
				$randnum = mt_rand(0,61);
				$random_string .= ($randnum < 10) ?
					chr($randnum+48) : ($randnum < 36 ?
						chr($randnum+55) : chr($randnum+61));
			} else {
				$randnum = mt_rand(0,9);
				$random_string .= chr($randnum+48);
			}
		}
		return $random_string;
	}
}
