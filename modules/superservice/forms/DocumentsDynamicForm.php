<?php
namespace modules\superservice\forms;
use modules\superservice\components\data\DocumentTypeVersionList;
use yii\base\DynamicModel;

class DocumentsDynamicForm
{
    private $data;
    private $version;

    public function __construct($version)
    {
        $this->version = $version;
        $this->data = (new DocumentTypeVersionList())->getArray()->filter(function ($v) {
            return $v['Id'] == $this->version && key_exists('FieldsDescription', $v);
        });
    }

    public function getFields() {
        $fields = [];
        foreach ($this->data as $cc) {
            if(key_exists('FieldsDescription', $cc)) {
                $array = $cc['FieldsDescription']['FieldDescription'];
                foreach ($array as $key2 => $value) {
                    if(is_array($value)) {
                        $fields = $this->addFields($fields, $value);
                    }
                }
                if(key_exists('Name', $array)) {
                    $fields = $this->addFields($fields, $array);
                }
            }
        }
        return $fields;
    }

    private function addFields($fields, $array)
    {
        if ($array['NotNull'] == 'true') {
            $fields['required'][] = $array['Name'];
        }

        if(key_exists('ClsName', $array)) {
            $fields['clsName'][$array['Name']] = $array['ClsName'];
        }

        $fields['descriptions'][$array['Name']] = $array['Description'];
        $fields['descriptions'][$array['Name']] = $array['Description'];
        $fields['formats'][$array['Type']] [] = $array['Name'];
        $fields['names'][] = $array['Name'];

        return $fields;
    }

    public function createDynamicModel() {
        if($this->getFields()) {
            $fields = $this->getFields();
            $model = new DynamicModel($fields['names']);
            if(key_exists('required', $fields)) {
                $model->addRule($fields['required'], 'required');
            }
            if(key_exists('formats', $fields)) {
                foreach ($fields['formats'] as $key  => $value) {
                    $model->addRule($value, $key);
                }
            }
            $model->setAttributeLabels($fields['descriptions']);

            return $model;
        }
    }


}
