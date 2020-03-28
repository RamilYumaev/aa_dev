<?php


namespace dictionary\forms;

use dictionary\models\DictDiscipline;

use yii\base\Model;

class DictDisciplineEditForm extends Model
{
    public $name, $links, $_discipline, $cse_subject_id, $ais_id;

    public function __construct(DictDiscipline $discipline, $config = [])
    {
        $this->name = $discipline->name;
        $this->links = $discipline->links;
        $this->cse_subject_id =$discipline->cse_subject_id;
        $this->ais_id =$discipline->ais_id;
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
            [['cse_subject_id','ais_id'], 'integer']
        ];
    }

    public function attributeLabels(): array
    {
        return DictDiscipline::labels();
    }
}