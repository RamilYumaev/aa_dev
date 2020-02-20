<?php

namespace frontend\controllers;

use frontend\components\redirect\actions\ErrorAction;
use frontend\components\UserNoEmail;
use yii\web\Controller;
use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function beforeAction($action)
    {
        return (new UserNoEmail())->redirect();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "@frontend/views/layouts/frontPage.php";
        return $this->render('index');
    }


    public function actionClearCache()
    {
        $frontendAssets = Yii::getAlias("@frontend") . "/web/assets";
        $backendAssets = Yii::getAlias("@backend") . "/web/assets";

        self::removeDir($frontendAssets);
        self::removeDir($backendAssets);

        return "Папки assets очищены";
    }

    private static function removeDir($dir)
    {
        foreach (\glob($dir . '/*') as $file) {
            if (\is_dir($file)) {
                self::removeDir($file);
            } else {
                \unlink($file);
            }
        }
    }

}
