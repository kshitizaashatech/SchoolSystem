<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function generateToken()
    {
        $api_token = str_random(120);
        return $api_token;
    }

    protected function auth()
    {
        $user = User::with(['brands','banks'])->where('api_token', $this->request->header('Authorization'))->first();
        if ($user) {
            return $user;
        } else {
            return null;
        }
    }

    public function TESRResponse($message, $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'success' => true
        ]);
    }

    public function SmsSuccessResponse($message, $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'success' => true,
            'code' => $code,
        ], $code);
    }

    public function SmsErrorResponse($message, $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'success' => false,
            'code' => $code,
        ], $code);
    }

    public function successResponse($message, $data, $code = Response::HTTP_OK, $key= 'key', $keyValue = false)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'total' => 0,//$total, Santosh commented this as there is no total variable in this class or function.
            'success' => true,
            'code' => $code,
            $key => $keyValue
        ], $code);
    }

    public function errorResponse($message, $data = null, $code = Response::HTTP_OK,$key= 'key',$keyValue= null)
    {
        $log = json_encode($message);
        if(is_array($data)){
            $log = json_encode($data);
        }
        \Log::info('SMError -' .  $log);
        return response()->json([
            'message' => $message,
            'data' => $data,
            'success' => false,
            'code' => $code,
            $key => $keyValue
        ], $code);
    }

    public function validation($errors)
    {
        $message = '';
        foreach ($errors->all() as $error){
            $message .= $error.',';
        }

        return \response()->json([
            'error' => $errors,
            'success' => false,
            'message' => rtrim($message, ','),
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function getDateFormatFileName($extension = null)
    {
        $fileName = rand();
        if ($extension) {
            $fileName = "{$fileName}.{$extension}";
        }
        return $fileName;
    }
    protected function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;

            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;

            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
