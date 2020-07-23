<?php


namespace dictionary\forms;

use dictionary\models\DictDiscipline;

use yii\base\Model;

class DictDisciplineEditForm extends Model
{
    public $name, $links, $_discipline, $cse_subject_id, $ais_id, $dvi, $is_och, $composite_discipline;

    public function __construct(DictDiscipline $discipline, $config = [])
    {
        $this->name = $discipline->name;
        $this->links = $discipline->links;
        $this->is_och = $discipline->is_och;
        $this->cse_subject_id =$discipline->cse_subject_id;
        $this->ais_id =$discipline->ais_id;
        $this->dvi = $discipline->dvi;
        $this->composite_discipline = $discipline->composite_discipline;
        $this->_discipline = $discipline;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => DictDiscipline::class, 'filter' => ['<>', 'id', $this->_discipline->id], 'message' => 'Такая дисциплина уже есть в справочнике'],
            [['name', 'links'], 'string', 'max' => 255],
            [['cse_subject_id','ais_id', 'dvi', 'is_och', 'composite_discipline'], 'integer']
        ];
    }

    public function attributeLabels(): array
    {
        return DictDiscipline::labels();
    }
}