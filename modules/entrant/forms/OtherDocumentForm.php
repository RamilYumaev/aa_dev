<?php

namespace modules\entrant\forms;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\models\OtherDocument;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class OtherDocumentForm extends Model
{
    public $note, $type, $user_id;

    private $_otherDocument;

    public function __construct(OtherDocument $otherDocument = null, $config = [])
    {
        if($otherDocument){
            $this->setAttributes($otherDocument->getAttributes(), false);
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
            [['type'], 'integer'],
            [['note'], 'string', 'max' => 255],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangeType([
                DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
                    DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ
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