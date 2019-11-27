<?php
namespace testing\forms\question\search;

use testing\helpers\TestQuestionHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use testing\models\TestQuestion;


class QuestionSearch extends Model
{
    public $text, $title, $type_id;
    private $query;

    public function rules()
    {
        return [
            [['type_id'], 'integer'],
            [['title', 'text' ], 'safe'],
        ];
    }

    public function __construct($type = null, $config = [])
    {
        if ($type) {
            $this->query = TestQuestion::find()->where(['type_id'=> $type]);
        } else {
            $this->query = TestQuestion::find();
        }

        parent::__construct($config);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = $this->query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_id' => $this->type_id,
        ]);

        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return TestQuestion::labels();
    }

    public function typeList(): array
    {
        return TestQuestionHelper::getAllTypes();
    }

}