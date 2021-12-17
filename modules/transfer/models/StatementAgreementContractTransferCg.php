<?php

namespace modules\transfer\models;

use modules\entrant\behaviors\ContractBehavior;
use modules\transfer\helpers\ContractHelper;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\ReceiptContract;
use modules\transfer\behaviors\FileBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "statement_agreement_contract_transfer_cg".
 *
 * @property int $id
 * @property int $statement_transfer_id
 * @property int|null $status_id
 * @property int|null $count_pages
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $type
 * @property int|null $record_id
 * @property string|null $number
 * @property string|null $pdf_file
 * @property int|null $is_mouth
 *
 * @property ReceiptContractTransfer[] $receiptContractTransfers
 * @property StatementTransfer $statementTransfer
 */
class StatementAgreementContractTransferCg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statement_agreement_contract_transfer_cg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statement_transfer_id', 'created_at', 'updated_at'], 'required'],
            [['statement_transfer_id', 'status_id', 'count_pages', 'created_at', 'updated_at', 'type', 'record_id', 'is_mouth'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['statement_transfer_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatementTransfer::className(), 'targetAttribute' => ['statement_transfer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [ "created_at" => "Дата создания",
            "updated_at" => "Дата  обновления",
            'statementTransfer.cg.faculty.full_name' => "Факультет",
            'statementTransfer.profileUser.fio' => "ФИО  Студента",
            'statementTransfer.cg.fullNameCg' => "Конкурсная группа",
            'number' => "Номер договора",
            "statusName" => "Статус",
            "status_id" => "Статус",
            'is_month' => "Оплата по месяцам?",
            'isMonth' => "Оплата по месяцам?"];
    }

    /**
     * Gets query for [[ReceiptContractTransfers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceiptContract()
    {
        return $this->hasOne(ReceiptContractTransfer::className(), ['contract_cg_id' => 'id']);
    }

    /**
     * Gets query for [[StatementTransfer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatementTransfer()
    {
        return $this->hasOne(StatementTransfer::className(), ['id' => 'statement_transfer_id']);
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

    public function statusCreated() {
        return $this->status_id == ContractHelper::STATUS_CREATED;
    }

    public function statusAcceptedStudent() {
        return $this->status_id == ContractHelper::STATUS_ACCEPTED_STUDENT;
    }

    public function statusSendStatus() {
        return $this->status_id == ContractHelper::STATUS_SEND_SUCCESS;
    }

    public function statusFix() {
        return $this->status_id == ContractHelper::STATUS_FIX;
    }



    public function getPersonal() {
        return $this->hasOne(PersonalEntityTransfer::class, ['id'=>'record_id']);
    }

    public function getLegal() {
        return $this->hasOne(LegalEntityTransfer::class, ['id'=>'record_id']);
    }

    public function typeEntrant(){
        return $this->type == 1;
    }

    public function typePersonal(){
        return $this->type == 2 && $this->personal;
    }

    public function typePersonalOrLegal() {
        return $this->type == 2 || $this->type == 3;
    }

    public function getStatusName(){
        return ContractHelper::statusName($this->status_id);
    }

    public function getStatusNameStudent(){
        return ContractHelper::statusStudentList()[$this->status_id];
    }

    public function typeLegal(){
        return $this->type == 3 && $this->legal;
    }

    public function setFilePdf($file) {
        $this->pdf_file = $file;
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
                'attribute' => 'pdf_file',
                'filePath' => '@frontend/file_transfer/pdf/[[contract_cg_id]]/[[attribute_pdf_file]]',
            ],
        ];
    }
}
