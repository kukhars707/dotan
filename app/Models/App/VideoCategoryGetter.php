<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class VideoCategoryGetter extends BaseModel
{
    protected $table = 'video_categories';
    protected $pivotManyTable = 'video_has_video_category';
    protected $pivotField = 'video_category_id';
    protected $joinTable = 'videos';
    protected $titleForCrumb = 'Видео';
    protected $urlForCrumb = 'video';

    /**
     * @param $id
     * @return mixed
     */
    public function getArrayByParentId($id)
    {
        return self::whereParentId($id)->get()->pluck('id')->toArray();
    }
}
