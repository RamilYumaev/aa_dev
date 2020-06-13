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
    public $ids = [];
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
        if($this->fileExits() && in_array($this->owner->action->id, $this->ids)) {
            Yii::$app->session->setFlash("warning", 'Редактирование, удаление  
            невозможно, так как на странице "Загрузка документов" есть загруженная скан-копия документа');
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