<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    

    public function register(Request $request)
    {
        // 'Gender','department_id'
        $validation = validator()->make($request->all(), [
            'email' => 'required',
            'name' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $api_token = str_random(60);
        $request->merge(array('api_token' => $api_token));
        $request->merge(array('password' => bcrypt($request->password)));
        $user = User::create($request->all());
       
        if ($user) {

            $data =[
                'msg'=>'تم التسجيل بنجاح',
                'api_token' => $api_token,
                'user' => [$user],
            ];
            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => $data
            ];

            return response()->json($response);

        } else {
            return Response::json('error',500);
        }
        
      

    }
    public function login(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = User::where('email', $request->input('email'))->first();
        if ($user)
        {
            if (Hash::check($request->password, $user->password))
            {
                $data = [
                    'api_token' => $user->api_token,
                ];
                return responseJson(1,'تم تسجيل الدخول',$data);
            }else{
                return responseJson(0,'بيانات الدخول غير صحيحة');
            }
        }else{
            return responseJson(0,'بيانات الدخول غير صحيحة');
        }
    }
 

}
