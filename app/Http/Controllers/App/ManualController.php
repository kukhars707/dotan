<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\ManualGetter;

class ManualController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        return view($this->getView(), [
            'models' => ManualGetter::getAllActive(),
            'breadcrumbs' => ''
        ]);
    }

    /**
     * @param string $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(string $url)
    {
        $model = ManualGetter::getByUrl($url);

        return view($this->getView('manual.view'), [
            'breadcrumbs' => ManualGetter::getBredcrumbsForModelById($model, 'ManualGetter'),
            'model' => $model,
            'otherModels' => ManualGetter::getWithoutIds([$model->id], ManualGetter::COUNT_PAGINATE_NEXT_AND_PREVIOS)
        ]);
    }
}
