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
    public $phone;

    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['phone', 'email', 'name', 'surname', 'patronymic'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */

    public function search(array $params): ActiveDataProvider
    {
        $query = Anketa::find()->joinWith(['user', 'profile', 'files'])->andWhere(['files.status'=>1])->distinct();

        $dataProvider = new ActiveDataProvider(['query' => $query]);


        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['anketa.user_id' => $this->user_id]);

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
            'patronymic' => 'Отчество',
            'user_id'=> 'ИД юзера'];
    }
}