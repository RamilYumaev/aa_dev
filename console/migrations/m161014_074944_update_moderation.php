<?php

use yii\db\Migration;

class m161014_074944_update_moderation extends Migration
{

    protected function table() {
        return \common\moderation\models\Moderation::tableName();
    }


    public function safeUp()
    {
        $this->dropIndex('model_record_id', $this->table());
    }

    public function safeDown()
    {  $this->createIndex('model_record_id', $this->table(), ['model', 'record_id'], true);

    }
}
