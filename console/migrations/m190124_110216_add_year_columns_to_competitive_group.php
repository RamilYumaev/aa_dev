<?php

use \yii\db\Migration;

class m190124_110216_add_year_columns_to_competitive_group extends Migration
{
    private function table() {
        return \dictionary\models\DictCompetitiveGroup::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'year', $this->string()->notNull()->defaultValue("2018-2019"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'year');
    }
}
