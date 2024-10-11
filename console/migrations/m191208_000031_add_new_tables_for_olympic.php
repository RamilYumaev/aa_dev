<?php

use \yii\db\Migration;

class m191208_000031_add_new_tables_for_olympic extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user_olimpiads', 'file_pd', $this->string()->null());

        $this->addColumn('diploma', 'olympic_profile_id', $this->integer()->null());

        $this->addForeignKey('fk-diploma-olympic_profile_id',
            'diploma',
            'olympic_profile_id',
            'olympic_speciality_profile',
            'id',
            'SET NULL',
            'CASCADE');
    }
}
