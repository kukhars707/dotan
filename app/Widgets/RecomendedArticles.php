<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class RecomendedArticles extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */

    public function run()
    {
        return view('widgets.app.article.recomended_articles', [
            'config' => $this->config,
            'articles' => $this->getArticles()
        ]);
    }

    /**
     * @return array|mixed
     */
    public function getArticles()
    {
        if (count($this->config['articles'])) {
            return $this->config['articles'];
        }
        return [];
    }
}
