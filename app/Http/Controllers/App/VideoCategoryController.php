<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\VideoHasVideoCategoryGetter;
use App\Models\App\VideoCategoryGetter;

class VideoCategoryController extends BaseController
{
    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($url)
    {
        $model = VideoCategoryGetter::getByUrl($url);

        return view($this->getView('video-category.index'), [
            'breadcrumbs' => VideoCategoryGetter::getBredcrumbsForModelById($model, 'VideoCategoryGetter'),
            'items' => VideoHasVideoCategoryGetter::getListByCategory($model),
            'model' => $model
        ]);
    }
}
