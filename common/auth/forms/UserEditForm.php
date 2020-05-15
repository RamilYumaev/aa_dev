<?php


namespace common\auth\forms;

use common\auth\models\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;

    public $_user;

    public function __construct(\common\auth\models\User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }

    public function attributeLabels()
    {
        return (new User())->attributeLabels();
    }


}