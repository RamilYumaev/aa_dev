<?php

use yii\db\Migration;

/**
 * Class m191207_135028_add__managerId_into_olimpic_list
 */
class m191207_135028_add__managerId_into_olimpic_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{olimpic}}', 'managerId', $this->integer()->defaultValue(NULL)->comment("отвественный за олимпиаду"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{olimpic}}', 'managerId');
        echo "m191207_135028_add__managerId_into_olimpic_list cannot be reverted.\n";

        return false;
    }
}
