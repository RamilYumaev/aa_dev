<?php

use \yii\db\Migration;
use \olympic\models\Olympic;
use \yii\db\Query;

class m190124_110202_table_olympic_list extends Migration
{
    protected $columnId = "id";
    protected $columnOlimpicId = "olimpic_id";
    protected $columnYear = "year";

    protected function tableOld() {
        return Olympic::tableName();
    }

    protected function tableNew() {
        return '{{%olimpic_list}}';
    }

    public function up()
    {
        $this->db->createCommand("CREATE TABLE ".$this->tableNew()." SELECT * FROM ".$this->tableOld())->execute();
        $this->addPrimaryKey($this->tableNew(), $this->tableNew(),$this->columnId);
        $this->alterColumn($this->tableNew(), $this->columnId, $this->smallInteger(11).' NOT NULL AUTO_INCREMENT');
        $this->addColumn($this->tableNew(), $this->columnYear, $this->integer(4)->defaultValue(2019)->after('current_status'));
        $this->addColumn($this->tableNew(), $this->columnOlimpicId, $this->integer(11)->notNull()->after('current_status'));

        $rows = (new Query())->select([$this->columnId, $this->columnOlimpicId])->from($this->tableNew())->all();

        foreach ($rows as $row) {
            $this->update($this->tableNew(), [$this->columnOlimpicId =>  $row['id']], [$this->columnId => $row['id']]);
        }

    }

    public function down()
    {
        $this->dropTable($this->tableNew());
    }
}
