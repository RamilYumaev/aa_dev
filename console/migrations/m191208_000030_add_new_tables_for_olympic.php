<?php

use \yii\db\Migration;

class m191208_000030_add_new_tables_for_olympic extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%olympic_speciality}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
            ],
            $options
        );

        $this->createTable(
            '{{%olympic_speciality_profile}}',
            [
                'id' => $this->primaryKey(),
                'olympic_speciality_id' => $this->integer(),
                'name' => $this->string(),
            ],
            $options
        );

        $this->addForeignKey('fk-olympic_speciality_profile-olympic_speciality_id',
            'olympic_speciality_profile',
            'olympic_speciality_id',
            'olympic_speciality',
            'id',
            'CASCADE',
            'CASCADE');


        $this->createTable(
            '{{%olympic_speciality_olimpic_list}}',
            [
                'olimpic_list_id' => $this->smallInteger(6),
                'olympic_speciality_id' => $this->integer(),
            ],
            $options
        );

        $this->addForeignKey('fk-olympic_speciality_olympic-olympic_speciality_id',
            'olympic_speciality_olimpic_list',
            'olympic_speciality_id',
            'olympic_speciality',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey('fk-olympic_speciality_olympic-olimpic_list_id',
            'olympic_speciality_olimpic_list',
            'olimpic_list_id',
            'olimpic_list',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addColumn('test', 'olympic_profile_id', $this->integer()->null());

        $this->addForeignKey('fk-test-olympic_profile_id',
            'test',
            'olympic_profile_id',
            'olympic_speciality_profile',
            'id',
            'SET NULL',
            'CASCADE');

        $this->addColumn('user_olimpiads', 'olympic_profile_id', $this->integer()->null());

        $this->addForeignKey('fk-user_olimpiads-olympic_profile_id',
            'user_olimpiads',
            'olympic_profile_id',
            'olympic_speciality_profile',
            'id',
            'SET NULL',
            'CASCADE');
    }
}
