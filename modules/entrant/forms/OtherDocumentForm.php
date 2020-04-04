<?php

namespace modules\entrant\forms;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\OtherDocument;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class OtherDocumentForm extends Model
{
    public $type, $user_id, $amount, $series, $number, $date, $authority;

    private $_otherDocument;

    public function __construct(OtherDocument $otherDocument = null, $config = [])
    {
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
            [['type'], 'required'],
            [['type','amount'], 'integer'],
            [['series', 'number', 'authority'], 'string', 'max' => 255],
            [['date',], 'safe'],
            [['date'], 'date', 'format' => 'dd.mm.yyyy'],
            [['amount'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PHOTO;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 45}'],
            [['date'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_MEDICINE;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 29}'],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangeType([
                DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
                    DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ,
                DictIncomingDocumentTypeHelper::TYPE_DIPLOMA,
                DictIncomingDocumentTypeHelper::TYPE_MEDICINE
            ])
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['type',], 'unique', 'targetClass' => OtherDocument::class, 'targetAttribute' => ['type', 'user_id',]];
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