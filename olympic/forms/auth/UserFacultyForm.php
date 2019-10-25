<?php


namespace olympic\forms\auth;


use olympic\helpers\dictionary\DictFacultyHelper;
use olympic\models\auth\UserFaculty;
use yii\base\Model;

class UserFacultyForm extends Model
{
    public $user_id, $faculty_id;

    public function __construct(UserFaculty $userFaculty = null, $config = [])
    {
        if($userFaculty) {
            $this->user_id = $userFaculty->user_id;
            $this->faculty_id = $userFaculty->faculty_id;

        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            ['user_id', 'unique', 'targetClass'=> UserFaculty::class,
                'message' => 'Этому пользователю уже назначен факультет'],
            ['faculty_id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return UserFaculty::labels();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function userList(): array
    {
        //@TODO узнать как вывести преподов факультетов
    }

}