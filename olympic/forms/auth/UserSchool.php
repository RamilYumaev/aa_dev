<?php


namespace olympic\forms\auth;


class UserSchool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'class_id'], 'required'],
            [['user_id', 'school_id', 'class_id'], 'integer'],
            [['user_id', 'school_id', 'class_id'], 'unique', 'targetAttribute' => ['user_id', 'school_id', 'class_id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSchoolsPreModeration::className(), 'targetAttribute' => ['school_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictClass::className(), 'targetAttribute' => ['class_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'school_id' => 'Название учебной организации',
            'class_id' => 'Текущий класс (курс)',
        ];
    }

}