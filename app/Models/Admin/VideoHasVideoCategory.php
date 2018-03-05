<?php

namespace App\Models\Admin;

use App\CoreClasses\Models\BaseAdminModel;

class VideoHasVideoCategory extends BaseAdminModel
{
    public $timestamps = false;

    protected $table = 'video_has_video_category';
    protected $fillable = ['video_id', 'video_category_id'];

    /**
     * @param $id
     * @return mixed
     */
//    public static function getRelationsModel($id)
//    {
//        return self::where('video_id', $id)->pluck('video_category_id')->toArray();
//    }
}
