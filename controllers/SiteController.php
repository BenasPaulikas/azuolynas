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
	
	public function accept($lessons, $number, $day){
		$found = false;
		foreach($lessons as $lesson){
			$found = Lesson::find()->where(['day' => $day, 'teacher_id' => $lesson->teacher_id, 'number' => $number])->one();
			if($found) return $found;
		}
		return $found;
	}
	
	public function actionProcess($student_id, $day){
		echo "\n";
		$day = $day + 1;
		$ignore = $_GET['lessons'];
		
		$lessons = Lesson::find()->where(['student_id' => $student_id, 'day' => $day])->all();

		foreach($lessons as $id=>$lesson){
			if(in_array($lesson['short'],$ignore) || !$lesson->name) unset($lessons[$id]);
		}
		
		$tmp = $lessons;

			
		$go = [];
		for($number=1;$number<count($lessons)+2;$number++){
			echo "Hey can some1 accept me on {$number} ?\n";
			$found = $this->accept($lessons, $number, $day);
			if($found){
				$go[$number] = $found;
				echo "{$found->teacher->name}: Yes I will accept you\n";
				unset($lessons[$number]);	
			} else {
				echo "No \n";
			}
		}
		echo "That's it\n";
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
