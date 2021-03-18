<?php


namespace modules\management\models;

use modules\management\forms\DictTaskForm;
use modules\management\forms\RegistryDocumentForm;
use modules\management\models\queries\DictTaskQuery;
use yii\db\ActiveRecord;
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

         ];
    }

    public function setFile(UploadedFile $file): void
    {
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