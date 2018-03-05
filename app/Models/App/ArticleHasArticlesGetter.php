<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ArticleHasArticlesGetter extends BaseModel
{
    protected $table = 'article_has_articles';

    /**
     * @param int $articleId
     * @return mixed
     */
    public function getListByParentId(int $articleId)
    {
        return self::join('articles', 'articles.id', '=', "$this->table.article_id")
            ->where('articles.active', self::ACTIVE)
            ->where('article_has_articles.parent_article_id', $articleId)
            ->sort('articles')
            ->get();
    }
}
