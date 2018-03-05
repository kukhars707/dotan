<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\ArticleCategoryGetter;
use App\Models\App\ArticleHasArticleCategory;

class ArticleCategoryController extends BaseController
{
    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($url)
    {
        $model = ArticleCategoryGetter::getByUrl($url);

        return view($this->getView('article-category.view'), [
            'model' => $model,
            'breadcrumbs' => ArticleCategoryGetter::getBredcrumbsForModelById($model, 'ArticleCategoryGetter'),
//            'articles' => (new ArticleHasArticlesGetter())->getListByParentId($model->id),
            'articles' => ArticleHasArticleCategory::getModelsByCategoryId($model->id),
//            'otherModels' => ArticleGetter::getWithoutIds([$model->id], ArticleGetter::COUNT_GET_ARTICLES_IN_ARTICLE)
        ]);
    }
}
