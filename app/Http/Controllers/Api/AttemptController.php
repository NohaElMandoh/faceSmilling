<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\CaptureImg;
use App\models\AllColor;
use App\models\ColorfulImgs;
use App\models\PartitionImg;
use App\models\FaceStatus;
use App\models\FacePartition;
use App\models\UserCode;
use \Validator;
use \Response;
use Carbon\Carbon;

class AttemptController extends BaseController
{
    public function partition_attemps(Request $request)
    {

        $validation = Validator::make($request->all(), [

            'status' => 'required',
            'img_id' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        $user=auth()->user();
        $readyItem = [
            $user->id => [
                'status' => $request->status,

            ]
        ];
        $user->partition_attempts()->attach($readyItem);

        $response = [
            'status' => 200,
            'msg' => 'Done',
            'data' => 'done'
        ];
        return response()->json($response);
    }
    public function colorful_attemps(Request $request)
    {

        $validation = Validator::make($request->all(), [

            'status' => 'required',
            'colorful_imgs_id' => 'required',
            'code' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }

        $user = auth()->user();
        $readyItem = [
            $user->id => [
                'colorful_imgs_id' => $request->colorful_imgs_id,
                'status' => $request->status,
                'selected_color' => $request->selected_color,
                'code' => $request->code,

            ]
        ];
        $user->colorful_attempts()->attach($readyItem);

        $response = [
            'status' => 200,
            'msg' => 'Done',
            'data' => 'done'
        ];
        return response()->json($response);
    }
    public function matching_attemps(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'status' => 'required',
            'capture_imgs_id' => 'required',
            'matching' => 'required',
            'ellapsed_time' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }


        $user = auth()->user();

        if ($request->hasFile('path')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/capture_imgs/'; // upload path
            $photo = $request->file('path');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            // $user->update(['path' => 'uploads/capture_imgs/' . $name]);

            $readyItem = [
                $user->id => [
                    'status' => $request->status,
                    'matching' => $request->matching,
                    'ellapsed_time' => $request->ellapsed_time,
                    'path' => 'uploads/capture_imgs/' . $name,
                    'capture_img_id' => $request->capture_imgs_id


                ]
            ];
        }
        $user->match_attempts()->attach($readyItem);
        $response = [
            'status' => 200,
            'msg' => 'Done',
            'data' => 'done'
        ];
        return response()->json($response);
    }
}
