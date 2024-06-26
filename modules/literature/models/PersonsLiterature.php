<?php

namespace modules\literature\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\auth\models\User;
use modules\entrant\helpers\DateFormatHelper;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "persons_literature".
 *
 * @property int $id
 * @property string $fio
 * @property int|null $sex
 * @property string $birthday
 * @property string $place_birth
 * @property string $phone
 * @property string $email
 * @property string $place_work
 * @property string $agree_file
 * @property string $post
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserPersonsLiterature[] $userPersonsLiteratures
 * @property User[] $users
 */
class PersonsLiterature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons_literature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'birthday', 'place_birth', 'phone', 'email', 'place_work', 'post'], 'required'],
            [['sex'], 'integer'],
            [['email'], 'email'],
            [['birthday'], 'safe'],
            [['fio'], 'match', 'pattern' => '/^[а-яёА-ЯЁ\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'unique', 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['email', 'unique'],
            [['phone'], PhoneInputValidator::class],
            [['fio', 'place_birth', 'email', 'place_work', 'post'], 'string', 'max' => 255],
            ['agree_file', 'file',
                'extensions' => 'pdf',
                'maxSize' => 1024 * 1024 * 10],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function getValue($property)
    {
        if ($property == "birthday") {
            return DateFormatHelper::formatView($this->$property);
        }
        return $this->$property;
    }

    protected function getProperty($property)
    {
        return $this->getAttributeLabel($property) . ": " . $this->getValue($property);
    }

    public function getDataFull()
    {
        $string = "";
        foreach ($this->getAttributes(null, ['sex', 'created_at', 'updated_at', 'agree_file']) as $key => $value) {
            if ($value) {
                $string .= $this->getProperty($key) . " ";
            }
        }
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'sex' => 'Пол',
            'birthday' => 'Дата рождения',
            'series' => 'Серия',
            'number' => 'Номер',
            'date_issue' => 'Дата выдачи',
            'authority' => 'Кем выдан?',
            'place_birth' => 'Место рождения',
            'phone' => 'Телефон',
            'email' => 'Email',
            'place_work' => 'Место работы',
            'post' => 'Должность',
            'agree_file' => 'Согласие на обработку персональных данных сопровождающего',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[UserPersonsLiteratures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPersonsLiteratures()
    {
        return $this->hasMany(UserPersonsLiterature::className(), ['persons_literature_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_persons_literature', ['persons_literature_id' => 'id']);
    }
}
