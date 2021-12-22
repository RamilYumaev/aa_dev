<?php

namespace modules\transfer\models;

use modules\transfer\helpers\ContractHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "receipt_contract_transfer".
 *
 * @property int $id
 * @property int $contract_cg_id
 * @property int $period
 * @property int|null $count_pages
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $bank
 * @property string|null $pay_sum
 * @property string|null $date
 * @property int|null $status_id
 *
 * @property StatementAgreementContractTransferCg $contractCg
 */
class ReceiptContractTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt_contract_transfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_cg_id', 'created_at', 'updated_at'], 'required'],
            [['contract_cg_id',  'count_pages', 'created_at', 'updated_at', 'status_id'], 'integer'],
            [['date'], 'safe'],
            [['bank', 'pay_sum'], 'string', 'max' => 255],
            [['contract_cg_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatementAgreementContractTransferCg::className(), 'targetAttribute' => ['contract_cg_id' => 'id']],
        ];
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

    /**
     * Gets query for [[ContractCg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractCg()
    {
        return $this->hasOne(StatementAgreementContractTransferCg::className(), ['id' => 'contract_cg_id']);
    }

    public function setFilePdf($file) {
        $this->file_pdf = $file;
    }


    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [   'class' => FileUploadBehavior::class,
                'attribute' => 'file_pdf',
                'filePath' => '@frontend/file_transfer/pdf_receipt/[[id]]/[[attribute_file_pdf]]',
            ],
        ];
    }
}
