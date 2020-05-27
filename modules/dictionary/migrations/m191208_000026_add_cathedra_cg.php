<?php
namespace modules\dictionary\migrations;

use common\auth\models\User;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictCathedra;
use modules\dictionary\models\DictOrganizations;
use modules\entrant\models\OtherDocument;
use \yii\db\Migration;

class m191208_000026_add_cathedra_cg extends Migration
{
    private function table() {
        return 'cathedra_cg';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'cathedra_id' => $this->smallInteger(5)->notNull(),
            'cg_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-cathedra_cg-cat-cg}}', $this->table(), ['cathedra_id','cg_id'], true);
        $this->addForeignKey('{{%fk-idx-cathedra_cg-cathedra_id}}', $this->table(), 'cathedra_id', DictCathedra::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-idx-cathedra_cg-cg_id}}', $this->table(), 'cg_id', DictCompetitiveGroup::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
