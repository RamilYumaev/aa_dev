<?php
var_dump(ini_get('session.gc_maxlifetime'));
phpinfo();

var_dump(\modules\exam\helpers\ExamCgUserHelper::disciplineLevel(18004, 1, 1));