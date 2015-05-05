<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = 'Pamokų keistuvas';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

    </div>

	<?php
	$form = ActiveForm::begin();
	echo $form->field($model, 'day')->dropDownList(['Pirmadienis', 'Antradienis', 'Trečiadienis', 'Ketvirtadienis', 'Penktadienis', 'Šeštadienis', 'Sekmadienis']);
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
		'options' => ['placeholder' => 'Pirmiausia pasirinkite moksleivį'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	ActiveForm::end();
	?>
</div>
<?php
$url = Yii::$app->urlManager->createUrl(['site/lessons']);

$this->registerJs(<<<EOF
var select = $("#changeform-student_id");
var lessons = $("#changeform-lessons");
var day = $("#changeform-day");

select.change(function(){
	//Load all lessons for him
	$.ajax({
		url: "$url",
		data: {student_id: $(this).val(), day:day.val()},
		success: function(data){
			lessons.select2('destroy');
			lessons.html(data);
			lessons.select2();
		}
	});
	console.log($(this).val());
});
EOF
);
?>