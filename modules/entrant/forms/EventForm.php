<?php

namespace modules\entrant\forms;

use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Event;
use yii\base\Model;

class EventForm extends Model
{
    public $cg_id, $type, $date, $name_src, $src, $place;

    private $_event;

    public function __construct(Event $event = null, $config = [])
    {
        if($event){
            $this->setAttributes($event->getAttributes(), false);
            $this->_event = $event;
            $this->cg_id = $event->getEventCg()->select('cg_id')->column();
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['cg_id', 'type'], 'required'],
            [['type'], 'integer'],
            [['date','cg_id', ], 'safe'],
            [['place', 'name_src', 'src'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return (new Event())->attributeLabels();
    }
}