<?php

namespace modules\entrant\helpers;

use modules\entrant\models\EntrantInWork;

class EntrantInWorkHelper
{
    public static function listStaff() {
return EntrantInWork::find()
    ->joinWith("jobEntrant.profileUser")
    ->select(["concat_ws(' ', `last_name`, `first_name`, `patronymic`)"])
    ->indexBy('job_entrant_id')
    ->distinct()
    ->column();
    }
}