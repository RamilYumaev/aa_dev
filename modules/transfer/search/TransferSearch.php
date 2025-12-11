<?php
namespace modules\transfer\search;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;
use modules\transfer\readRepositories\TransferReadRepository;
use Mpdf\Tag\Tr;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TransferSearch  extends  Model
{
    public $user_id, $type, $number, $year, $data_order;

    public function __construct($type = null, $config = [])
    {
        $this->type = $type;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type', 'user_id'], 'integer'],
            [['year', 'number', 'data_order'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @param  integer $limit
     * @return ActiveDataProvider
     */
    public function search(array $params, $limit = null): ActiveDataProvider
    {
        $query = (new TransferReadRepository($this->type, $this->getJobEntrant()))->readData();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' =>  $limit ?? 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'transfer_mpgu.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere([
            'like',
            'data_order',
            $this->data_order,
        ]);

        $query
            ->andFilterWhere(['like', 'year',$this->year])
            ->andFilterWhere(['like', 'number',$this->number]);

        return $dataProvider;
    }
    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return \Yii::$app->user->identity->jobEntrant();
    }
}