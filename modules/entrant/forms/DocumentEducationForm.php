<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\DocumentEducation;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class DocumentEducationForm extends Model
{
    public $type, $series, $number, $date, $user_id, $year, $school_id;

    private $_documentEducation;
    public $original;

    public function __construct(DocumentEducation $documentEducation = null, $config = [])
    {
        if($documentEducation){
            $this->setAttributes($documentEducation->getAttributes(), false);
            $this->date= $documentEducation->getValue("date");
            $this->_documentEducation = $documentEducation;
        }else {
            $this->user_id = \Yii::$app->user->identity->getId();
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['type', 'series',
                'number', 'date', 'year', 'school_id'], 'required'],
            [['type', 'school_id','original'], 'integer'],
            [['series',],'string', 'max' => 25],
            [['number'], 'string', 'max' => 25],
            [['year','date',], 'safe'],
            [['date'], 'date', 'format' => 'dd.mm.yyyy'],
            [['year'], 'date', 'format' => 'yyyy'],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_EDUCATION)
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['type',], 'unique', 'targetClass' => DocumentEducation::class,
            'targetAttribute' => ['type', 'series', 'number']];
        if ($this->_documentEducation) {
            return ArrayHelper::merge($arrayUnique, ['filter' => ['<>', 'id', $this->_documentEducation->id]]);
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
        return (new DocumentEducation())->attributeLabels();
    }
}