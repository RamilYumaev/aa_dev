<?php


namespace olympic\forms;


use olympic\helpers\OlympicHelper;
use common\auth\models\User;
use olympic\models\Diploma;
use olympic\models\Olympic;
use yii\base\Model;

class DiplomaForm extends Model
{
    public $user_id, $olimpic_id, $reward_status_id;

    public function __construct(Diploma $diploma = null, $config = [])
    {
        if ($diploma) {
            $this->user_id = $diploma->user_id;
            $this->olimpic_id = $diploma->olimpic_id;
            $this->reward_status_id = $diploma->reward_status_id;
        }
        parent::__construct($config);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'olimpic_id', 'reward_status_id'], 'required'],
            [['user_id', 'olimpic_id', 'reward_status_id', 'nomination_id'], 'integer'],
            [['olimpic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Olympic::class, 'targetAttribute' => ['olimpic_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    public function olimpicList(): array
    {
        return OlympicHelper::olimpicList();
    }

}