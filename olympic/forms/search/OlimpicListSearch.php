<?php


namespace olympic\forms\search;


use dictionary\helpers\DictFacultyHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OlimpicListSearch extends Model
{
    public $name, $form_of_passage, $faculty_id, $year;
    protected $_query;

    public function rules()
    {
        return [
            [['form_of_passage', 'faculty_id', 'year'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    public function __construct(Olympic $olympic = null, $config = [])
    {
        if ($olympic) {
            $this->_query = OlimpicList::find()->where(['olimpic_id' => $olympic->id])->orderBy(['year'=>SORT_DESC]);
        } else {
            $this->_query = OlimpicList::find();
        }
        parent::__construct($config);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = $this->_query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'form_of_passage' => $this->form_of_passage,
            'faculty_id' => $this->faculty_id,
             'year' => $this->year
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return Olympic::labels();
    }

    public function formOfPassage()
    {
        return OlympicHelper::formOfPassage();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

}