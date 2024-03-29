<?php

namespace modules\entrant\forms;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\Address;
use modules\entrant\models\Language;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class LanguageForm extends Model
{
    public $language_id, $user_id;

    private $_language;

    public function __construct($user_id, Language $language = null, $config = [])
    {
        if($language){
            $this->setAttributes($language->getAttributes(), false);
            $this->_language = $language;
        }
        $this->user_id = $user_id;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['language_id'], 'required'],
            [['language_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['language_id',], 'unique', 'targetClass' => Language::class,
            'targetAttribute' => ['language_id', 'user_id',]];
        if ($this->_language) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_language->id]]);
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
        return (new Language())->attributeLabels();
    }




}