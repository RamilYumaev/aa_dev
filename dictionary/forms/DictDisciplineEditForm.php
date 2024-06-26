<?php


namespace dictionary\forms;

use dictionary\models\DictDiscipline;

use yii\base\Model;

class DictDisciplineEditForm extends Model
{
    public $name, $links, $_discipline, $cse_subject_id,  $ct_subject_id, $ais_id, $dvi, $is_och, $composite_discipline, $composite_disciplines, $is_spec_for_spo, $is_olympic, $faculty_id;

    public function __construct(DictDiscipline $discipline, $config = [])
    {
        $this->name = $discipline->name;
        $this->faculty_id = $discipline->faculty_id;
        $this->is_och = $discipline->is_och;
        $this->links = $discipline->links;
        $this->cse_subject_id =$discipline->cse_subject_id;
        $this->ct_subject_id =$discipline->ct_subject_id;
        $this->ais_id =$discipline->ais_id;
        $this->is_spec_for_spo = $discipline->is_spec_for_spo;
        $this->is_olympic = $discipline->is_olympic;
        $this->dvi = $discipline->dvi;
        $this->composite_discipline = $discipline->composite_discipline;
        $this->composite_disciplines = $discipline->getComposite()->select('discipline_select_id')->column();
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
            [['cse_subject_id','ais_id', 'dvi', 'ct_subject_id', 'is_och', 'composite_discipline', 'is_spec_for_spo', 'is_olympic', 'faculty_id'], 'integer'],
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