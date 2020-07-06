<?php


namespace modules\entrant\models;

use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\ReceiptContractForm;
use modules\entrant\helpers\ContractHelper;
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
 * @property string $message
 * @property integer $status_id
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
        $statementCg->date = date("Y-m-d");
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

    public function setStatus($status) {
        $this->status_id = $status;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getStatusName(){
        return ContractHelper::statusReceiptName($this->status_id);
    }

    public function isNullData() {
        return !$this->date || !$this->pay_sum || !$this->bank;
    }

    public function setPeriod($period) {
        $this->period = $period;
    }

    public function statusWalt() {
        return $this->status_id == ContractHelper::STATUS_WALT;
    }

    public function statusDraft() {
        return $this->status_id == ContractHelper::STATUS_NEW;
    }

    public function statusView() {
        return $this->status_id == ContractHelper::STATUS_VIEW;
    }

    public function statusSuccess() {
        return $this->status_id == ContractHelper::STATUS_SUCCESS;
    }

    public function statusAccepted() {
        return $this->status_id == ContractHelper::STATUS_ACCEPTED;
    }

    public function statusNoAccepted() {
        return $this->status_id == ContractHelper::STATUS_NO_ACCEPTED;
    }


    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

    public function getContractCg() {
        return $this->hasOne(StatementAgreementContractCg::class, ['id'=>'contract_cg_id']);
    }


    public static function find(): ReceiptContractCgQuery
    {
        return new ReceiptContractCgQuery(static::class);
    }

    public function attributeLabels()
    {
        return [
            'bank' => "Отделение банка",
            'pay_sum' => "Сумма платежа",
            'number' => "Номер договорв",
            'date' => "Дата платежа",
            'period' => "Период платежа",
            'status_id'=> "Статус",
            "statusName" => "Статус",
        ];
    }

    public function getTextEmail() {
        return "Ваша квитанция к договору платных образовательных услуг №".$this->contractCg->number." принята";
    }



}