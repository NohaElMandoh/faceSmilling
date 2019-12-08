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

class BaseController extends Controller
{
    function responseJson($status, $msg, $data = null)
{
    $response = [
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    ];
    return response()->json($response);
}

}
