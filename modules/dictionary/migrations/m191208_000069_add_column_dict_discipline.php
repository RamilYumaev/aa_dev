<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use \yii\db\Migration;

class m191208_000069_add_column_dict_discipline extends Migration
{
    public function table() {
        return DictDiscipline::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_olympic', $this->boolean()->defaultValue(0));
    }
}