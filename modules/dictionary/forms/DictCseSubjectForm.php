<?php
namespace modules\dictionary\forms;

use modules\dictionary\models\DictCseSubject;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictCseSubjectForm extends Model
{
    public $name, $min_mark, $composite_discipline_status, $cse_status;

    private $_dictCseSubject;

    public function __construct(DictCseSubject $dictCseSubject = null, $config = [])
    {
        if($dictCseSubject){
            $this->setAttributes($dictCseSubject->getAttributes(), false);
            $this->_dictCseSubject = $dictCseSubject;
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
            [['composite_discipline_status', 'cse_status'], 'integer'],
            [['min_mark'], 'integer', 'min' => 1,'max' => 100],
            [['name'], 'string', ],
        ];
    }

    /**
     * {@inheritdoc}
     */


    public function uniqueRules()
    {
        if ($this->_dictCseSubject) {
            return [
                [['name'], 'unique', 'targetClass' => DictCseSubject::class,
                    'filter' => ['<>', 'id', $this->_dictCseSubject->id]],
            ];
        }
        return [[['name'], 'unique', 'targetClass' => DictCseSubject::class,]];
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
        return (new DictCseSubject())->attributeLabels();
    }




}