<?php
$data = json_decode('{"date_time":"2021-06-24 10:11:51","kcp":{"transferred":"0","sum":14,"quota":1,"target":3,"price_per_semester":null},
"list":[{"incoming_id":339,"last_name":"\u0412\u0438\u043d\u043e\u0433\u0440\u0430\u0434\u043e\u0432",
"first_name":"\u0413\u0435\u043e\u0440\u0433\u0438\u0439",
"patronymic":"\u0412\u0438\u043a\u0442\u043e\u0440\u043e\u0432\u0438\u0447","payment_status":null,
"snils":"147-048-063 56","subjects":[{"subject_id":2,"ball":70,"subject_type_id":3,"check_status_id":1},{"subject_id":5,"ball":61,"subject_type_id":1,"check_status_id":2},{"subject_id":9,"ball":63,"subject_type_id":1,"check_status_id":2}],"specialization_name":null,"individual_achievements":[],"sum_of_individual":0,"zos_status_id":0,"original_status_id":0,"hostel_need_status_id":0,"subject_sum":194,"total_sum":194,"target_organization_name":null,"incoming_date":"2021-06-23","bvi_status_id":0,"bvi_right":null,"pp_status_id":0},{"incoming_id":338,"last_name":"\u0427\u0438\u0440\u0432\u0430","first_name":"\u0414\u0430\u0440\u0438\u043d\u0430","patronymic":"\u041d\u0438\u043a\u043e\u043b\u0430\u0435\u0432\u043d\u0430","payment_status":null,"snils":"150-673-764 68","subjects":[{"subject_id":2,"ball":null,"subject_type_id":3,"check_status_id":null},{"subject_id":4,"ball":null,"subject_type_id":3,"check_status_id":null},{"subject_id":9,"ball":null,"subject_type_id":3,"check_status_id":null}],"specialization_name":null,"individual_achievements":[],"sum_of_individual":0,"zos_status_id":0,"original_status_id":0,"hostel_need_status_id":0,"subject_sum":0,"total_sum":0,"target_organization_name":null,"incoming_date":"2021-06-23","bvi_status_id":0,"bvi_right":null,"pp_status_id":0}]}',true);

//var_dump($data);
$array = [];
foreach ($data['list'] as $list => $value) {
    foreach ($value['subjects'] as $key => $subject) {
        var_dump($subject['subject_type_id']);
       if($subject['subject_type_id'] == 1) {
           $array[$list]['subjects'][$key]['subject_type_id'] = $subject['subject_type_id'];
           $array[$list]['subjects'][$key]['subject_id'] = 4;
           $array[$list]['subjects'][$key]['ball'] = $subject['ball'];
           $array[$list]['subjects'][$key]['check_status_id'] = $subject['check_status_id'];
       }else {
           $array[$list]['subjects'][$key]['subject_type_id'] = $subject['subject_type_id'];
           $array[$list]['subjects'][$key]['subject_id'] = $subject['subject_id'];
           $array[$list]['subjects'][$key]['ball'] = $subject['ball'];
           $array[$list]['subjects'][$key]['check_status_id'] = $subject['check_status_id'];
       }
       else {
           $array[$list]['subjects'][$key]['subject_type_id'] = $subject['subject_type_id'];
           $array[$list]['subjects'][$key]['subject_id'] = $subject['subject_id'];
           $array[$list]['subjects'][$key]['ball'] = $subject['ball'];
           $array[$list]['subjects'][$key]['check_status_id'] = $subject['check_status_id'];
       }
    }
}
var_dump($data['list']);
var_dump($array);