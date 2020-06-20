<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Agreement;
use modules\entrant\models\File;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use \yii\db\Migration;

class m191208_000077_altre_column extends Migration
{
    private function table() {
        return StatementRejectionCgConsent::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(),'message', $this->text()->null());
        $this->alterColumn(File::tableName(),'message', $this->text()->null());
        $this->alterColumn(Statement::tableName(),'message', $this->text()->null());
        $this->alterColumn(StatementIndividualAchievements::tableName(),'message', $this->text()->null());
        $this->alterColumn(StatementIa::tableName(),'message', $this->text()->null());
        $this->alterColumn(StatementRejection::tableName(),'message', $this->text()->null());
        $this->alterColumn(StatementRejectionCg::tableName(),'message', $this->text()->null());
        $this->alterColumn(Agreement::tableName(),'message', $this->text()->null());
    }

}
