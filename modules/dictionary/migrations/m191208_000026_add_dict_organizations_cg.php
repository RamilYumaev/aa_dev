<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictIndividualAchievementCg;
use \yii\db\Migration;

class m191208_000025_add_dict_individual_achievement_cg extends Migration
{
    public function table(){
        return DictIndividualAchievementCg::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'individual_achievement_id' => $this->smallInteger(5)->notNull(),
            'competitive_group_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('dict_individual_achievement_cg-primary', $this->table(), ['individual_achievement_id', 'competitive_group_id']);

        $this->createIndex('{{%idx-dia_cg-individual_achievement_id}}', $this->table(), 'individual_achievement_id');
        $this->addForeignKey('{{%fk-idx-dia_cg-individual_achievement_id}}', $this->table(), 'individual_achievement_id', DictIndividualAchievement::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-dia_cg-competitive_group_id}}', $this->table(), 'competitive_group_id');
        $this->addForeignKey('{{%fk-idx-dia_cg-competitive_group_id}}', $this->table(), 'competitive_group_id', DictCompetitiveGroup::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
