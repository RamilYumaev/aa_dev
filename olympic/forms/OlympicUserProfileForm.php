<?php
namespace olympic\forms;

use olympic\models\UserOlimpiads;
use yii\base\Model;
use yii\web\UploadedFile;

class OlympicUserProfileForm extends Model
{
    public $olympic_profile_id, $file;

    public function __construct(UserOlimpiads $userOlimpiads = null, $config = [])
    {
        if($userOlimpiads) {
            $this->olympic_profile_id = $userOlimpiads->olympic_profile_id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['olympic_profile_id'], 'required'],
            [['file'], 'file'],
            [['olympic_profile_id'], 'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'olympic_profile_id' => 'Напарвление - номинация олимпиады',
            'file'  => 'Согласие на обработку персональных данных несовершеннолетних участников'
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return true;
    }
}