<?php

namespace modules\entrant\behaviors;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\models\CseViSelect;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\File;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\models\UserIndividualAchievements;
use yii\base\Behavior;
use yii\base\ExitException;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\User;
use Yii;


class AnketaRedirectBehavior  extends Behavior
{


    /**
     * @var Controller
     */
    public $owner;

    public function events()
    {
        return [
           Controller::EVENT_BEFORE_ACTION=> 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if($this->fileExits() && $this->owner->action->id == "step1") {
            Yii::$app->session->setFlash("warning", 'Редактирование "Определение условий подачи документов" невозможно, так как у вас имеется файл сканировния ');
            Yii::$app->getResponse()->redirect(['abiturient/post-document/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
    }


    private function fileExits()
    {
        return File::find()->where($this->userWhere())->exists();
    }


    private function userWhere() {
        return ['user_id' => Yii::$app->user->identity->getId()];
    }

}