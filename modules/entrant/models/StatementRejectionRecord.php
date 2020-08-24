<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\behaviors\ContractBehavior;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementConsentCgQuery;
use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%statement_rejection_record}}".
 *
 * @property integer $id
 * @property integer $status;
 * @property integer $user_id;
 * @property string $pdf_file
 * @property integer $cg_id;
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages
 * @property string $order_name
 * @property string $order_date
 **/

class StatementRejectionRecord extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_rejection_record}}";
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class,
            [   'class' => FileUploadBehavior::class,
            'attribute' => 'pdf_file',
            'filePath' => '@frontend/file/pdf_record/[[id]]/[[attribute_pdf_file]]',
        ]];
    }

    public function setFile(UploadedFile $file): void
    {
        $this->pdf_file = $file;
    }



    public static function create($cg_id, $status_id, $user_id, $date, $name) {
        $statementCg = new static();
        $statementCg->cg_id = $cg_id;
        $statementCg->user_id = $user_id;
        $statementCg->order_date = $date;
        $statementCg->order_name = $name;
        $statementCg->status= $status_id;
        return $statementCg;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }
    public function getCg() {
        return $this->hasOne(DictCompetitiveGroup::class, ['id'=> 'cg_id']);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

    public function countAcceptedFiles() {
        return $this->getFiles()->andWhere(['status'=>FileHelper::STATUS_ACCEPTED])->count();
    }

    public function isAllFilesAccepted() {
        return $this->countAcceptedFiles() == $this->countFiles();
    }

    public function statusWalt() {
        return $this->status == StatementHelper::STATUS_WALT;
    }

    public function statusView() {
        return $this->status == StatementHelper::STATUS_VIEW;
    }


    public function statusDraft() {
        return $this->status == StatementHelper::STATUS_DRAFT;
    }

    public function statusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED ||
            $this->status == StatementHelper::STATUS_RECALL;
    }

    public function getProfileUser()
    {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function isStatusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED;
    }

    public function isStatusNoAccepted() {
        return $this->status == StatementHelper::STATUS_NO_ACCEPTED;
    }

    public function getStatusNameJob() {
        return StatementHelper::statusJobName($this->status);
    }

    public function getStatusName() {
        return StatementHelper::statusName($this->status);
    }

    public function attributeLabels()
    {
        return [
            'user_id'=> "Абитуриент",
            'cg_id'=> "Конкурсная группа",
            'created_at' => "Дата создания",
            'status'=> "Статус"
        ];
    }


}