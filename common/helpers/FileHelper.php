<?php

namespace common\helpers;

use common\components\TbsWrapper;


class FileHelper
{
    public static function getFile($data, $templatePath, $fileName)
    {
        $tbs = new TbsWrapper();
        $tbs->openTemplate($templatePath);
        $tbs->merge('a', $data);
        $tbs->download($fileName);
    }


}