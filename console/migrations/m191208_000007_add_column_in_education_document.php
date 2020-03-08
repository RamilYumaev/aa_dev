<?php

use \yii\db\Migration;

class m191208_000007_add_column_in_education_document extends Migration
{
    private function table() {
        return \modules\entrant\models\DocumentEducation::tableName();
    }

    public function up()
    {
        $this->dropForeignKey('{{%fk-idx-document-education-user}}',$this->table());
        $this->dropIndex('{{%idx-document-education-user}}',$this->table());
        $this->dropForeignKey('{{%fk-idx-document-education-school_id}}',$this->table());
        $this->dropIndex('{{%idx-document-education-school_id}}',$this->table());

        $this->dropColumn( $this->table(),'user_id');
        $this->dropColumn( $this->table(),'school_id');


        $this->addColumn($this->table(), 'user_school_id', $this->integer()->notNull());

        $this->createIndex('{{%idx-document-education-user_school_id}}', $this->table(), 'user_school_id');
        $this->addForeignKey('{{%fk-idx-document-education-user_school_id}}', $this->table(),
            'user_school_id', \common\auth\models\UserSchool::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-idx-document-education-user_school_id}}',$this->table());
        $this->dropIndex('{{%idx-document-education-user_school_id}}',$this->table());

        $this->dropColumn( $this->table(),'user_school_id');

        $this->addColumn($this->table(),'user_id', $this->integer()->notNull());
        $this->addColumn( $this->table(),'school_id', $this->integer()->notNull());

        $this->createIndex('{{%idx-document-education-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-document-education-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-document-education-school_id}}', $this->table(), 'school_id');
        $this->addForeignKey('{{%fk-idx-document-education-school_id}}', $this->table(), 'school_id', \dictionary\models\DictSchools::tableName(), 'id',  'RESTRICT', 'RESTRICT');


    }
}
