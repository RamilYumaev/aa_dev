<?php

use \yii\db\Migration;

class m191208_000008_add_column_in_user_dod extends Migration
{
    private function table() {
        return \dod\models\UserDod::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'school_id', $this->integer()->null()->comment('Учебная организация'));
        $this->addColumn($this->table(), 'status_edu', $this->integer()->null()->comment('Статус участника'));
        $this->addColumn($this->table(), 'count', $this->integer()->defaultValue(1)->comment('Количество участников'));
        $this->addColumn($this->table(), 'form_of_participation', $this->integer(1)->null()->comment('Количество участников'));

        $this->createIndex('{{%idx-user-dod-school_id}}', $this->table(), 'school_id');
        $this->addForeignKey('{{%fk-idx-user-dod-school_id}}', $this->table(), 'school_id', \dictionary\models\DictSchools::tableName(), 'id',  'RESTRICT', 'RESTRICT');
        $this->createIndex('{{%idx-user-dod-status_edu}}', $this->table(), 'status_edu');
        $this->addForeignKey('{{%fk-idx-user-dod-status_edu}}', $this->table(), 'status_edu', \modules\dictionary\models\DictPostEducation::tableName(),
            'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'count');
        $this->dropColumn($this->table(), 'form_of_participation');
        $this->dropColumn($this->table(), 'school_id');
        $this->dropColumn($this->table(), 'status_edu');
    }
}
