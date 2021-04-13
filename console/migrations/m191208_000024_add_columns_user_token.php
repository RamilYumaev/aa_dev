<?php

use \yii\db\Migration;

class  m191208_000024_add_columns_user_token extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_sdo_token}}', [
            'user_id' => $this->integer()->unique(),
            'token' => $this->string(32)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%idx-primary-key}}', 'user_sdo_token', 'user_id');
        $this->createIndex('{{%idx-user_sdo_token}}', 'user_sdo_token', 'user_id');
        $this->addForeignKey('{{%fk-idx-user_sdo_token}}','user_sdo_token', 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createTable('{{%user_firebase_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'token' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_firebase_token}}', 'user_firebase_token', 'user_id');
        $this->addForeignKey('{{%fk-idx-user_firebase_token}}', 'user_firebase_token', 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        echo "";
    }
}
