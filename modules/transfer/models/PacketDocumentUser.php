<?php


namespace modules\transfer\models;

use modules\entrant\helpers\DateFormatHelper;
use modules\transfer\behaviors\FileBehavior;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%transfer_mpgu}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $packet_document
 * @property string $number
 * @property string $authority
 * @property string $date
 * @property integer $type
 * @property string $note
**/

class PacketDocumentUser extends ActiveRecord
{
    const PACKET_DOCUMENT_EDU = 1;
    const PACKET_DOCUMENT_BOOK = 2;
    const PACKET_DOCUMENT_REMOVE = 3;
    const PACKET_DOCUMENT_PERIOD = 4;
    const PACKET_DOCUMENT_BOOK_FROM_EDU  = 5;
    const PACKET_DOCUMENT_STATUS  = 6;

    public static function tableName()
    {
        return '{{%packet_document_user}}';
    }

    public function behaviors()
    {
        return [ FileBehavior::class];
    }

    public static function create($type, $userId) {
        $model = new static();
        $model->user_id = $userId;
        $model->packet_document = $type;
        return $model;
    }

    public function listType() {
        return [
            self::PACKET_DOCUMENT_EDU => 'скан-копия справки об обучении',
            self::PACKET_DOCUMENT_BOOK => 'скан-копия зачетной книжки',
            self::PACKET_DOCUMENT_REMOVE => 'скан-копия приказа об отчислении',
            self::PACKET_DOCUMENT_PERIOD => 'скан-копия справки о периоде обучения ( с указанием количества зачетных единиц и часов по всем дисциплинам)',
            self::PACKET_DOCUMENT_BOOK_FROM_EDU =>'скан-копия зачетной книжки (с подписью руководителя структурного подразделения за каждый семестр и печатями за каждый курс) либо иной документ, содержащий информацию о количестве сданных полностью без задолженностей сессии',
            self::PACKET_DOCUMENT_STATUS => 'скан-копия справки, подтверждающей статус обучающегося (действительна 2 недели с момента выдачи)'
        ];
    }

    public function listTypeName() {
        return [
            self::PACKET_DOCUMENT_EDU => 'Справка об обучении',
            self::PACKET_DOCUMENT_BOOK => 'Зачетная книжка',
            self::PACKET_DOCUMENT_REMOVE => 'Приказ об отчислении',
            self::PACKET_DOCUMENT_PERIOD => 'Справка о периоде обучения ( с указанием количества зачетных единиц и часов по всем дисциплинам)',
            self::PACKET_DOCUMENT_BOOK_FROM_EDU =>'Зачетная книжка (с подписью руководителя структурного подразделения за каждый семестр и печатями за каждый курс) либо иной документ, содержащий информацию о количестве сданных полностью без задолженностей сессии',
            self::PACKET_DOCUMENT_STATUS => 'Справка, подтверждающая статус обучающегося (действительна 2 недели с момента выдачи)'
        ];
    }

    public static function generatePacketDocument($type) {
        if ($type == TransferMpgu::IN_MPGU || $type == TransferMpgu::IN_INSIDE_MPGU) {
            return [self::PACKET_DOCUMENT_EDU, self::PACKET_DOCUMENT_BOOK, self::PACKET_DOCUMENT_REMOVE];
        }elseif ($type == TransferMpgu::FROM_EDU) {
            return [self::PACKET_DOCUMENT_PERIOD, self::PACKET_DOCUMENT_BOOK_FROM_EDU,
                self::PACKET_DOCUMENT_STATUS];
        }else {
            return [self::PACKET_DOCUMENT_BOOK];
        }
    }

    public function getTypeName() {
        return $this->listType()[$this->packet_document];
    }

    public function getTypeNameR() {
        return $this->listTypeName()[$this->packet_document];
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class,['user_id'=> 'user_id']);
    }

    public function isNullData() {
        return !$this->date && !$this->number && !$this->authority;
    }

    public function isBook() {
        return $this->packet_document == self::PACKET_DOCUMENT_BOOK;
    }

    public function getDateRu() {
        return DateFormatHelper::formatView($this->date);
    }

    public function isRemove() {
        return $this->packet_document == self::PACKET_DOCUMENT_REMOVE;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'Юзер',
            'packet_document' => 'Наименование',
            'number' =>'Номер документа',
            'authority'=> 'Кем выдан?',
            'date'=> 'Дата выдачи',
            'note' => "Примечание",
            'type' => 'Тип документа'
        ];
    }
}