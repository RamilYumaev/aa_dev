<?php


namespace dictionary\models;


use dictionary\forms\DictChairmansCreateForm;
use dictionary\forms\DictChairmansEditForm;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

class DictChairmans extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_chairmans';
    }

    public static function create(DictChairmansCreateForm $form)
    {
        $dictChairmans = new static();
        $dictChairmans->last_name = $form->last_name;
        $dictChairmans->first_name = $form->first_name;
        $dictChairmans->patronymic = $form->patronymic;
        $dictChairmans->position = $form->position;
        return $dictChairmans;
    }

    public function edit(DictChairmansEditForm $form)
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
            'photo' => 'Файл подписи',
        ];
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
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

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/chairmans/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/chairmans/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/chairmans/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/chairmans/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                ],
            ],
        ];
    }

}