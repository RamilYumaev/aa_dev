<?php


namespace modules\entrant\models;

use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\ReceiptContractForm;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\queries\ReceiptContractCgQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%receipt_contract}}".
 *
 * @property integer $id
 * @property integer $contract_cg_id
 * @property integer $period;
 * @property float $pay_sum
 * @property string $date
 * @property string $bank
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages
 **/


class ReceiptContract extends ActiveRecord
{
    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }

    public static function create($contractCgId, $period) {
        $statementCg = new static();
        $statementCg->contract_cg_id = $contractCgId;
        $statementCg->period = $period;
        return $statementCg;
    }

    public function  data(ReceiptContractForm $form) {
        $this->date =  DateFormatHelper::formatRecord($form->date);
        $this->pay_sum = $form->pay_sum;
        $this->bank = $form->bank;

    }
    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function isNullData() {
        return !$this->date || !$this->pay_sum || !$this->bank;
    }

    public function setPeriod($period) {
        $this->period = $period;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function getContractCg() {
        return $this->hasOne(StatementAgreementContractCg::class, ['id'=>'contract_cg_id']);
    }

    public static function find(): ReceiptContractCgQuery
    {
        return new ReceiptContractCgQuery(static::class);
    }



}