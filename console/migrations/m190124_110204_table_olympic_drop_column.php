<?php

use \yii\db\Migration;
use \olympic\models\Olympic;
use \yii\db\Query;

class m190124_110204_table_olympic_drop_column extends Migration
{

    protected function table() {
        return Olympic::tableName();
    }
    
    public function up()
    {
        $this->dropForeignKey("olimpic_ibfk_1", $this->table());
        $this->dropColumn($this->table(), "chairman_id");
        $this->dropColumn($this->table(), "number_of_tours");
        $this->dropColumn($this->table(), "edu_level_olymp");
        $this->dropColumn($this->table(), "date_time_start_reg");
        $this->dropColumn($this->table(), "date_time_finish_reg");
        $this->dropColumn($this->table(), "genitive_name");
        $this->dropColumn($this->table(), "faculty_id");
        $this->dropColumn($this->table(), "time_of_distants_tour_type");
        $this->dropColumn($this->table(), "form_of_passage");
        $this->dropColumn($this->table(), "time_of_tour");
        $this->dropColumn($this->table(), "content");
        $this->dropColumn($this->table(), "required_documents");
        $this->dropColumn($this->table(), "showing_works_and_appeal");
        $this->dropColumn($this->table(), "time_of_distants_tour");
        $this->dropColumn($this->table(), "prefilling");
        $this->dropColumn($this->table(), "only_mpgu_students");
        $this->dropColumn($this->table(), "list_position");
        $this->dropColumn($this->table(), "auto_sum");
        $this->dropColumn($this->table(), "date_time_start_tour");
        $this->dropColumn($this->table(), "address");
        $this->dropColumn($this->table(), "requiment_to_work_of_distance_tour");
        $this->dropColumn($this->table(), "requiment_to_work");
        $this->dropColumn($this->table(), "criteria_for_evaluating_dt");
        $this->dropColumn($this->table(), "criteria_for_evaluating");
        $this->dropColumn($this->table(), "promotion_text");
        $this->dropColumn($this->table(), "link");
        $this->dropColumn($this->table(), "certificate_id");
        $this->dropColumn($this->table(), "event_type");


    }

    public function down()
    {
        echo "";
    }
}
