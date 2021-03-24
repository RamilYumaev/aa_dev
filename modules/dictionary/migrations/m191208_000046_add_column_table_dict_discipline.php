<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use Yii;
use \yii\db\Migration;

class m191208_000046_add_column_table_dict_discipline extends Migration
{
    public function up()
    {
        $this->addColumn(DictDiscipline::tableName(), 'ct_subject_id', $this->integer(11)->null());
    }

    public function down()
    {
        $this->dropColumn(DictDiscipline::tableName(), 'ct_subject_id');
    }
}