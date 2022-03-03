<?php

namespace modules\literature\models;

use common\auth\models\User;
use Yii;

/**
 * This is the model class for table "user_persons_literature".
 *
 * @property int $persons_literature_id
 * @property int $user_id
 *
 * @property PersonsLiterature $personsLiterature
 * @property User $user
 */
class UserPersonsLiterature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_persons_literature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['persons_literature_id', 'user_id'], 'required'],
            [['persons_literature_id', 'user_id'], 'integer'],
            [['persons_literature_id', 'user_id'], 'unique', 'targetAttribute' => ['persons_literature_id', 'user_id']],
            [['persons_literature_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonsLiterature::className(), 'targetAttribute' => ['persons_literature_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'persons_literature_id' => 'Persons Literature ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[PersonsLiterature]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonsLiterature()
    {
        return $this->hasOne(PersonsLiterature::className(), ['id' => 'persons_literature_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
