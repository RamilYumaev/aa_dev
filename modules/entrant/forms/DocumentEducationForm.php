<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\behaviors\EpguBehavior;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\DocumentEducation;

use modules\superservice\components\data\DocumentTypeVersionList;
use modules\superservice\forms\DocumentsDynamicForm;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DocumentEducationForm extends Model
{
    public $type, $series, $number, $date, $user_id, $year, $school_id, $surname, $name, $patronymic, $without_appendix;

    private $_documentEducation;
    public $original;
    public $fio;
    public $type_document, $version_document, $other_data;
    const FIO_PROFILE = true;
    const FIO_NO_PROFILE = false;

    public $typeAnketa;

    public function __construct($user_id, DocumentEducation $documentEducation = null, $config = [])
    {
        $this->fio = self::FIO_PROFILE;
        $this->without_appendix = 0;
        if($documentEducation){
            $this->setAttributes($documentEducation->getAttributes(), false);
            $this->date= $documentEducation->getValue("date");
            if($documentEducation->surname && $documentEducation->name){
                $this->fio = self::FIO_NO_PROFILE;
            }
            $this->_documentEducation = $documentEducation;
            $this->other_data = $documentEducation->other_data ? json_decode($documentEducation->other_data, true) : [];
        }else {
            $this->user_id = $user_id;
        }
        $this->typeAnketa = \Yii::$app->user->identity->anketa()->current_edu_level;
        parent::__construct($config);
    }

    public function behaviors()
    {
        return [
            ['class' =>EpguBehavior::class, 'dynamicModel'=> $this->getDocumentsDynamicForm()]
        ];
    }

    public function getDocumentsDynamicForm() {
        $this->type_document = \Yii::$app->request->get('type') ??  $this->type_document;
        $this->version_document = \Yii::$app->request->get('version') ?? $this->version_document;
        return new DocumentsDynamicForm($this->version_document);
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
    public function versionDocument()
    {
        $documentVersion = new DocumentTypeVersionList();
        $array = $documentVersion
            ->getArray()
            ->filter(function ($v) {
                return $v['IdDocumentType'] == $this->type_document;
            });
        if($array && count($array) > 1) {
           $data = array_filter($array, function ($v){
               return  $v['Id'] == $this->version_document;
            });
            if($data) {
                $data =array_values($data);
                $year = DocumentTypeVersionList::getVersions()[$data[0]['DocVersion']]['value'] ?? date('Y');
                return [['date'], 'date', 'format' => 'dd.mm.yyyy', 'max' => "31.12.$year"];
            }
                return [['date'], 'date', 'format' => 'dd.mm.yyyy'];

        }else {
            return [['date'], 'date', 'format' => 'dd.mm.yyyy'];
        }
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