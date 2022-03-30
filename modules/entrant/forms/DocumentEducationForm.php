<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\DocumentEducation;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class DocumentEducationForm extends Model
{
    public $type, $series, $number, $date, $user_id, $year, $school_id, $surname, $name, $patronymic, $without_appendix;

    private $_documentEducation;
    public $original;
    public $fio;

    const FIO_PROFILE = true;
    const FIO_NO_PROFILE = false;

    public $typeAnketa;

    public function __construct($user_id, DocumentEducation $documentEducation = null, $config = [])
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
            $this->user_id = $user_id;
        }
        $this->typeAnketa = \Yii::$app->user->identity->anketa()->current_edu_level;
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
            [['type', 'school_id','original', 'fio','without_appendix'], 'integer'],
            [['series',],'string', 'max' => 10],
            [['surname', 'name', 'patronymic',],'string', 'max' => 255],
            [['surname', 'name', 'patronymic',], 'match', 'pattern' => '/^[а-яёА-ЯЁ\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['surname', 'name'], 'required', 'when' => function ($model) {
                return $model->fio == self::FIO_NO_PROFILE;},
                'whenClient' => 'function (attribute, value) { return $("#documenteducationform-fio").val() == false}'],
            [['number'], 'string', 'max' => 25],
            [['year','date',], 'safe'],
            [['date'], 'date', 'format' => 'dd.mm.yyyy'],
            [['date'], MaxDateValidate::class],
            [['year'], 'date', 'format' => 'yyyy', 'min'=> 1950,'max'=> date("Y")],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangeEducation($this->typeAnketa)],
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