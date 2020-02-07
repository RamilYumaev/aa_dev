<?php

use \yii\db\Migration;

class m190124_110444_add_teacher_class_user_table extends Migration
{
    private function table() {
        return \teacher\models\TeacherClassUser::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'id_olympic_user' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'hash' => $this->string()->null(),
        ], $tableOptions);


        $this->createIndex('{{%idxx-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idxx-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idxx-id_olympic_user}}', $this->table(), 'id_olympic_user');
        $this->addForeignKey('{{%fk-idxx-id_olympic_user}}', $this->table(), 'id_olympic_user', \olympic\models\UserOlimpiads::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
