<?php
/**
 * Created by PhpStorm.
 * User: Виталик
 * Date: 21.01.2018
 * Time: 15:55
 */

namespace App\Traits;


trait AdminValidateTrait
{
    /**
     * @param $currentId
     * @param $table
     * @return string
     */
    public function getRileForUniqueData($currentId, $table)
    {
        $str = '';
        $i = 0;
        $tables = ['articles', 'article_categories', 'images', 'image_categories', 'manuals', 'pages', 'videos', 'video_categories'];

        $countTables = count($tables);
        foreach ($tables as $item) {
            $id = '';
            if ($item == $table) {
                $id = ",$currentId";
            }

            $str .= "unique:$item,url" . $id;
            $str .= $i < $countTables ? "|" : "";
            $i++;
        }

        return $str;
    }
}