<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000139_add_columns_education_document extends Migration
{
    private function table() {
        return \modules\entrant\models\DocumentEducation::tableName();
    }

    /**
     * @return false|mixed|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->addColumn($this->table(), 'type_document', $this->integer()->null());
        $this->addColumn($this->table(), 'version_document', $this->integer()->null());
        $this->addColumn($this->table(), 'other_data', $this->json());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'type_document');
        $this->dropColumn($this->table(), 'version_document');
        $this->dropColumn($this->table(), 'other_data');
    }
}
