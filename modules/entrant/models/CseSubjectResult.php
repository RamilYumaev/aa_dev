<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\CseSubjectResultForm;
use modules\entrant\helpers\AddressHelper;
use yii\helpers\Json;
use yii\web\JsonParser;

/**
 * This is the model class for table "{{%cse_subject_result}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $result
 * @property integer $year
**/

class CseSubjectResult extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['year', 'result']
        ]];
    }

    public static  function create(CseSubjectResultForm $form, $result) {
        $cseSubjectResult =  new static();
        $cseSubjectResult->data($form, $result);
        return $cseSubjectResult;
    }

    public function data(CseSubjectResultForm $form, $result) {
        $this->year = $form->year;
        $this->result = $result;
        $this->user_id = $form->user_id;
    }

    public static function tableName()
    {
        return "{{%cse_subject_result}}";
    }

    public function setDataResult($value)
    {
        $array = Json::decode($value);
        $result = "";
        foreach ($array as $item => $value)
        {
            $result.=DictCseSubjectHelper::name($item) .": ".$value."<br />";
        }
        return $result;
    }

    public function getDataResult()
    {
        return $this->setDataResult($this->result);
    }

    public function dateJsonDecode() {
        return  Json::decode($this->result);
    }

    public function titleModeration(): string
    {
        return "Результаты ЕГЭ";
    }

    public function moderationAttributes($value): array
    {
        return [
            'year' => $value,
            'result' => $this->setDataResult($value),
        ];
    }

    public function attributeLabels()
    {
        return [
            'year' => 'Год',
            'result' => 'Результаты ЕГЭ',
            ];
    }

}