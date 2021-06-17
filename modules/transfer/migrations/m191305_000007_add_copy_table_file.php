<?php


namespace modules\transfer\migrations;

use modules\transfer\models\File;
use yii\db\Migration;

class  m191305_000007_add_copy_table_file extends Migration
{
    private function table() {
        return File::tableName();
    }

    public function up()
    {
        $table = 'files';
        $tableNew = 'files_transfer';
        $connection = \Yii::$app->db;
        $command3 = $connection->createCommand('CREATE TABLE `'.$tableNew.'` LIKE `'.$table.'`');
        $command3->execute();
        $command4 = $connection->createCommand('INSERT `'.$tableNew.'` SELECT * FROM `'.$table.'`');
        $command4->execute();
        $this->truncateTable($tableNew);
    }
}
