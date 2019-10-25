<?php


namespace olympic\models\auth;


use yii\db\ActiveRecord;

class UserFaculty extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_faculty';
    }

    public static function create($faculty_id, $user_id)
    {
        $userFaculty = new static();
        $userFaculty->faculty_id = $faculty_id;
        $userFaculty->user_id = $user_id;
        return $userFaculty;
    }

    public function edit($faculty_id, $user_id)
    {
        $this->faculty_id = $faculty_id;
        $this->user_id = $user_id;
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'ФИО пользователя',
            'faculty_id' => 'Институт/Факультет',
        ];
    }

    public static function labels() {
        $userFaculty = new static();
        return $userFaculty->attributeLabels();
    }

}