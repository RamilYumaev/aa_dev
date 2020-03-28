<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000010_add_dict_category extends Migration
{
   private function table() {
       return \modules\entrant\models\DictCategory::tableName();
   }

   public function up()
   {
       $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
       $this->createTable($this->table(), [
           'id' => $this->primaryKey(),
           'name' => $this->string()->notNull(),
           'foreigner_status' => $this->integer(3)->null()->comment('Иностранные граждане'),
       ], $tableOptions);

       $this->createIndex('{{%idx-dict-category-name}}', $this->table(), 'name');

   }

   public function down()
   {
       $this->dropTable($this->table());
   }
}
