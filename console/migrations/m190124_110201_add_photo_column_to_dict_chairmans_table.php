<?php

use \yii\db\Migration;
use  \dictionary\models\DictChairmans;

class m190124_110201_add_photo_column_to_dict_chairmans_table extends Migration
{
    protected $colunmn = "photo";

    protected function table() {
        return DictChairmans::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), $this->colunmn, $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn( $this->table(), $this->colunmn);
    }
}
