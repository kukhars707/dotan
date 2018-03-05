<?php

namespace App\Http\Controllers\App;

use App\Models\App\ArticleCategoryGetter;
use App\Models\App\ArticleGetter;
use App\Models\App\ImageGetter;
use App\Models\App\ManualGetter;
use App\Models\App\PageGetter;
use App\Models\App\VideoCategoryGetter;
use App\Models\App\VideoGetter;
use App\Models\App\ImageCategoryGetter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChoiceController extends Controller
{
    private $url;
    private $paginate;
    private $method;
    private $nameSpace;

    public function __construct(Request $request)
    {
        $this->method = 'view';
        $this->nameSpace = 'App\Http\Controllers\App\\';
        $this->url = $request->segment(1);
        $this->paginate = $request->segment(2);
    }

    /**
     * @param Request $request
     */
    public function choiceController(Request $request)
    {
        if (is_numeric($this->paginate)) {

        }

        if (substr_count($_SERVER['REQUEST_URI'], '/') == 2) {
            $method = 'paginate';
            $current_url = explode("/", $_SERVER['REQUEST_URI'])[1];
        } else {
            $current_url = str_replace("/", "", $_SERVER['REQUEST_URI']);
        }

        $arrayControllers = [
            'ArticleController' => ArticleGetter::getExistModel($this->url),
            'ArticleCategoryController' => ArticleCategoryGetter::getExistModel($this->url),
            'VideoController' => VideoGetter::getExistModel($this->url),
            'GalleryController' => ImageGetter::getExistModel($this->url),
            'ManualController' => ManualGetter::getExistModel($this->url),
            'PageController' => PageGetter::getExistModel($this->url),
            'ImageCategoryController' => ImageCategoryGetter::getExistModel($this->url),
            'VideoCategoryController' => VideoCategoryGetter::getExistModel($this->url),
        ];

        $controllerChoice = array_search(true, $arrayControllers);

        if ($controllerChoice) {
            $controller_name = $this->nameSpace . $controllerChoice;
            $controller = new $controller_name();
            return $controller->{$this->method}($this->url, $request);
        }

        return abort(404);
    }
}
