<?php


namespace dictionary\models;


use dictionary\forms\DictDisciplineCreateForm;
use dictionary\forms\DictDisciplineEditForm;
use modules\dictionary\helpers\DictCseSubjectHelper;

class DictDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_discipline';
    }

    public static function create(DictDisciplineCreateForm $form)
    {
        $discipline = new static();
        $discipline->name = $form->name;
        $discipline->links = $form->links;
        $discipline->cse_subject_id = $form->cse_subject_id;
        $discipline->ais_id = $form->ais_id;
        return $discipline;
    }

    public function edit(DictDisciplineEditForm $form)
    {
        $this->name = $form->name;
        $this->links = $form->links;
        $this->cse_subject_id = $form->cse_subject_id;
        $this->ais_id = $form->ais_id;
    }

    public function getCseSubject() {
        return DictCseSubjectHelper::name( $this->cse_subject_id);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название дисциплины',
            'links' => 'Ссылка на сайте',
            'cse_subject_id' => "Предмет ЕГЭ",
            'ais_id' => "ID АИС ВУЗ"
        ];
    }

    public static function labels(): array
    {
        $discipline = new static();
        return $discipline->attributeLabels();
    }

    public static function aisToSdoConverter($key)
    {
        $model = self::find()->andWhere(['ais_id'=> $key])->one();

        if($model !== null)
        {
            return $model->id;
        }

        else return null;
    }

}