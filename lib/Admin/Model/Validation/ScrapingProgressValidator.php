<?php
namespace Admin\Model\Validation;

use Silex;

class ScrapingProgressValidator
{

    public static function validateValue(Silex\Application $app, $param, $action)
    {
        // エラー格納用配列
        $errors = array();

//         if ($action === 'edit') {
//             $app['validation.setting_article_viewnum.edit']($param, $errors);
//         }

        // 結果をコンテナに格納
        $app['validation.error'] = $errors;
    }
}
