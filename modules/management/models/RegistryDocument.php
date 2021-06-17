<?php


namespace modules\management\models;

use modules\management\forms\DictTaskForm;
use modules\management\forms\RegistryDocumentForm;
use modules\management\models\queries\DictTaskQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper as IfFile;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * @property $name string
 * @property $link string
 * @property $category_document_id integer
 * @property $id integer
 * @property $access integer
 * @property $user_id integer
 * @property $dict_department_id integer
 * @property $file string
 * @property $is_deleted boolean
 */
class RegistryDocument extends ActiveRecord
{
    const ACCESS_FULL = 1;
    const ACCESS_DEPARTMENT = 2;
    const ACCESS_PERSON = 3;

    public static function tableName()
    {
        return "{{registry_document}}";
    }

    public static function create(RegistryDocumentForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(RegistryDocumentForm $form)
    {
        $this->name = $form->name;
        $this->access = $form->access;
        $this->dict_department_id = $form->access == self::ACCESS_DEPARTMENT ? $form->dict_department_id : null;
        $this->user_id = $form->access == self::ACCESS_PERSON ? $form->user_id : null;
        $this->link = $form->file ? "" : $form->link;
        $this->category_document_id = $form->category_document_id;
        if($form->file) {
            $this->setFile($form->file);
        }
    }

    public function getAccessList() {
        return [
            self::ACCESS_FULL => 'доступен управлению',
            self::ACCESS_DEPARTMENT => 'доступен отделу',
            self::ACCESS_PERSON => 'личный',
        ];
    }

    public function getAccessName () {
        return $this->getAccessList()[$this->access];
    }

    public function setIsDeleted ($bool) {
        $this->is_deleted = $bool;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименование',
            'category_document_id' => 'Категория',
            'link' => 'Ссылка',
            'file' => 'Файл',
            'dict_department_id' => "Отдел",
            'access' => "Уровень доступа",
            'user_id' => "Владелец",
            'is_deleted' => 'Запрос на удаление'
         ];
    }

    /**
     * @param UploadedFile $file
     * @throws \yii\base\InvalidConfigException
     */
    public function setFile(UploadedFile $file): void
    {
        $array = [
            "image/png",
            'image/jpeg',
            'application/pdf',
            'image/x-eps',
            'application/json',
            'text/plain',
            'text/svg',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword',
            'image/svg+xml',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
        ];
        $type = IfFile::getMimeType($file->tempName, null, false);
        if (!in_array($type, $array)) {
            throw new \DomainException($type. ' Неверный тип файла');
        }
        $this->file = $file;
    }

    public function getCategoryDocument()
    {
        return $this->hasOne(CategoryDocument::class, ['id'=> 'category_document_id']);
    }

    public function getDictDepartment()
    {
        return $this->hasOne(DictDepartment::class, ['id'=> 'dict_department_id']);
    }

    public function getDocumentTask()
    {
        return $this->hasMany(DocumentTask::class, ['document_registry_id'=> 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'file',
                'filePath' => '@entrant/web/work/task/[[filename]].[[extension]]',
                'fileUrl' => '@entrantInfo/work/task/[[filename]].[[extension]]',
            ],
        ];
    }
}