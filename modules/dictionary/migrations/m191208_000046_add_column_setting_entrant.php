<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictClass;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000046_add_column_setting_entrant extends Migration
{
    private function table() {
        return 'setting_entrant';
    }

    public function up()
    {
        $this->addColumn($this->table(), "edu_level", $this->smallInteger()->notNull()->after('faculty_id'));
        $this->alterColumn($this->table(), 'special_right', $this->smallInteger()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
