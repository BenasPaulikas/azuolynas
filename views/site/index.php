<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

$this->title = 'Pamokų keistuvas';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

    </div>

	<?php
	$form = ActiveForm::begin();
	echo $form->field($model, 'day')->dropDownList(['Pirmadienis', 'Antradienis', 'Trečiadienis', 'Ketvirtadienis', 'Penktadienis']);
	echo $form->field($model, 'student_id')->widget(Select2::classname(), [
		'data' => $students,
		'language' => 'lt',
		'options' => ['placeholder' => 'Pasirinkite moksleivį'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	echo $form->field($model, 'lessons')->widget(Select2::classname(), [
		'data' => [],
		'language' => 'lt',
		'options' => ['placeholder' => 'Pirmiausia pasirinkite moksleivį', 'multiple' => true],
		'pluginOptions' => [
			//'multiple' => true,
			'allowClear' => true
		],
	]);
	
	echo Html::submitButton('Run run fat boy', ['id' => 'search', 'class' => 'btn btn-success']);
	ActiveForm::end();
	?>
</div>
<?php
$url = Yii::$app->urlManager->createUrl(['site/lessons']);
$process = Yii::$app->urlManager->createUrl(['site/process']);

$this->registerJs(<<<EOF
var select = $("#changeform-student_id");
var lessons = $("#changeform-lessons");
var day = $("#changeform-day");
var search = $("#search");

search.click(function(e){
	e.preventDefault();
	$.ajax({
		url: '$process',
		data: {student_id: select.val(), day:day.val(), lessons: lessons.val()},
		success: function(data){
			console.log(data);
		}
	})
});

day.change(function(){
	update();
})

select.change(function(){
	update();
});

function update(){
	var data = {student_id: select.val(), day:day.val()};
	
	//Load all lessons for him
	$.ajax({
		url: "$url",
		data: data,
		success: function(data){
			lessons.select2('destroy');
			lessons.html(data);
			lessons.select2();
		}
	});

}
EOF
);
?>