<?php
namespace modules\dictionary\forms;

use modules\dictionary\models\DictCseSubject;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictCseSubjectForm extends Model
{
    public $name, $min_mark, $composite_discipline_status, $cse_status, $ais_id;

    private $_dictCseSubject;
    private $model;

    public function __construct(DictCseSubject $dictCseSubject = null, $model = DictCseSubject::class,  $config = [])
    {
        if($dictCseSubject){
            $this->setAttributes($dictCseSubject->getAttributes(), false);
            $this->_dictCseSubject = $dictCseSubject;
        }

        $this->model = $model;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['name', 'min_mark', 'ais_id'], 'required'],
            [['composite_discipline_status', 'cse_status', 'ais_id'], 'integer'],
            [['min_mark'], 'integer', 'min' => 1,'max' => 100],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */


    public function uniqueRules()
    {
        if ($this->_dictCseSubject) {
            return [
                [['name', 'ais_id'], 'unique', 'targetClass' => $this->model,
                    'filter' => ['<>', 'id', $this->_dictCseSubject->id]],
            ];
        }
        return [[['name', 'ais_id'], 'unique', 'targetClass' => $this->model]];
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