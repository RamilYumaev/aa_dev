<?php


namespace dictionary\forms;

use dictionary\models\DictDiscipline;

use yii\base\Model;

class DictDisciplineCreateForm extends Model
{
    public $name, $links, $cse_subject_id, $ais_id,$is_och, $dvi, $composite_discipline;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => DictDiscipline::class, 'message' => 'Такая дисциплина уже есть в справочнике'],
            [['name', 'links'], 'string', 'max' => 255],
            [['cse_subject_id', 'ais_id', 'is_och', 'dvi', 'composite_discipline'], 'integer']
        ];
    }

    public function attributeLabels(): array
    {
        return DictDiscipline::labels();
    }
}