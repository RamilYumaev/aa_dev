<?php
namespace modules\transfer\widgets\generate;

use modules\transfer\models\PacketDocumentUser;
use yii\base\Widget;
use Yii;

class GeneratePacketWidget extends Widget
{
    public $type;
    public $userId;

    public function init()
    {
      foreach (PacketDocumentUser::generatePacketDocument($this->type) as $type) {
        if(!PacketDocumentUser::findOne(['user_id'=> $this->userId, 'packet_document' => $type])) {
            PacketDocumentUser::create($type, $this->userId)->save();
        }
      }
    }

    public function run()
    {
        return $this->render('packet', ['documents'=> PacketDocumentUser::find()->andWhere(['user_id' => $this->userId])->all() ]);
    }
}
