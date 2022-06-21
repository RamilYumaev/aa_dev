<?php


namespace modules\dictionary\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictRegionHelper;
use dictionary\models\Region;
use modules\dictionary\forms\DictOrganizationForm;
use olympic\models\auth\Profiles;

/**
 * Class DictOrganizations
 * @package modules\dictionary\models
 * @property $short_name string
 * @property $inn string
 * @property $name string
 * @property $ogrn string
 * @property $kpp string
 * @property $region_id integer
 * @property $ais_id integer
 */
class DictOrganizations extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return [
            'moderation' => [
                'class'=> ModerationBehavior::class,
                'attributes'=>['name', 'kpp', 'short_name', 'inn', 'ogrn', 'region_id'],
            ]];
    }


    public static function tableName()
    {
        return "{{dict_organizations}}";
    }

    public function titleModeration(): string
    {
        return "Целевые организации";
    }

    public static function create(DictOrganizationForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public static function createNameUser($name)
    {
        $model = new static();
        $model->setName($name);
        return $model;
    }

    public function data(DictOrganizationForm $form)
    {
        $this->name = $form->name;
        $this->short_name = $form->short_name;
        $this->kpp = $form->kpp;
        $this->region_id = $form->region_id;
        $this->ogrn = $form->ogrn;
        $this->inn = $form->inn;
    }

    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->$property;
    }

    public function getStringFull(){
        $string = "";
        foreach ($this->getAttributes(null,['id', 'region_id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRegion() {
        return $this->hasOne(Region::class, [ 'id' => 'region_id']);
    }

    public function setAisId($id)
    {
        $this->ais_id = $id;
    }

    public function moderationAttributes($value): array
    {
        return [
            "inn" => $value,
            "short_name" => $value,
            "name" => $value,
            'kpp' => $value,
            'ogrn' => $value,
            'region_id' => DictRegionHelper::regionName($value)
        ];
    }

    public function attributeLabels()
    {
        return [
            "short_name" => "Краткое наименование организации",
            "name" => "Наименование организации",
            "ogrn" => "ОГРН организации",
            "kpp" => 'КПП организации',
            "inn" => 'ИНН организации',
            'region_id' => 'Регион',
        ];
    }
}