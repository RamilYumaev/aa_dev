<?php

namespace modules\entrant\forms;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\OtherDocument;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class OtherDocumentForm extends Model
{
    public $type, $user_id, $amount, $series, $number, $date, $authority, $exemption_id;

    private $arrayRequired;

    private $typesDocument;

    private $_otherDocument;

    public $isExemption;
    public $isAjax;

    public function __construct($ajax = false, OtherDocument $otherDocument = null,
                                $exemption = false,
                                $arrayRequired = [],
                                $typesDocument = [],
                                $config = [])
    {
        $this->isExemption = $exemption;
        $this->isAjax = $ajax;
        $this->typesDocument = $typesDocument;
        $this->arrayRequired = $arrayRequired;
        if($otherDocument){
            $this->setAttributes($otherDocument->getAttributes(), false);
            $this->date=$otherDocument->date ? $otherDocument->getValue("date"): null;
            $this->_otherDocument = $otherDocument;

        }
        $this->user_id = \Yii::$app->user->identity->getId();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [$this->required(), 'required'],
            [['type','amount', 'exemption_id'], 'integer'],
            [['series', 'number', 'authority'], 'string', 'max' => 255],
            [['date',], 'safe'],
            [['date'], 'date', 'format' => 'dd.mm.yyyy'],
            [['amount'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PHOTO;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 45}'],
            [['date'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_MEDICINE;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 29}'],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangeType($this->typeDocuments())
            ],
        ];
    }

    private function required() {

        if ($this->arrayRequired) {
            $attribute = $this->arrayRequired;
        } else {
            $attribute =['type'];
        }
       return $attribute;
    }

    public function typeDocuments() {
        if($this->typesDocument) {
            return $this->typesDocument;
        }
        return [
            DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
            DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ,
            DictIncomingDocumentTypeHelper::TYPE_DIPLOMA,
            DictIncomingDocumentTypeHelper::TYPE_MEDICINE
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['type',], 'unique', 'targetClass' => OtherDocument::class, 'targetAttribute' => ['type', 'series', 'number']];
        if ($this->_otherDocument) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_otherDocument->id]]);
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
        return (new OtherDocument())->attributeLabels();
    }




}