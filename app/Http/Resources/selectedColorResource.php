<?php

namespace App\Http\Resources;

use App\models\ColorfulImgs;
use Illuminate\Http\Resources\Json\JsonResource;

class selectedColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
        "id"=>$this->id,
        "created_at"=>$this->created_at,
        "updated_at"=>$this->updated_at,
        "name"=>$this->name,
        "hex"=>$this->hex,
        "img_path"=>ColorfulImgs::where("name",$this->name)->get()
        // "img_path"=>$this->hex,

        // "deleted_at": null,
        // "pivot": {
        //     "user_id": "2",
        //     "all_color_id": "8",
        //     "created_at": "2019-11-18 19:17:18",
        //     "updated_at": "2019-11-18 19:17:18"
        // }
        ];
    }
}
