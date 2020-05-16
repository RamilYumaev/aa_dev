<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\DocumentEducation;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class DocumentEducationForm extends Model
{
    public $type, $series, $number, $date, $user_id, $year, $school_id, $surname, $name, $patronymic;

    private $_documentEducation;
    public $original;
    public $fio;

    const FIO_PROFILE = true;
    const FIO_NO_PROFILE = false;

    public function __construct(DocumentEducation $documentEducation = null, $config = [])
    {
        $this->fio = self::FIO_PROFILE;
        if($documentEducation){
            $this->setAttributes($documentEducation->getAttributes(), false);
            $this->date= $documentEducation->getValue("date");
            if($documentEducation->surname && $documentEducation->name){
                $this->fio = self::FIO_NO_PROFILE;
            }
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
            [['type', 'school_id','original', 'fio'], 'integer'],
            [['series',],'string', 'max' => 25],
            [['surname', 'name', 'patronymic',],'string', 'max' => 255],
            [['surname', 'name', 'patronymic',], 'match', 'pattern' => '/^[а-яёА-ЯЁ\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['surname', 'name'], 'required', 'when' => function ($model) {
                return $model->fio == self::FIO_NO_PROFILE;},
                'whenClient' => 'function (attribute, value) { return $("#documenteducationform-fio").val() == false}'],
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
        return ArrayHelper::merge((new DocumentEducation())->attributeLabels(),['fio'=> 'ФИО в документе совпадает с ФИО в паспорте?']);
    }
}