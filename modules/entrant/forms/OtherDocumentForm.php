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


    private $idIa;

    public function __construct($user_id, $ajax = false, OtherDocument $otherDocument = null,
                                $exemption = false,
                                $arrayRequired = [],
                                $typesDocument = [],
                                $idIa = null,
                                $config = [])
    {
        $this->idIa = $idIa;
        $this->isExemption = $exemption;
        $this->isAjax = $ajax;
        $this->typesDocument = $typesDocument;
        $this->arrayRequired = $arrayRequired;
        if($otherDocument){
            $this->setAttributes($otherDocument->getAttributes(), false);
            $this->date=$otherDocument->date ? $otherDocument->getValue("date"): null;
            $this->_otherDocument = $otherDocument;

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
            [$this->required(), 'required'],
            [['type','amount', 'exemption_id'], 'integer'],
            [['series',], 'string', 'max' => 10],
            [['number', 'authority'], 'string', 'max' => 255],
            [['date',], 'safe'],
            [['date'], 'date', 'format' => 'dd.mm.yyyy'],
            [['amount'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PHOTO;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 45}'],
            [['date'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_MEDICINE;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 29}'],
            ['type', 'in', 'range' => $this->rangeValidation()
            ],
        ];
    }

    private function required() {

        if ($this->arrayRequired) {
            $attribute = $this->arrayRequired;
        }else {
            $attribute =['type'];
        }
       return $attribute;
    }

    public function typeDocuments() {
        if($this->typesDocument) {
            return $this->typesDocument;
        }
        return [
            DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ,
            DictIncomingDocumentTypeHelper::TYPE_DIPLOMA,
            DictIncomingDocumentTypeHelper::TYPE_MEDICINE,
            DictIncomingDocumentTypeHelper::TYPE_OTHER
        ];
    }

    private function rangeValidation() {
        if($this->idIa) {
            return DictIncomingDocumentTypeHelper::rangeIds($this->idIa);
        }
        return DictIncomingDocumentTypeHelper::rangeType($this->typeDocuments());
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

    public function  listTypesDocument() {
        if($this->idIa) {
          return  DictIncomingDocumentTypeHelper::listId($this->idIa);
        }
        return DictIncomingDocumentTypeHelper::listType($this->typeDocuments());
    }




}