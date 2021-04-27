<?php


namespace modules\dictionary\models;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%competition_list}}".
 *
 * @property integer $id
 * @property integer $ais_cg_id
 * @property integer $rcl_id
 * @property integer $type
 * @property string $datetime
 * @property string $json_file
 **/

class CompetitionList extends ActiveRecord
{
    public function data($aisCgId, $rclId, $type, $datetime, $jsonFile)
    {
        $this->ais_cg_id = $aisCgId;
        $this->rcl_id = $rclId;
        $this->type = $type;
        $this->datetime = $datetime;
        $this->json_file = $jsonFile;
    }

    public function getCg()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ['ais_id'=> 'ais_cg_id']);
    }

    public function listType()
    {
        return [
            1 => 'Общий конкурс',
            2=> 'Лица,имеющие право на прием на обучение за счет бюджетных ассигнований в пределах особой квоты',
            3=> 'Лица, поступающие на целевое обучение',
            4=> 'Лица,имеющие право на прием без вступительных испытаний'
            ];
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


    public function getTypeName()
    {
        return $this->listType()[$this->type];
    }


    public static function tableName()
    {
        return "{{%competition_list}}";
    }

    public function attributeLabels()
    {
        return [
            'ais_cg_id' => "АИС КГ ИД",
            'rcl_id' => "RCL ID",
            'type' => "Тип",
            'datetime' => "Дата обновления",
            'json_file' => 'Файл',
        ];
    }
}