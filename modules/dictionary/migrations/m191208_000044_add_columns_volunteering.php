<?php
namespace modules\dictionary\migrations;

use common\auth\models\SettingEmail;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\Volunteering;
use \yii\db\Migration;

class m191208_000044_add_columns_volunteering  extends Migration
{
    private function table() {
        return Volunteering::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(),'note', $this->text());
    }

    public function down()
    {
    }
}
