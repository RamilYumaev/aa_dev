<?php

use yii\db\Migration;

/**
 * Class m191206_164533_moving_calculate_field
 */
class m191206_164533_moving_calculate_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{olimpic_list}}','percent_to_calculate', $this->integer()
            ->defaultValue(0)->comment("Процент участников для перехода в следующий тур"));
        $this->dropColumn('{{test}}', 'type_calculate_id');
        $this->dropColumn('{{test}}','calculate_value');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{olimpic_list}}','percent_to_calculate');
        $this->addColumn('{{test}}', 'type_calculate_id', $this->integer()->defaultValue(0));
        $this->addColumn('{{test}}', 'calculate_value', $this->integer()->defaultValue(0));
        echo "m191206_164533_moving_calculate_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191206_164533_moving_calculate_field cannot be reverted.\n";

        return false;
    }
    */
}
