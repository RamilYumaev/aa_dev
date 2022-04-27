<?php
namespace common\moderation\forms\searches;

use common\moderation\helpers\ModerationHelper;
use common\moderation\models\Moderation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ModerationSearch extends Model
{
    public $created_by;

    public function rules()
    {
        return [
            [['created_by'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Moderation::find()->andWhere(["moderation.status" => ModerationHelper::STATUS_NEW]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->created_by) {
            $data = explode(" ", $this->created_by);
            $query->joinWith('createdBy.profiles');
            if(key_exists(0, $data)) {
                $query->andWhere(['like', 'last_name', $data[0]]);
            }
            if(key_exists(1, $data)) {
                $query->andWhere(['like', 'first_name', $data[1]]);
            }
            if(key_exists(2, $data)) {
                $query->andWhere(['like', 'patronymic', $data[2]]);
            }
        }

        return $dataProvider;
    }

}