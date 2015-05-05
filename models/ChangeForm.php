<?php

namespace app\models;

use yii\base\Model;

class ChangeForm extends Model
{
	public $student_id;
	public $lessons;
	public $day;
	
	public function attributeLabels()
	{
		return [
			'student_id' => 'Moksleivis'
		];
	}
}