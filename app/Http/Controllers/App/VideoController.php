<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\VideoGetter;

class VideoController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        return view($this->getView(), [
            'models' => VideoGetter::getAllActive(),
        ]);
    }

    /**
     * @param string $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(string $url)
    {
        $model = VideoGetter::getByUrl($url);

        return view($this->getView('video.view'), [
            'breadcrumbs' => VideoGetter::getBredcrumbsForModelById($model,'VideoCategoryGetter'),
            'model' => $model,
            'otherModels' => VideoGetter::getWithoutIds([$model->id], VideoGetter::COUNT_PAGINATE_NEXT_AND_PREVIOS)
        ]);
    }
}
