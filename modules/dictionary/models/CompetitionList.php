<?php


namespace modules\dictionary\models;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%competition_list}}".
 *
 * @property integer $id
 * @property integer $rcl_id
 * @property integer $type
 * @property string $datetime
 * @property string $json_file
 **/

class CompetitionList extends ActiveRecord
{
    public function data($rclId, $type, $datetime, $jsonFile)
    {
        $this->rcl_id = $rclId;
        $this->type = $type;
        $this->datetime = $datetime;
        $this->json_file = $jsonFile;
    }

    public function listType()
    {
        return [
            DictCompetitiveGroupHelper::USUAL => 'Общий конкурс',
            DictCompetitiveGroupHelper::SPECIAL_RIGHT => 'Лица,имеющие право на прием на обучение за счет бюджетных ассигнований в пределах особой квоты',
            DictCompetitiveGroupHelper::TARGET_PLACE=> 'Лица, поступающие на целевое обучение',
            'list_bvi' => 'Лица,имеющие право на прием без вступительных испытаний'
        ];
    }

    public function getTypeName($type) {
        return $this->isBvi() ? $this->listType()['list_bvi'] : $this->listType()[$type];
    }

    public function isBvi() {
        return $this->type == 'list_bvi';
    }

    public static function listTitle($department = false)
    {
        return [
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO => ['name' => 'Списки поступающих на программы СПО', 'url'=> 'spo'],
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR => $department ? ['name' =>'Списки поступающих в филиалы МПГУ', 'url'=>'department']
                :['name' =>'Списки поступающих на программы бакалавриата', 'url'=> 'bachelor'],
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER => ['name' => 'Списки поступающих на программы магистратуры', 'url'=>'magistracy'],
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL => ['name' => 'Списки поступающих на программы аспирантуры', 'url' =>'graduate'],
        ];
    }

    public static function tableName()
    {
        return "{{%competition_list}}";
    }

    public function getRegisterCompetitionList() {
        return $this->hasOne(RegisterCompetitionList::class,['id'=>'rcl_id']);
    }

    public function attributeLabels()
    {
        return [
            'rcl_id' => "RCL ID",
            'type' => "Тип",
            'datetime' => "Дата обновления",
            'json_file' => 'Файл',
        ];
    }
}