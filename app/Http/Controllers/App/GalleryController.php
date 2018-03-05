<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\ImageGetter;

class GalleryController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        return view($this->getView(), [
            'models' => ImageGetter::getAllActive()
        ]);
    }

    public function view(string $url)
    {
        $model = ImageGetter::getByUrl($url);

        return view($this->getView('gallery.view'), [
            'breadcrumbs' => ImageGetter::getBredcrumbsForModelById($model,'ImageCategoryGetter'),
            'model' => $model,
            'otherModels' => ImageGetter::getWithoutIds([$model->id], ImageGetter::COUNT_PAGINATE_NEXT_AND_PREVIOS)
        ]);
    }
}
