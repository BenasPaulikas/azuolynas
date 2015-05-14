<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Student;
use app\models\Lesson;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		$model = new \app\models\ChangeForm;
		
		$model->day = date('N') - 1;
		
        return $this->render('index', [
			'model' => $model,
			'students' => \yii\helpers\ArrayHelper::map(Student::find()->all(), 'id', 'name')
		]);
    }
	
	public function actionLessons($student_id,$day)
	{
		foreach(Lesson::find()->where(['student_id' => $student_id, 'day' => $day+1])->orderBy('number ASC')->all() as $lesson){
			$name = $lesson->number.' // '.$lesson->name;
			echo \yii\helpers\Html::tag('option', $name, ['value' => $lesson->short]);
		}
	}
	
	public function actionProcess($student_id, $day){
		$day = $day + 1;
		$ignore = $_GET['lessons'];
		
		$lessons = Lesson::find()->where(['student_id' => $student_id, 'day' => $day])->all();
		var_dump(count($lessons));
		foreach($lessons as $id=>$lesson){
			if(in_array($lesson['short'],$ignore) || !$lesson->name) unset($lessons[$id]);
		}
		
		$tmp = $lessons;
		foreach($lessons as $i=>$lesson){
			
			echo "Hey {$lesson->teacher->name} can you accept me ?\n";
			$lesson = Lesson::find()->where(['day' => $day, 'teacher_id' => $lesson->teacher_id])->one();
			if($lesson){
				echo "Yes\n";
			} else {
				die('fail');
			}
			return;
			//1 lesson is $lesson, does our teaches support it ?
		}
		/*
			Load all lessons,
				drop all that does exist
					DO TREE
		*/
		//var_dump($lessons);
	}

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

}
