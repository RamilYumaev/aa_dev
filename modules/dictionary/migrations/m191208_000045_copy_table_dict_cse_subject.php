<?php
namespace modules\dictionary\migrations;

use Yii;
use \yii\db\Migration;

class m191208_000045_copy_table_dict_cse_subject extends Migration
{
    public function up()
    {
        $table = "dict_cse_subject";
        $tableNew = "dict_ct_subject";
        $connection = Yii::$app->db;
        $command3 = $connection->createCommand('CREATE TABLE `'.$tableNew.'` SELECT * FROM `'.$table.'`');
        $command3->execute();
        $this->truncateTable($tableNew);
        $this->addPrimaryKey('id-primary_key-dict_ct_subject',$tableNew, 'id');
        $this->alterColumn($tableNew, 'id', $this->integer(11).' NOT NULL AUTO_INCREMENT');
    }

    public function down()
    {
        $this->dropColumn("dict_cse_subject", "ais_id");
    }
}