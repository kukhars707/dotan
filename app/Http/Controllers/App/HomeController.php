<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\ManualGetter;

class HomeController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lastManual = ManualGetter::getFirst();

        return view($this->getView(), [
            'lastManual' => $lastManual,
            'manuals' => !is_null($lastManual) ? ManualGetter::getWithoutIds([$lastManual->id]) : []
        ]);
    }
}
