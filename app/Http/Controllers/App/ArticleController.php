<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\ArticleGetter;
use App\Models\App\ArticleHasArticlesGetter;

class ArticleController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        return view($this->getView(), [
            'models' => ArticleGetter::getAllActive(),
            'breadcrumbs' => ArticleGetter::getBredcrumbsForAll()
        ]);
    }

    public function view(string $url)
    {
        $model = ArticleGetter::getByUrl($url);

        return view($this->getView('article.view'), [
            'model' => $model,
            'breadcrumbs' => ArticleGetter::getBredcrumbsForModelById($model, 'ArticleCategoryGetter'),
            'articles' => (new ArticleHasArticlesGetter())->getListByParentId($model->id),
            'otherModels' => ArticleGetter::getWithoutIds([$model->id], ArticleGetter::COUNT_GET_ARTICLES_IN_ARTICLE)
        ]);
    }
}