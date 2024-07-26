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

    /**
     * @throws HttpException
     */
    public function actionList($id)
    {
        if(($model = CgSS::findOne($id)) == null) {
            throw new HttpException('404', 'Такой страницы не существует');
        }

        $kcp= CgSS::find()->select(['id', 'type', 'kcp'])
            ->groupBy([ 'id', 'type', 'education_level','code_spec', 'education_form', 'speciality', 'profile'])
            ->andWhere(['faculty_id' => $model->faculty_id])
            ->andWhere(['education_level'=> $model->education_level,
                'code_spec'=> $model->code_spec,
                 'education_form' => $model->education_form,
                 'profile' => $model->profile,
                 'speciality' => $model->speciality])
            ->andWhere(['not in', 'type', ['Основные места в рамках КЦП', 'По договору об оказании платных образовательных услуг']])
            ->orderBy(['type' => SORT_ASC])
            ->asArray()->all();
        return $this->render('list', ['model' => $model, 'kcp' => $kcp]);
    }
}