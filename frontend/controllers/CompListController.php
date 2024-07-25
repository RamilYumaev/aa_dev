<?php
namespace frontend\controllers;
use dictionary\models\Faculty;
use modules\entrant\modules\ones_2024\model\CgSS;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class CompListController extends Controller
{
    public function behaviors(): array
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['entrant']
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
       $faculty = Faculty::find()
           ->andWhere(['in', 'id',
               CgSS::find()->select('faculty_id')
                   ->groupBy('faculty_id')
                   ->column()])->select(['id','filial', 'full_name'])
           ->asArray()->all();
       return $this->render('index', ['faculty' => $faculty]);
    }

     public function actionView($faculty_id)
     {
         $faculty = Faculty::find()
                 ->andWhere(['in', 'id', CgSS::find()->select('faculty_id')
                 ->groupBy('faculty_id')->column()])->faculty($faculty_id)
                ->select(['id','filial', 'full_name'])
                ->one();

         if ($faculty == null) {
             throw new HttpException('404', 'Такой страницы не существует');
         }

         $data = CgSS::find()->select([ 'code_spec', 'education_level', 'education_form', 'speciality', 'profile'])
                ->groupBy(['education_level','code_spec', 'education_form', 'speciality', 'profile'])
                 ->andWhere(['faculty_id' => $faculty->id])
                ->asArray()->all();

         $dataType = CgSS::find()->select([ 'id', 'type', 'code_spec', 'education_level', 'education_form', 'speciality', 'profile'])
             ->groupBy([ 'id', 'type', 'education_level','code_spec', 'education_form', 'speciality', 'profile'])
             ->andWhere(['faculty_id' => $faculty->id])
             ->asArray()->all();

         return $this->render('view', ['faculty' => $faculty,  'data' => $data, 'types' => $dataType ]);
     }

    public function actionList($id)
    {
        if(($model = CgSS::findOne($id)) == null) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        return $this->render('list', ['model' => $model]);
    }
}