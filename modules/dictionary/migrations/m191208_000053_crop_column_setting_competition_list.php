<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000053_crop_column_setting_competition_list extends Migration
{
    private function table() {
        return 'setting_competition_list';
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'weekends_work');
        $this->dropColumn($this->table(), 'weekends');
        $this->addColumn($this->table(), 'date_ignore', $this->json());
    }

}
