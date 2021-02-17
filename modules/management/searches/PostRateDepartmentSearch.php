<?php
namespace modules\management\searches;

use modules\management\models\PostRateDepartment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostRateDepartmentSearch extends Model
{
    public $dict_department_id, $post_management_id, $rate;

    public function rules()
    {
        return [
            [['dict_department_id', 'post_management_id', 'rate'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = PostRateDepartment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->filterWhere([
            'dict_department_id' => $this->dict_department_id,
            'post_management_id' => $this->post_management_id,
            'rate' => $this->rate
        ]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new PostRateDepartment())->attributeLabels();
    }

}