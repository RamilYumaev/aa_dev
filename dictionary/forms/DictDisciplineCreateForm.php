<?php


namespace dictionary\forms;

use dictionary\models\DictDiscipline;

use yii\base\Model;

class DictDisciplineCreateForm extends Model
{
    public $name, $links, $cse_subject_id, $ct_subject_id,  $ais_id,$is_och, $dvi, $composite_discipline, $composite_disciplines, $is_spec_for_spo, $is_olympic, $faculty_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => DictDiscipline::class, 'message' => 'Такая дисциплина уже есть в справочнике'],
            [['name', 'links'], 'string', 'max' => 255],
            [['cse_subject_id',  'cse_subject_id', 'ais_id', 'is_och', 'dvi', 'composite_discipline', 'is_spec_for_spo', 'is_olympic', 'faculty_id'], 'integer'],
            [['composite_disciplines'], 'safe'],
            [['composite_disciplines'], 'required', 'when' => function($model) {
               return $model->composite_discipline;
            }, 'enableClientValidation' => false],
        ];
    }

    public function attributeLabels(): array
    {
        return DictDiscipline::labels();
    }
}