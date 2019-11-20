<?php

namespace frontend\controllers;

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
                'class' => 'yii\web\ErrorAction',
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

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionClearCache()
    {
        $frontendAssets = Yii::getAlias("@frontend") . "/web/assets";
        $backendAssets = Yii::getAlias("@backend") . "/web/assets";

        $this->removeDir($frontendAssets);
        $this->removeDir($backendAssets);

        $this->makeDir($frontendAssets);
        $this->makeDir($backendAssets);

        return "Папки assets очищены";


    }

    private function removeDir($dir)
    {
        $files = array_diff(scandir($dir), ['..', '.']);

        foreach ($files as $file) {
            $path = $dir . "/" . $file;
            if (is_dir($path)) {
                $this->removeDir($path);
            } else {
                unlink($path);
            }
        }

        if (!rmdir($dir)) {
            die("Не удалось закончить операцию удаления!");
        };
    }

    private function makeDir($dir)
    {
        mkdir($dir);
    }
}
