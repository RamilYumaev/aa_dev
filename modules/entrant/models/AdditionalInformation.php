<?php


namespace modules\entrant\models;


use backend\widgets\adminlte\InfoBox;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\forms\AdditionalInformationForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%additional_information}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $resource_id
 * @property integer $voz_id
 * @property integer $exam_check
 * @property integer $hostel_id
 * @property float $mark_spo
 * @property integer $chernobyl_status_id
 * @property integer $mpgu_training_status_id
 * @property integer $return_doc
 * @property integer $is_epgu
 * @property integer $is_military_edu
 **/

class AdditionalInformation extends YiiActiveRecordAndModeration
{
    public static function tableName()
    {
        return  "{{%additional_information}}";
    }

    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [
                'resource_id', 'voz_id',
                'hostel_id',
                'chernobyl_status_id',
                'mpgu_training_status_id',
                'is_military_edu',
                'is_epgu',
                'mark_spo']
        ]];
    }

    public static  function create(AdditionalInformationForm  $form) {
        $additional = new static();
        $additional->data($form);
        return $additional;
    }

    public function data(AdditionalInformationForm $form)
    {
        $this->voz_id = $form->voz_id;
        $this->user_id = $form->user_id;
        $this->resource_id = $form->resource_id;
        $this->hostel_id = $form->hostel_id;
        $this->chernobyl_status_id = $form->chernobyl_status_id;
        $this->mark_spo = $form->mark_spo;
        $this->is_military_edu = $form->is_military_edu;
        $this->is_epgu = $form->is_epgu;
        $this->return_doc = 3;
        $this->mpgu_training_status_id = $form->mpgu_training_status_id;
    }

    public function attributeLabels()
    {
        return [
            'voz_id' => "Нуждаюсь в создании специальных условий для лиц с ОВЗ и инвалидов при проведении вступительных испытаний?",
            'hostel_id' => 'Нуждаюсь в общежитии?',
            'resource_id'=> 'Откуда узнали об МПГУ?',
            'user_id' =>   'Юзер ID',
            'mark_spo'=> "Средний балл аттестата",
            'chernobyl_status_id' => 'Подвергался(-лась) воздействию радиации (ЧАЭС)',
            'mpgu_training_status_id' => 'Окончил(-а) подготовительные курсы в МПГУ',
            'chernobyl' => 'Подвергался(-лась) воздействию радиации (ЧАЭС)',
            'mpguTraining' => 'Окончил(-а) подготовительные курсы в МПГУ',
            'voz' => "Нуждаюсь в создании специальных условий для лиц с ОВЗ и инвалидов при проведении вступительных испытаний?",
            'hostel' => 'Нуждаюсь в общежитии?',
            'return_doc' => 'Способы возврата оригинала документов',
            'returnDoc' => 'Способы возврата оригинала документов',
            'is_military_edu'=> 'Отношусь к выпускникам общеобразовательных организаций, профессиональных образовательных организаций, находящихся в ведении федеральных государственных органов и реализующих дополнительные общеобразовательные программы, 
            имеющие целью подготовку несовершеннолетних обучающихся к военной или иной государственной службе',
            'resource'=> 'Откуда узнали об МПГУ?',
            'is_epgu' => 'Поступающий через ЕПГУ',
            'exam_check' => "Экзамен"
        ];
    }

    public function setExamCheck($examCheck)
    {
        return $this->exam_check = $examCheck;
    }

    public function getResource()
    {
        return DictDefaultHelper::infoName($this->resource_id);
    }

    public function getReturnDoc()
    {
        return DictDefaultHelper::returnDocName($this->return_doc);
    }

    public function getHostel()
    {
        return DictDefaultHelper::name($this->hostel_id);
    }

    public function getVoz()
    {
       return DictDefaultHelper::name($this->voz_id);
    }

    public function getChernobyl()
    {
        return DictDefaultHelper::name($this->chernobyl_status_id);
    }
    public function getMpguTraining()
    {
        return DictDefaultHelper::name($this->mpgu_training_status_id);
    }

    public function getAnketa()
    {
        return $this->hasOne(Anketa::class, ['user_id' => 'user_id']);
    }

    public function getInsuranceCertificate()
    {
        return $this->hasOne(InsuranceCertificateUser::class, ['user_id' => 'user_id']);
    }

    public function dataArray(): array
    {
        return  [
            'voz' => $this->voz_id,
            'hostel' => $this->hostel_id,
            'mark_spo'=> $this->mark_spo,
        ];
    }



    public function titleModeration(): string
    {
        return "Дополнительная информация";
    }

    public function moderationAttributes($value): array
    {
        return [
            'voz_id' => DictDefaultHelper::name($value),
            'hostel_id' => DictDefaultHelper::name($value),
            'is_military' => DictDefaultHelper::name($value),
            'resource_id'=> DictDefaultHelper::infoName($value),
            'chernobyl_status_id' => DictDefaultHelper::infoName($value),
            'mpgu_training_status_id' => DictDefaultHelper::infoName($value),
            'is_epgu' =>  DictDefaultHelper::infoName($value),
            'mark_spo' => $value
        ];
    }
}