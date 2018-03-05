<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\PageGetter;

class PageController extends BaseController
{
    /**
     * @param string $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(string $url)
    {
        $model = PageGetter::getByUrl($url);

        return view($this->getView('page.view'), [
            'model' => $model,
        ]);
    }
}
