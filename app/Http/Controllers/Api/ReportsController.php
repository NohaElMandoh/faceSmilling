<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\CaptureImg;
use App\models\AllColor;
use App\models\ColorfulImgs;
use App\models\ColorfulImgUser;
use App\models\CaptureImgUser;
use App\models\PartitionImg;
use App\models\FaceStatus;
use App\models\FacePartition;
use App\models\UserCode;

use App\Http\Resources\ColorReportResource;
use App\Http\Resources\MonthResource;
use App\Http\Resources\ColorResource;
use \Validator;
use \Response;
use DateTime;

class ReportsController extends Controller
{

    public function partition_reports(Request $request)
    {
        $arrNewSku['pivot'] = array();
        $arrResult = array();

        $success_count = 0;
        $faild_count = 0;
        $user = auth()->user();

        $tt = $user->partition_attempts()->get();
        for ($i = 0; $i < count($tt); $i++) {
            if ($tt[$i]->pivot['status'] == 1) $success_count++;
            else $faild_count++;
        }
        $arrNewSku['success'] = $success_count;
        $arrNewSku['faild'] = $faild_count;
        return response()->json($arrNewSku);
  
    }
    public function colourful_attempt_details(Request $request)
    {
        $arrResult = [];
        $success_count = 0;
        $faild_count = 0;
        $user = auth()->user();
        $tt = $user->colorful_attempts()->get();

        foreach ($tt as $t) {

            if ($t->pivot->code == $request->code && $t->pivot->created_at->format('m') == $request->month) {

                if ($t->pivot['status'] == 1) $success_count++;
                else $faild_count++;
                array_push($arrResult, $t->pivot);
            }
        }
        if (!empty($arrResult)) {
            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => ['details' => $arrResult, 'success' => $success_count, 'faild' => $faild_count]
            ];
        } else {
            $response = [
                'status' => 500,
                'msg' => 'error',
                'data' => ' '
            ];
        }


        return response()->json($response);
    }
    public function match_attempt_details(Request $request)
    {
        $arrNewSku['pivot'] = array();
        $arrResult['pivot'] = array();

        $success_count = 0;
        $faild_count = 0;
        $user = auth()->user();
        $tt = $user->match_attempts()->get();

        foreach ($tt as $t) {
            if ($t->pivot->created_at == $request->created_at) {
                array_push($arrNewSku['pivot'], $t);
            }
        }

        if (!empty($arrNewSku['pivot']) || !empty($arrNewSku['success']) || !empty($arrNewSku['faild'])) {

            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => $arrNewSku
            ];
        } else {
            $response = [
                'status' => 500,
                'msg' => 'error',
                'data' => ' '
            ];
        }
        return response()->json($response);
    }
    //     
    public function colourful_reports(Request $request)
    {
        $arrNewSku['pivot'] = array();
        $result = [];

        $user = auth()->user();
        $tt = $user->colorful_attempts()->get();
        if (count($tt)) {
            $result = collect(ColorReportResource::collection($tt))
                ->keyBy->code->values()->groupBy('month');
            // Y/m/d H:i:s
        };
        if (!empty($result)) {

            $data = [
                'status' => 200,
                'msg' => 'Done',

                'data' => $result


            ];
        } else {

            $data = [
                'status' => 500,
                'msg' => 'error',
                'data' => 'No Attempts '
            ];
        }

        return Response::json($data, 200);
    }
    public function match_reports(Request $request)
    {
        $result = [];
        $user = auth()->user();
        $tt = auth()->user()->match_attempts()->get();

        if (count($user->match_attempts()->get())) {
            $result = $tt->groupBy([function ($item) {
                return $item->pivot->created_at->format('m');
                // Y/m/d H:i:s
            }]);
        }
        if (!empty($result)) {
            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => ['pivot' => $result]
            ];
        } else {
            $response = [
                'status' => 500,
                'msg' => 'error',
                'data' => 'No Attempts '
            ];
        }
        return response()->json($response);
    }
    public function delete_colorful_attempts(Request $request)
    {
        // $review->product()->detach()
        $arrNewSku['pivot'] = array();
        $arrResult['pivot'] = array();

        $p = '';
        $tt = auth()->user()->colorful_attempts()->get();
        foreach ($tt as $t) {
            if ($t->pivot->code == $request->code) {
                $p = ColorfulImgUser::find($t->pivot->id)->delete();
            }
        }

        if ($p) {
            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => $p
            ];
        } else {
            $response = [
                'status' => 500,
                'msg' => 'error',
                'data' => 'Attempt Not Found '
            ];
        }
        return response()->json($response);
    }
    public function delete_match_attempts(Request $request)
    {

        $p = '';
        $tt = auth()->user()->match_attempts()->get();
        foreach ($tt as $t) {
            if ($t->pivot->created_at == $request->created_at) {
                $p = CaptureImgUser::find($t->pivot->id)->delete();
            }
        }
        if ($p) {
            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => $p
            ];
        } else {
            $response = [
                'status' => 500,
                'msg' => 'error',
                'data' => 'Attempt Not found'
            ];
        }
        return response()->json($response);
    }
    public function delete_all_attempts(Request $request)
    {

        $flage = 0;
        if ($request->has('colorful') && $request->colourful = 1) {
            if (auth()->user()->colorful_attempts()->detach())
                $flage = 1;
        }
        if ($request->has('simulation') && $request->simulation = 1) {
            if (auth()->user()->match_attempts()->detach())

                $flage = 1;
        }
        if ($request->has('partitions') && $request->partitions = 1) {
            if (auth()->user()->partition_attempts()->detach())

                $flage = 1;
        }
        if ($flage = 1) {
            $response = [
                'status' => 200,
                'msg' => 'Done',
                'data' => 'Reports Deleted'
            ];
        } else {
            $response = [
                'status' => 500,
                'msg' => 'error',
                'data' => 'Attempt Not Found '
            ];
        }
        return response()->json($response);
    }
}
