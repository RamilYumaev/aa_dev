<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\behaviors\ContractBehavior;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementAgreementContractCgQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%statement_agreement_contract_cg}}".
 *
 * @property integer $id
 * @property integer $statement_cg
 * @property string $pdf_file
 * @property string $message
 * @property string $number
 * @property integer $status_id;
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages
 * @property integer $type
 * @property integer $is_month
 * @property integer $record_id
 **/

class StatementAgreementContractCg extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%statement_agreement_contract_cg}}";
    }

    public function setFile(UploadedFile $file): void
    {
        $this->pdf_file = $file;
    }


    public function behaviors()
    {
        return [FileBehavior::class,
            'contract' => ContractBehavior::class,
            TimestampBehavior::class,
            [   'class' => FileUploadBehavior::class,
                'attribute' => 'pdf_file',
                'filePath' => '@frontend/file/pdf/[[id]]/[[attribute_pdf_file]]',
            ],
        ];
    }


    public static function create($statement_cg) {
        $statementCg = new static();
        $statementCg->statement_cg = $statement_cg;
        return $statementCg;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function setMessage($message) {
        $this->message = $message;
    }


    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function setStatus($status) {
        $this->status_id = $status;
    }

    public function setIsMonth($isMonth) {
        $this->is_month = $isMonth;
    }


    public function setType($type) {
        $this->type = $type;
    }

    public function setRecordId($record) {
        $this->record_id = $record;
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

    public function statusWalt() {
        return $this->status_id == ContractHelper::STATUS_WALT;
    }

    public function typePersonalOrLegal() {
        return $this->type == 2 || $this->type == 3;
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


    public function getStatementCg() {
      return $this->hasOne(StatementCg::class, ['id'=>'statement_cg']);
    }

    public function getPersonal() {
        return $this->hasOne(PersonalEntity::class, ['id'=>'record_id']);
    }

    public function getLegal() {
        return $this->hasOne(LegalEntity::class, ['id'=>'record_id']);
    }

    public function getReceiptContract() {
        return $this->hasOne(ReceiptContract::class, ['contract_cg_id'=>'id']);
    }

    public function typeEntrant(){
        return $this->type == 1;
    }

    public function typePersonal(){
        return $this->type == 2 && $this->personal;
    }

    public function typeLegal(){
        return $this->type == 3 && $this->legal;
    }

    public function getStatusName(){
        return ContractHelper::statusName($this->status_id);
    }

    public function getFio () {
        return $this->statementCg->statement->profileUser->fio;
    }

    public function getIsMonth () {
        return DictDefaultHelper::name($this->is_month);
    }

    public function getCg () {
        return $this->statementCg->cg->fullNameB;
    }

    public function attributeLabels()
    {
        return [ "created_at" => "Дата создания",
                 "updated_at" => "Дата  обновления",
                  'fio' => "ФИО  Абитуриента",
                 'cg' => "Конкурсная группа",
                 'number' => "Номер договора",
                 "statusName" => "Статус",
                 "status_id" => "Статус",
                 'is_month' => "Оплата по месяцам?",
                 'isMonth' => "Оплата по месяцам?"];
    }

    public static function find(): StatementAgreementContractCgQuery
    {
        return new StatementAgreementContractCgQuery(static::class);
    }

    public function getTextEmail() {
        return "Ваш договор об оказании платных образовательных услуг №".$this->number." ".mb_strtolower($this->statusName)
            .( $this->statusAccepted() ? ". В личном кабинете Вы можете скачать квитанцию для оплаты. Также сообщаем, что только после загрузки скана квитанции 
            в личном кабинете будет произведено зачисление на первый курс" :"");
    }

}