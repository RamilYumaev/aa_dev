<?php
namespace modules\dictionary\forms;

use modules\dictionary\models\DictForeignLanguage;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictForeignLanguageForm extends Model
{
    public $name;

    private $_dictForeignLanguage;

    public function __construct(DictForeignLanguage $dictForeignLanguage = null, $config = [])
    {
        if($dictForeignLanguage){
            $this->setAttributes($dictForeignLanguage->getAttributes(), false);
            $this->_dictForeignLanguage = $dictForeignLanguage;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */


    public function uniqueRules()
    {
        if ($this->_dictForeignLanguage) {
            return [
                [['name'], 'unique', 'targetClass' => DictForeignLanguage::class,
                    'filter' => ['<>', 'id', $this->_dictForeignLanguage->id]],
            ];
        }
        return [[['name'], 'unique', 'targetClass' => DictForeignLanguage::class,]];
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), $this->uniqueRules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new DictForeignLanguage())->attributeLabels();
    }




}