<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000025_add_columns_submitted_documents extends Migration
{
    private function table() {
        return \modules\entrant\models\SubmittedDocuments::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'date', $this->date()->comment("Дата"));
        $this->addColumn($this->table(),'status', $this->integer(1)->notNull()->comment("Статус"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'date');
        $this->dropColumn($this->table(), 'status');
    }
}
