<?php
namespace modules\dictionary\forms;
use modules\dictionary\models\Volunteering;
use yii\base\Model;

class VolunteeringForm extends Model
{
    public $clothes_type, $clothes_size, $link_vk, $job_entrant_id, $faculty_id,
        $experience, $note, $form_edu, $course_edu, $finance_edu, $number_edu, $desire_work, $is_reception;
    public $post;

    public function __construct(Volunteering $volunteering = null, $config = [])
    {
        if($volunteering){
            $this->setAttributes($volunteering->getAttributes(), false);
            $this->desire_work = json_decode($volunteering->desire_work);
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_edu', 'course_edu',
                'finance_edu',
                'job_entrant_id', 'faculty_id',
                'number_edu', 'clothes_type', 'clothes_size',
                'desire_work'], 'required'],
            [['form_edu', 'course_edu', 'finance_edu', 'clothes_type', 'clothes_size', 'job_entrant_id', 'faculty_id',], 'integer'],
            [['link_vk', 'number_edu'], 'string' , 'max' => 255],
            [['note' ], 'string' ],
            [['experience','is_reception'],'boolean' ],
            ['desire_work','safe' ],
        ];
    }

    public function attributeLabels() {
        return (new Volunteering())->attributeLabels();
    }
}