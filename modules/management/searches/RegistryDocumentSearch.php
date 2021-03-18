<?php

namespace modules\management\searches;


use modules\management\models\PostRateDepartment;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RegistryDocumentSearch extends Model
{
    public $name, $category_document_id, $access, $dict_department_id;
    private $task;

    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['category_document_id', 'access','dict_department_id'], 'integer'],
        ];
    }

    public function __construct(Task $task = null, $config = [])
    {
        $this->task = $task;
        parent::__construct($config);
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = RegistryDocument::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->task) {
            $departmentId = PostRateDepartment::find()->joinWith('managementUser')
                ->andWhere(['user_id' => $this->getUserId()])->select('dict_department_id')->column();
            $query->andWhere(['access' => RegistryDocument::ACCESS_FULL])
                ->orWhere(['access' => RegistryDocument::ACCESS_DEPARTMENT, 'dict_department_id' =>$departmentId])
                ->orWhere(['access' => RegistryDocument::ACCESS_PERSON, 'user_id' =>$this->getUserId()]);
        }

        $query->andFilterWhere(['category_document_id' => $this->category_document_id,
            'dict_department_id' =>  $this->dict_department_id,
            'access' => $this->access]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new RegistryDocument())->attributeLabels();
    }

    private function getUserId() {
        return Yii::$app->user->identity->getId();
    }

}