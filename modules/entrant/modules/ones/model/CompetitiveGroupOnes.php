<?php

namespace modules\entrant\modules\ones\model;
use modules\entrant\modules\ones\job\CompetitiveListJob;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $name
 * @property string $department
 * @property string $education_level
 * @property string $education_form
 * @property string $speciality
 * @property string $profile
 * @property string $type_competitive
 * @property string $quid
 * @property integer $kcp_transfer
 * @property integer $status
 * @property integer $kcp
 * @property string $file_name
 *
 * @property-read CompetitiveList[] $competitiveList
 */

class CompetitiveGroupOnes extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_HANDLED = 1;
    const STATUS_ORDERED = 2;
    const STATUS_DEFICIENCY = 3;

    public $check;

    public static function tableName(): string
    {
        return '{{%competitive_group_ones}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'education_level', 'education_form', 'department', 'speciality', 'profile', 'type_competitive'], 'required'],
            [['name', 'education_level', 'education_form', 'department', 'speciality', 'profile', 'type_competitive', 'quid'], 'string'],
            [['name', 'education_level', 'education_form', 'department', 'speciality', 'profile', 'type_competitive'], 'trim'],
            [['kcp', 'kcp_transfer', 'check'], 'integer', 'max' => 999, 'min' => 0],
            ['file_name', 'file', 'extensions' => 'xlsx'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($this->file_name && $this->check) {
            Yii::$app->queue->push(new CompetitiveListJob(['model'=>$this]));
            $message = 'Задание отправлено в очередь';
            Yii::$app->session->setFlash("info", $message);
        }
    }

    public function beforeValidate(): bool
    {
        $this->quid = $this->quid  ?? "random". random_int(1, 99);
        if (parent::beforeValidate()) {
            $this->file_name = UploadedFile::getInstance($this, 'file_name');
            return true;
        }
        return true;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => "Наименование",
            'education_level' => "Уровень образования",
            'education_form' => "Форма обучения",
            'department' => "Факультет/Филиал",
            'speciality' => "Направление подготовки",
            'profile' => "Профиль",
            'type_competitive' => "Вид мест",
            'kcp' => 'Вакантные места',
            'kcp_transfer' => 'Колчичество зачсиленных',
            'quid' => "id",
            'status' => 'Статус',
            'statusName' => 'Статус',
            'file_name'=>'Файл (Excel)',
            'check' => 'Добавить задачу в очередь'
        ];
    }

    public function getCompetitiveList() {
        return $this->hasMany(CompetitiveList::class, ['cg_id' => 'id']);
    }

    public function getCountStatuses($status = null) {
        $query = $this->getCompetitiveList();
        if($status){
            $query->andWhere(['status' => $status]);
        }

        return $query->count();
    }

    public function getMinimal() {
        return $this->getCompetitiveList()
            ->andWhere(['status' => CompetitiveList::STATUS_SUCCESS])->min('sum_ball');
    }

    public static function listStatuses()
    {
        return [
            self::STATUS_NEW => "Необработно",
            self::STATUS_HANDLED => "Завершено",
            self::STATUS_ORDERED => "В приказе",
            self::STATUS_DEFICIENCY => "недобор",
        ];
    }

    public static function allCgName() {
        $data = self::find()->select(['name','id'])->indexBy('id')->column();
        return $data;
    }

    public function getStatusName() {
        return self::listStatuses()[$this->status];
    }

    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'file_name',
                'filePath' => '@modules/entrant/files/fok/[[attribute_id]]/[[attribute_file_name]]',
            ],
        ];
    }
}
