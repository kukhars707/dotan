<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class VideoHasVideoCategoryGetter extends BaseModel
{
    protected $table = 'video_has_video_category';
    protected $pivotField = 'parent_id';

    /**
     * @param $category
     * @return mixed
     */
    public static function getListByCategory($category)
    {
        $list = (new VideoCategoryGetter)->getArrayByParentId($category->id);
        $array = count($list) ? $list : [$category->id];

        return (new VideoGetter())->getListByArray($array);
    }
}
