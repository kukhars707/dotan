<?php

namespace App\CoreClasses\Helpers;
/**
 * Created by PhpStorm.
 * User: Виталик
 * Date: 16.10.2017
 * Time: 3:11
 */
class StringHelper
{
    /**
     * @param $string
     * @param int $limit
     * @return string
     */
    public function getStringWithLimit($string, $limit = 20)
    {
        return str_limit(strip_tags($string, $limit));
    }

    /**
     * add blocks for main
     * @param $iteration
     * @return bool
     */
    public function checkIteration($iteration, $position)
    {
        $array = $position == 'open' ? [1, 5] : [4];

        return in_array($iteration, $array);
    }
}