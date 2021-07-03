<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictSpeciality;
use modules\dictionary\models\DictOrganizations;
use yii\db\Migration;


class m200332_104180_add_column_speciality extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return DictSpeciality::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'series', $this->string(15)->defaultValue("3595"));
        $this->addColumn($this->table(), 'number', $this->string(50)->defaultValue("90А010003815"));
        $this->addColumn($this->table(), 'date_begin', $this->date()->defaultValue("2021-06-22"));
        $this->addColumn($this->table(), 'date_end', $this->date()->defaultValue("2027-06-22"));
    }
}
