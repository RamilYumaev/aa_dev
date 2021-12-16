<?php


namespace modules\transfer\services;


use common\transactions\TransactionManager;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\forms\ContractMessageForm;
use modules\entrant\forms\FilePdfForm;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\forms\ReceiptContractForm;
use modules\entrant\forms\ReceiptContractMessageForm;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\ReceiptHelper;
use modules\entrant\models\File;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\StatementAgreementContractCg;
use modules\transfer\models\LegalEntityTransfer;
use modules\transfer\models\PersonalEntityTransfer;
use modules\transfer\models\StatementAgreementContractTransferCg;
use modules\transfer\models\StatementTransfer;
use yii\db\StaleObjectException;

class StatementAgreementContractTransferCgService
{
    public function create(StatementTransfer $model)
    {
        if($model->statementAgreement) {
            throw  new \DomainException("Договор уже бы создан");
        }
        $modelSt = new StatementAgreementContractTransferCg();
        $modelSt->statement_transfer_id = $model->id;
        $modelSt->save(false);
    }

    public function add($id,  $customer, $rec = 0)
    {
        $statement = $this->getContact($id);
        $statement->type = $customer;
        if($rec) {
            if($statement->type == 2) {
                if(!$this->getPersonalIdUser($rec, $statement->statementTransfer->user_id)) {
                    throw new \DomainException('Данные не найдены');
                }
            }
            if($statement->type == 3) {
                if(!$this->getLegalIdUser($rec, $statement->statementTransfer->user_id)) {
                    throw new \DomainException('Данные не найдены');
                }
            }
        }
        $statement->record_id = $rec;
        $statement->save(false);
        return $statement;
    }

    protected function getPersonalIdUser($id, $user_id): ?PersonalEntityTransfer
    {
        return PersonalEntityTransfer::findOne(['id' => $id,'user_id'=> $user_id]);
    }

    protected function getLegalIdUser($id, $user_id): ?LegalEntityTransfer
    {
        return LegalEntityTransfer::findOne(['id' => $id,'user_id'=> $user_id]);
    }

    protected function getContact($id) {
        if(!$model = StatementAgreementContractTransferCg::findOne($id)) {
            throw new \DomainException('Данные не найдены');
        }
        return $model;

    }

    public function delete($id)
    {
        $model = $this->getContact($id);
        if(($model->legal && $model->legal->countFiles()) || ($model->personal && $model->personal->countFiles())) {
             throw new \DomainException('Вы не можете удалить договор, так как присутствуют загруженные файлы');
        }
        if($model->typePersonal()) {
            if($personal = $this->getPersonalIdUser($model->record_id, $model->statementTransfer->user_id)) {
                $personal->delete();
            }
        }
        if($model->typeLegal()) {
            if($legal = $this->getLegalIdUser($model->record_id, $model->statementTransfer->user_id)) {
                $legal->delete();
            }
        }

        $model->delete();
    }
}
