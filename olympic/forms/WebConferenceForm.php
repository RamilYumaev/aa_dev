<?php

namespace olympic\forms;

use olympic\models\WebConference;
use yii\base\Model;

class WebConferenceForm extends Model
{
    public $name;
    public $link;
    /**
     * {@inheritdoc}
     */
    public function __construct(WebConference $webConference = null, $config = [])
    {
        if ($webConference) {
            $this->name = $webConference->name;
            $this->link = $webConference->link;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['name','link'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return WebConference::labels();
    }

}