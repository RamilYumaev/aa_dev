<?php

namespace common\auth\forms;
use common\auth\models\User;
use olympic\helpers\auth\ProfileHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserEmailForm extends Model
{
    public $email;
    protected $class;
    protected $unique;

    public function __construct($class=null, $unique = true, $config = [])
    {
        $this->unique = $unique;
        if ($class) {
            $this->class = $class;
        } else {
            $this->class = User::class;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return $this->rulesValidateRole();
    }

    public function rulesValidateRole(): array
    {
        if (!$this->unique) {
            return  $this->rulesDefault();
        }
        return  ArrayHelper::merge($this->rulesDefault(), $this->rulesUnique());
    }

    /**
     * @inheritdoc
     */
    public function rulesDefault(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rulesUnique(): array
    {
        return [
            ['email', 'unique', 'targetClass' => $this->class, 'message' => 'Этот адрес электронной почты уже существует.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Адрес электронной почты:',
        ];

    }
}