<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use \yii\db\Migration;

class m191208_000064_add_column_cg_discipline extends Migration
{
    public function table() {
        return DisciplineCompetitiveGroup::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'spo_discipline_id', $this->integer()->null());
        $this->createIndex('{{%idx-discipline_competitive_group-spo_discipline_id}}', $this->table(), 'spo_discipline_id');
        $this->addForeignKey('{{%fk-idx-discipline_competitive_group-spo_discipline_id}}', $this->table(), 'spo_discipline_id', DictDiscipline::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }
}