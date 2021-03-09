<?php


namespace modules\entrant\models;

use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\entrant\forms\CseSubjectResultForm;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%cse_vi_select}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $result_cse
 * @property  string $vi
**/

class CseViSelect extends ActiveRecord
{

    public static  function create($vi, $result, $user_id) {
        $cseVi =  new static();
        $cseVi->data($vi, $result, $user_id);
        return $cseVi;
    }

    public function data($vi, $result, $user_id) {
        $this->vi = $vi;
        $this->result_cse = $result;
        $this->user_id = $user_id ;
    }

    public function dataVi() {
       return $this->vi  ? Json::decode($this->vi) : "";
    }

    public function dataCse() {
        return $this->result_cse  ? Json::decode($this->result_cse) : "";
    }

    public static function tableName()
    {
        return "{{%cse_vi_select}}";
    }

    public function getUserAis() {
        return $this->hasOne(UserAis::class,['user_id' =>'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'year' => 'Год',
            'result' => 'Результаты ЕГЭ',
            ];
    }

}