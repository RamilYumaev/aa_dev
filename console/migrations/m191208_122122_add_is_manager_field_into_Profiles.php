<?php

use yii\db\Migration;

/**
 * Class m191208_122122_add_is_manager_field_into_Profiles
 */
class m191208_122122_add_is_manager_field_into_Profiles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{profiles}}', 'isManager', $this->integer()
            ->defaultValue(0)->comment("для организауторов на факультетах"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{profiles}}', 'isManager');
        echo "m191208_122122_add_is_manager_field_into_Profiles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191208_122122_add_is_manager_field_into_Profiles cannot be reverted.\n";

        return false;
    }
    */
}
