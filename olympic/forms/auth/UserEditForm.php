<?php


namespace olympic\forms\auth;


use olympic\helpers\auth\RoleHelper;
use olympic\models\auth\AuthAssignment;
use common\auth\models\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $role;

    public $_user;

    public function __construct(\common\auth\models\User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $roles = AuthAssignment::getRoleName($user->id);
        $this->role = $roles ? reset($roles) : null;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'role'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }

    public function rolesList(): array
    {
        return RoleHelper::roleList();
    }
}