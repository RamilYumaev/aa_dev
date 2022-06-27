<?php

namespace modules\entrant\behaviors;

use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\File;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\models\UserDiscipline;
use modules\entrant\models\UserIndividualAchievements;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;


class AnketaBehavior extends Behavior
{

    /**
     * @return array
     */

    /**
     * @var BaseActiveRecord
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeUpdate($event)
    {
        if($this->fileExits() && !$this->checkUpdate()) {
            throw  new  \DomainException("Редактирование невозможно, так как Вы уже загрузили сканы документов");
        }

        if($this->userIndividualAchievementsExists() && !$this->checkUpdate()) {
            UserIndividualAchievements::deleteAll($this->userWhere());
        }

        if($this->statementStatementIndividualAchievements() && !$this->checkUpdate()) {
            StatementIndividualAchievements::deleteAll($this->userWhere());
        }

        if($this->statementExists() && !$this->checkUpdate()) {
            Statement::deleteAll($this->userWhere());
        }
        
        if (!$this->checkCounty()) {
            if($this->userPassportExists()) {
                PassportData::deleteAll($this->userWhere());
            }
            if($this->userAddressExists()) {
                Address::deleteAll($this->userWhere());
            }
            if($this->userOtherDocsExists()) {
                OtherDocument::deleteAll($this->userWhere());
            }
            if($this->usersDocumentEducationExists()) {
                DocumentEducation::deleteAll($this->userWhere());
            }
        }
        if (!$this->checkEduLevel()) {
            if($this->usersDocumentEducationExists()) {
                DocumentEducation::deleteAll($this->userWhere());
            }
            if($this->userOtherDocsExists()) {
                OtherDocument::deleteAll($this->userWhere());
            }
        }
        if ($this->userCgExists() && !$this->checkUpdate()) {
            UserCg::deleteAll($this->userWhere());
        }
        if ($this->userDiscipline() && !$this->checkUpdate()) {
            UserDiscipline::deleteAll($this->userWhere());
        }
        if ($this->userSubmittedExists() && !$this->checkUpdate()) {
            SubmittedDocuments::deleteAll($this->userWhere());
        }
        if ($this->userAgreement() && !$this->checkUpdate()) {
            Agreement::deleteAll($this->userWhere());
        }
        if ($this->userExemption() && !$this->checkUpdate()) {
            OtherDocument::deleteAll(['user_id' => $this->owner->user_id, 'exemption_id'=> true]);
        }
    }

    private function userCgExists()
    {
        return UserCg::find()->andWhere($this->userWhere())->exists();
    }

    private function userDiscipline()
    {
        return UserDiscipline::find()->where($this->userWhere())->exists();
    }

    private function userAgreement()
    {
        return Agreement::find()->where($this->userWhere())->exists();
    }

    private function userExemption()
    {
        return  OtherDocument::find()->where($this->userWhere())->andWhere(['exemption_id'=> true])->exists();
    }

    private function userSubmittedExists()
    {
        return SubmittedDocuments::find()->where($this->userWhere())->exists();
    }

    private function userPassportExists()
    {
        return PassportData::find()->where($this->userWhere())->exists();
    }

    private function userAddressExists()
    {
        return Address::find()->where($this->userWhere())->exists();
    }

    private function userOtherDocsExists()
    {
        return OtherDocument::find()->where($this->userWhere())->exists();
    }

    private function usersDocumentEducationExists()
    {
        return DocumentEducation::find()->where($this->userWhere())->exists();
    }

    private function userIndividualAchievementsExists()
    {
        return UserIndividualAchievements::find()->where($this->userWhere())->exists();
    }

    private function statementExists()
    {
        return Statement::find()->where($this->userWhere())->exists();
    }

    private function statementStatementIndividualAchievements()
    {
        return StatementIndividualAchievements::find()->where($this->userWhere())->exists();
    }


    private function fileExits()
    {
        return File::find()->where($this->userWhere())->exists();
    }


    private function checkUpdate()
    {
        return $this->owner->oldAttributes == $this->owner->attributes;
    }

    private function checkCounty()
    {
        return $this->owner->oldAttributes['citizenship_id'] == $this->owner->attributes['citizenship_id'];
    }

    private function checkEduLevel()
    {
        return $this->owner->oldAttributes['current_edu_level'] == $this->owner->attributes['current_edu_level'];
    }

    private function userWhere() {
        return ['user_id' => $this->owner->user_id];
    }
}