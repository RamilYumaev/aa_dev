<?php

namespace frontend\controllers;

use backend\models\AisCg;
use dictionary\models\DictCompetitiveGroup;
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

    public function actionGetAisCg()
    {
        $sdoCg = DictCompetitiveGroup::find()->all();
        foreach ($sdoCg as $cg) {
            $aisFacultyId = $cg->faculty->ais_id;
            $aisSpecialtyId = $cg->specialty->ais_id;
            $aisSpecializationId = $cg->specialization->ais_id;

            $aisCg = AisCg::findCg($aisFacultyId,
                $aisSpecialtyId,
                $aisSpecializationId,
                AisCg::transformEducationForm($cg->education_form_id),
                $cg->financing_type_id, AisCg::transformYear($cg->year));

            if ($aisCg) {
                $cg->ais_id = $aisCg->id;
                $cg->passing_score = $aisCg->competition_mark;
                $cg->competition_count = $aisCg->competition_count;
                $cg->education_duration = $aisCg->education_duration;
                $cg->only_pay_status = $aisCg->only_pay_status;
                $cg->is_new_program = $aisCg->is_new_program;

                if (!$cg->save()) {
                    throw new \DomainException("ошибка при сохранении конкурсной группы");
                }
            } else {
                continue;
            }
        }
        return "Success";
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
