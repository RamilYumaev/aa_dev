<?php
namespace modules\entrant\searches\admin;

use modules\entrant\models\Anketa;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AnketaSearch extends Model
{
    public $user_id;
    public $surname, $name, $patronymic;
    public $email;
    public $is_dlnr_ua;
    public $phone;

    public function rules()
    {
        return [
            [['user_id','is_dlnr_ua'], 'integer'],
            [['phone', 'email', 'name', 'surname', 'patronymic'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */

    public function search(array $params): ActiveDataProvider
    {
        $query = Anketa::find()->joinWith(['user', 'profile'])->distinct();

        $dataProvider = new ActiveDataProvider(['query' => $query]);


        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['anketa.user_id' => $this->user_id]);
        $query->andFilterWhere(['is_dlnr_ua'=> $this->is_dlnr_ua]);

        $query
            ->andFilterWhere(['like', 'last_name',  $this->surname])
            ->andFilterWhere(['like', 'first_name',  $this->name])
            ->andFilterWhere(['like', 'patronymic',  $this->patronymic])
            ->andFilterWhere(['like', 'email',  $this->email])
            ->andFilterWhere(['like', 'phone',  $this->phone]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'phone'=> 'Телефон',
            'email' => 'Email',
            'name'=>'Имя',
            'surname'=>'Фамилия',
            'is_dlnr_ua' => 'Пересек границу?',
            'patronymic' => 'Отчество',
            'user_id'=> 'ИД юзера'];
    }
}