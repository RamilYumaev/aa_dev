<?php

use yii\db\Migration;

/**
 * Class m191207_135028_add__manager_id_into_olimpic_list
 */
class m191207_135028_add__manager_id_into_olimpic_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{olimpic_list}}', 'manager_id', $this->integer()->defaultValue(NULL)->comment("отвественный за олимпиаду"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{olimpic_list}}', 'manager_id');
        echo "m191207_135028_add__manager_id_into_olimpic_list cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191207_135028_add__manager_id_into_olimpic_list cannot be reverted.\n";

        return false;
    }
    */
}
