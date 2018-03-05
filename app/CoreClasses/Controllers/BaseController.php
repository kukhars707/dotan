<?php

namespace App\CoreClasses\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller
{
    protected $view;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->view = Route::currentRouteName();
    }

    /**
     * @param null $view
     * @return string
     */
    protected function getView($view = null)
    {
        if ($view) {
            $this->view = $view;
        }

        return "app.$this->view";
    }
}
