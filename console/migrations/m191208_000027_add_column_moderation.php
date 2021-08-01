<?php

use \yii\db\Migration;

class m191208_000027_add_column_moderation extends Migration
{

    public function up()
    {
        $this->addColumn(\common\moderation\models\Moderation::tableName(), 'updated_by', $this->integer()->null());
        $this->createIndex('updated_by', '{{%moderation}}', ['updated_by']);
    }

    public function down()
    {
        echo "";
    }
}
