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
        $this->addColumn('{{olimpic}}', 'manager_id', $this->integer()->defaultValue(NULL)->comment("отвественный за олимпиаду"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{olimpic}}', 'manager_id');
        echo "m191207_135028_add__manager_id_into_olimpic_list cannot be reverted.\n";

        return false;
    }
}
