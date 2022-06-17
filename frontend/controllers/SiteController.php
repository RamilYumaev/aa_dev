<?php

namespace frontend\controllers;

use frontend\components\redirect\actions\ErrorAction;
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
    const LOG_FILE_PATH_NAME = '@frontendRuntime/logs/app.log';

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "@frontend/views/layouts/frontPage.php";
        //   \Yii::$app->user->switchIdentity();
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

    public function actionLogView()
    {
        $logFile = \Yii::getAlias(self::LOG_FILE_PATH_NAME);
        return $this->render('log-view', ['logFile' => $logFile]);
    }

    public function actionAppLogClear()
    {
        $logFile = \Yii::getAlias(self::LOG_FILE_PATH_NAME);
        \file_put_contents($logFile, '');

        return $this->redirect(['log-view']);
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
