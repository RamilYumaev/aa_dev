<?php

$photoFile = new \yii\web\UploadedFile();
$photoFile->name = "1.jpg";
$photoFile->size = 1024 * 1024;
$photoFile->type = 'image\jpg';

$photoFile1 = new \yii\web\UploadedFile();
$photoFile1->name = "2.jpg";
$photoFile1->size = 1024 * 1024;
$photoFile1->type = 'image\jpg';

return [
    [
        "last_name" => "Харитонова", "first_name" => "Ирина", "patronymic" => "Викторовна",
        "position" => "Заведующая кафедрой романских языков им. В. Г. Гака Института иностранных языков",
        "photo" => $photoFile
    ],

    [
        "last_name" => "Парамонова", "first_name" => "Маргарита", "patronymic" => "Юрьевна",
        "position" => "Декан факультета дошкольной педагогики и психологии, доцент, Кандидат педагогических наук",
        "photo" => $photoFile1
    ],

];