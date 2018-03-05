<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class VideoGetter extends BaseModel
{
    protected $table = 'videos';
    protected $titleForCrumb = 'Видео';
    protected $urlForCrumb = 'video';
    protected $parentFieldPivot = 'video_category_id';

    /**
     * @param array $array
     * @return mixed
     */
    public function getListByArray(array $array)
    {
        return self::whereIn('video_category_id',$array)->paginate();
    }
}
