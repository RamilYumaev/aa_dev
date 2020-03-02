<?php

namespace modules\entrant\forms;
use common\auth\forms\CompositeForm;
use modules\entrant\helpers\dictionary\DictIncomingDocumentTypeHelper;
use modules\entrant\models\DocumentEducation;

use olympic\forms\auth\SchooLUserCreateForm;
use yii\helpers\ArrayHelper;

class DocumentEducationForm extends CompositeForm
{
    public $type, $series, $number, $date, $user_id, $year;

    private $_documentEducation;

    public function __construct(DocumentEducation $documentEducation = null, $config = [])
    {
        if($documentEducation){
            $this->setAttributes($documentEducation->getAttributes(), false);
            $this->date= $documentEducation->getValue("date");
            $this->_documentEducation = $documentEducation;
            $this->schoolUser = new SchooLUserCreateForm(null,  $documentEducation);
        } else {
            $this->schoolUser = new SchooLUserCreateForm(null);
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
                'number', 'date', 'year'], 'required'],
            [['type'], 'integer'],
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
        if ($this->_documentEducation) {
            return [
                [['type'], 'unique', 'targetClass' => DocumentEducation::class,
                    'filter' => ['<>', 'id', $this->_documentEducation->id],
                    'targetAttribute' => ['type', 'series', 'number']],
            ];
        }
        return [[['type',], 'unique', 'targetClass' => DocumentEducation::class,
                'targetAttribute' => ['type', 'series', 'number']]];
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
        return (new DocumentEducation())->attributeLabels();
    }

    protected function internalForms(): array
    {
        return ['schoolUser'];
    }
}