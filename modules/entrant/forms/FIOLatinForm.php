<?php


namespace modules\entrant\forms;


use modules\entrant\models\FIOLatin;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class FIOLatinForm extends Model
{
    public $user_id, $surname, $name, $patronymic;

    private $_fio;


    public function __construct($user_id, FIOLatin $FIOLatin = null, $config = [])
    {
        if($FIOLatin){
            $this->setAttributes($FIOLatin->getAttributes(), false);
            $this->_fio = $FIOLatin;
        }else {
            $this->user_id = $user_id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['surname', 'name'], 'required'],
            [['surname', 'name', 'patronymic'], 'trim'],
            [['surname', 'name', 'patronymic',],'string', 'max' => 255],
            [['surname', 'name', 'patronymic',], 'match', 'pattern' => '/^[a-zA-Z\-\s]+$/u',
                'message' => 'Значение поля должно содержать только латинские буквы пробел или тире']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['user_id',], 'unique', 'targetClass' => FIOLatin::class];
        if ($this->_fio) {
            return ArrayHelper::merge($arrayUnique, ['filter' => ['<>', 'id', $this->_fio->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new FIOLatin())->attributeLabels();
    }

}