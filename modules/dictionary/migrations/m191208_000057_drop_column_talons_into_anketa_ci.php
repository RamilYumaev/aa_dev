<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\RegisterCompetitionList;
use \yii\db\Migration;

class m191208_000057_drop_column_talons_into_anketa_ci extends Migration
{
    private function table() {
        return 'anketa_ci';
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'talon');
    }

}
