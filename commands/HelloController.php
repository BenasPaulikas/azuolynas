<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use yii\console\Controller;
use app\models\Teacher;
use app\models\Student;
use app\models\Lesson;

//You shit our pages contains lots of code..
ini_set('xdebug.max_nesting_level', false);

class HelloController extends Controller
{

    public function actionIndex($message = 'hello world')
    {
		//Teacher::deleteAll();
		Student::deleteAll();
		Lesson::deleteAll();
		$html = SHD::file_get_html('http://www.azuolynas.klaipeda.lm.lt/tvark/tvark_2014-2015_2pusm/index.htm');
		
		$table = $html->find('table',1);
		$i = 0;
		foreach($table->find('td') as $td){
			$text = trim($td->plaintext);
			
			if($td->align){
				$action = $text;
				continue;//We no longer need you
			}
			
			$a = SHD::str_get_html($td->innertext);
			$a = $a->find('a',0);
			if(!$a) continue;
			
			$name = iconv("", "UTF-8//TRANSLIT//IGNORE", $a->plaintext);
			$href = str_replace('.htm','',$a->href);
			
			if($action=='Mokytojai'){
				continue;
				$teacher = new Teacher;
				$teacher->id = $href;
				$teacher->name = $name;
				$teacher->save(false);
				var_dump($teacher->name);
			} else if($action=='Kabinetai'){
				
			} else if($action=='Moksleiviai'){
				$changes = [];
				
				
				$student = new Student;
				$student->id = $href;
				$student->name = $name;
				$student->save(false);
				
				echo $name.":\n";
				
				$url = 'http://www.azuolynas.klaipeda.lm.lt/tvark/tvark_2014-2015_2pusm/'.$a->href;
				$input_lines = file_get_contents($url);
				
				preg_match_all("/<td valign=middle  bgcolor=\"(#ffffff|#ffffcc)\"( rowspan=2|)><font size=1>(<b><a href=\"(.+)\">(.+)<\/a>.+|)/", $input_lines, $output_array);
				
				$number = 1;
				$day = 0;
				
				$lessons = [
					1 => [],
					2 => [],
					3 => [],
					4 => [],
					5 => [],
				];

				$minus = false;
				
				$number = 1;
				
				foreach($output_array[4] as $id=>$link){
					
					$day++;
					
					$short = $link;
					$name = iconv("", "UTF-8//TRANSLIT//IGNORE", $output_array[5][$id]);
					
					//@TODO get our teacher ?
					if($short){
						$input_lines = file_get_contents('http://www.azuolynas.klaipeda.lm.lt/tvark/tvark_2014-2015_2pusm/'.$short);
						preg_match_all("/&#151; (.+)<br>/", $input_lines, $teachers);
						$t = iconv("", "UTF-8//TRANSLIT//IGNORE", $teachers[1][0]);
						$teacher = Teacher::find()->where(['name' => $t])->one();
					}
				
					$lessons[$day][$number] = [
						'short' => $short,
						'number' => $number,
						'name' => $name,
						'teacher_id' => @$teacher->id
					];

					if($output_array[2][$id]==' rowspan=2'){
						$lessons[$day][$number+1] = [
							'short' => $short,
							'name' => $name,
							'teacher_id' => @$teacher->id
						];
						$minus = true;
					}
					if($day==5){
						$day = 0;
						if($minus){
							$day = 1;
							$minus = false;
						}
						$number++;
					}

				}
				
				for($i=1;$i<=5;$i++){
					
					foreach($lessons[$i] as $number=>$l){
						$lesson = new Lesson;
						$lesson->student_id = $student->id;
						$lesson->teacher_id = $l['teacher_id'];
						$lesson->short = $l['short'];
						$lesson->name = $l['name'];
						$lesson->number = $number;
						$lesson->day = $i;
						$lesson->save(false);
						//var_dump($lessons[$i]);
					}

				}

			}

		}

	}
}
