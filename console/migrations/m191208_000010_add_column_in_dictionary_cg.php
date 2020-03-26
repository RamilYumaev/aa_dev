<?php

use \yii\db\Migration;

class m191208_000009_add_column_in_dictionary_cg extends Migration
{
    private function table() {
        return \dictionary\models\DictCompetitiveGroup::tableName();
    }


    public function down()
    {
        $this->dropColumn($this->table(), 'count');
    }
}
