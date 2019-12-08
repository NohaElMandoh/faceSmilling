<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\selectedColorResource;
use App\models\CaptureImg;
use App\models\AllColor;
use App\models\ColorfulImgs;
use App\models\PartitionImg;
use App\models\FaceStatus;
use App\models\FacePartition;
use App\models\UserCode;
use \Validator;
use \Response;

class MainController extends  BaseController
{
    //users_code_id
    //colorful_imgs_id', 'true_attempts', 'wrong_attempts', 'random_code
    public function colorful_attemps(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'users_code_id' => 'required',
            'status' => 'required',
            'img_id'=>'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        $user_attempt=UserCode::find($request->users_code_id)->colorful_attempts()->attach($request->all());
        $user_attempt->pivot->status = 1;
        dd($user_attempt);

    }
   
    
    // -------General Apis--------
    // ------asign code to user----------
    public function add_code_to_user(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }

        $add_code = UserCode::create(
            [
                'code' => $request->code,
                'users_id'=>auth()->user()->id

            ]
        );

        if ($add_code) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'users_code_id'=>$add_code->id,
                'data' => [$add_code]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    // -------Add Colors------------
    public function add_color(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'hexa' => 'required',

        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }

        $add_color = AllColor::create(

            [
                'name' => $request->name,
                'hex' => $request->hexa,

            ]
        );



        if ($add_color) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => [$add_color]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    public function all_color(Request $request)
    {
      

        $all_color = AllColor::all();


        if ($all_color) {
            $data = [
                'status' => 200,
                'msg' => 'Done',
                'data' => $all_color
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 500,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    public function add_facePartition(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        $colorful_img = FacePartition::create($request->all());
        if ($colorful_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => [$colorful_img]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 500);
        }
    }
    // --------add img template -------
    public function add_template_photo(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'face_status_name' => 'required',
            'photo',
          
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        
        $face_status_id = FaceStatus::where('status', $request->face_status_name)->first();
        
        $capture_img = CaptureImg::create(

            [
                'face_status_id' => $face_status_id->id,
                'photo',
                'users_id' => auth()->user()->id,
            ]
        );

        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/capture_imgs/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $capture_img->update(['path' => 'uploads/capture_imgs/' . $name]);
        }


        if ($capture_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => [$capture_img]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    // ------First Activity---------
    public function select_photo_to_match(Request $request)
    {
        $capture_img = CaptureImg::all();
        if ($capture_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => $capture_img
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    public function add_photo(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'face_status_name' => 'required',
            'ellapsed_time' => 'required',
            'photo',
            'matching' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        
        $face_status_id = FaceStatus::where('status', $request->face_status_name)->first();
        
        $capture_img = CaptureImg::create(

            [
                'face_status_id' => $face_status_id->id,
                'ellapsed_time' => $request->ellapsed_time,
                'photo',
                'matching' => $request->matching,
                'users_id' => auth()->user()->id,
            ]
        );

        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/capture_imgs/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $capture_img->update(['path' => 'uploads/capture_imgs/' . $name]);
        }


        if ($capture_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => [$capture_img]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }

    // ------Second Activity---------
    public function select_colorful_photo_to_match(Request $request)
    {
        $colorful_img = ColorfulImgs::all();
        if ($colorful_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => $colorful_img
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    public function add_colorfulphoto(Request $request)
    {
       
        //'path', 'all_colors_id'
        $validation = Validator::make($request->all(), [
            'color_name' => 'required',
            'photo',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        // $color_id = AllColor::where('name', $request->color_name)->first();

        $colorful_img = ColorfulImgs::create(
            [
                'color' => $request->color,
                'photo',
                'user_id' => auth()->user()->id,
                'color_name'=> $request->color_name,
            ]
        );

        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/colourful_imgs/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $colorful_img->update(['photo' => 'uploads/colourful_imgs/' . $name]);
        }


        if ($colorful_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => [$colorful_img]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    // ----------third Activity------------
    public function select_facepartition_photo_to_match(Request $request)
    {
        $partion_img = PartitionImg::all();
        if ($partion_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => $partion_img
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
    public function add_partitionsphoto(Request $request)
    {
        //'face_partitions_id', 'ques', 'path'
        $validation = Validator::make($request->all(), [
            'partition_name' => 'required',
            'photo',
            'ques' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        $face_partitions_id = FacePartition::where('name', $request->partition_name)->first();

        $partition_img = PartitionImg::create(

            [
                'face_partitions_id' => $face_partitions_id->id,
                'ques' => $request->ques,
                'photo',
                'user_id'=>auth()->user()->id

            ]
        );

        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/partitions_imgs/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $partition_img->update(['path' => 'uploads/partitions_imgs/' . $name]);
        }


        if ($partition_img) {
            $data = [
                'status' => 1,
                'msg' => 'Done',
                'data' => [$partition_img]
            ];
            return Response::json($data, 200);
        } else {
            return Response::json([
                'data' => [
                    'status' => 0,
                    'message' => 'error',
                ]
            ], 200);
        }
    }
  public function add_selected_color(Request $request){
         $validation = Validator::make($request->all(), [
            'all_color_id' => 'required',
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $data = []);
        }
        if (!empty($request['all_color_id'])) {
auth()->user()->selectedColor()->sync($request->all_color_id);
            // foreach ($request['colors'] as $color_id) {
            //     // $color_id= AllColor::where('hex',$color)->get();
               
            // }
        }
        $data = [
            'status' => 200,
            'msg' => 'Done',
            'data' => ''
        ];
        return Response::json($data, 200);
    }
     public function get_selected_color(Request $request){
        
        
$selected_colors=auth()->user()->selectedColor()->get();
        // dd($selected_colors);
        $all_color = AllColor::all();
        $data = [
            'status' => 200,
            'msg' => 'Done',
            'data' => ['all'=>$all_color,'selected_color'=>selectedColorResource::collection($selected_colors)]
        ];
      
        return Response::json($data, 200);
    }
    
}
