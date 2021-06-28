<?php
namespace modules\transfer\widgets\generate;

use modules\transfer\models\PacketDocumentUser;
use yii\base\Widget;
use Yii;

class BackendPacketWidget extends Widget
{
    public $userId;

    public function run()
    {
        return $this->render('packet-backend', ['documents'=> PacketDocumentUser::find()->andWhere(['user_id' => $this->userId])->all() ]);
    }
}
