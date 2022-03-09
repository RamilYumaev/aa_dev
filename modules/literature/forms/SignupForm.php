<?php

namespace modules\literature\forms;

use common\auth\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    const REGISTER = "register";
    const UPDATE = 'update';
    private $_id;

    public function scenarios()
    {
        return  [
            self::REGISTER => ['email', 'password', 'username', 'password_repeat'],
            self::UPDATE => ['email', 'username' ]
            ];
    }

    public function __construct(User $user = null, $config = [])
    {
        if($user) {
            $this->email = $user->email;
            $this->username = $user->username;
            $this->_id = $user->id;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            ['username', 'trim'],
            ['username', 'required'],
            $this->_id ?
                ['username', 'unique', 'targetClass' => User::class,  'filter' => ['<>', 'id', $this->_id], 'message' => 'Этот логин уже существует.'] :
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже существует.'],
            ['username', 'string', 'min' => 4, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            $this->_id ?
            ['email', 'unique', 'targetClass' => User::class,  'filter' => ['<>', 'id', $this->_id], 'message' => 'Этот адрес электронной почты уже существует.'] :
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже существует.'],

            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password',
                'message' => "Пароли не совпадают.", 'skipOnEmpty' => false,
                'when' => function ($model) {
                    return $model->password !== null && $model->password !== '';
                },
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Придумайте логин для личного кабинета (это может быть ваш email)',
            'email' => 'Адрес электронной почты:',
            'password' => 'Придумайте пароль',
            'password_repeat' => 'Повтор пароля',
        ];

    }
}