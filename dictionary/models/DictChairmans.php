<?php


namespace dictionary\models;


use dictionary\forms\DictChairmansForm;
use yii\db\ActiveRecord;

class DictChairmans extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_chairmans';
    }

    public static function create(DictChairmansForm $form)
    {
        $dictChairmans = new static();
        $dictChairmans->last_name = $form->last_name;
        $dictChairmans->first_name = $form->first_name;
        $dictChairmans->patronymic = $form->patronymic;
        $dictChairmans->position = $form->position;
    }

    public function edit(DictChairmansForm $form)
    {
        $this->last_name = $form->last_name;
        $this->first_name = $form->first_name;
        $this->patronymic = $form->patronymic;
        $this->position = $form->position;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',
            'position' => 'Должность',
            'fileSignature' => 'Файл подписи',
        ];
    }

    public static function labels(): array
    {
        $dictChairmans = new static();
        return $dictChairmans->attributeLabels();
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name . $this->patronymic ? ' ' . $this->patronymic : '';
    }

    public static function getAllChairmansFullName()
    {
        return DictChairmans::find()
            ->select(['concat_ws(" ", last_name, first_name, patronymic)'])
            ->indexBy('id')
            ->column();
    }

    // в сервисе

    public function afterSave($insert, $changedAttributes)
    {

        $this->fileSignature->saveAs(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'signature' . DIRECTORY_SEPARATOR . $this->id . '.' . 'png');


        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $this->deleteFile();

        parent::afterDelete();
    }

    protected function deleteFile()
    {
        return array_map('unlink', glob(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'signature' . DIRECTORY_SEPARATOR . $this->id . '.*'));

    }

}