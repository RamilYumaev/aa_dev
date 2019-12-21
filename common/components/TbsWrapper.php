<?php

namespace common\components;

use clsTinyButStrong;
use yii\base\BaseObject;
use clsOpenTBS;

class TbsWrapper extends BaseObject
{
    /** @var clsTinyButStrong */
    public $tbs;

    public function init()
    {
       new clsOpenTBS();
        $this->tbs = new clsTinyButStrong();
        $this->tbs->PlugIn(TBS_INSTALL, OPENTBS_PLUGIN);
        $this->tbs->SetOption('charset', 'UTF-8');
        $this->tbs->SetOption('noerr', true);
    }

    public function openTemplateContents($contents)
    {
        $handle = \tmpfile();
        \fwrite($handle, $contents);
        return $this->openTemplate($handle);
    }

    public function openTemplate($file)
    {
        return $this->tbs->LoadTemplate($file, OPENTBS_ALREADY_UTF8);
    }

    public function merge($block, $data)
    {
        return $this->tbs->MergeBlock($block, $data);
    }

    public function download($fileName)
    {
        $this->tbs->Show(OPENTBS_DOWNLOAD, $fileName);
         exit();
    }

    public function saveAsFile($fileName)
    {
        return $this->tbs->Show(OPENTBS_FILE, $fileName);
    }

    public function get()
    {
        $this->tbs->Show(OPENTBS_STRING);
        return $this->tbs->Source;
    }
}
