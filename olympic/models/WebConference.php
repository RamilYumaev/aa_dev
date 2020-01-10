<?php


namespace olympic\models;
/**
 * This is the model class for table "web_conference".
 *
 * @property int $id
 * @property string $name
 * @property string $link
 */
use olympic\models\queries\DiplomaQuery;
use yii\db\ActiveRecord;

class WebConference extends ActiveRecord
{
    public static function create($name, $link)
    {
        $web = new static();
        $web->name = $name;
        $web->link = $link;
        return $web;
    }

    public function edit($name, $link)
    {
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'web_conference';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'link' => 'Ссылка',
        ];
    }

    public static function labels()
    {
        $web = new static();
        return $web->attributeLabels();
    }
}