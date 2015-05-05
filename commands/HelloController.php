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
		Teacher::deleteAll();
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
				$teacher = new Teacher;
				$teacher->id = $href;
				$teacher->name = $name;
				$teacher->save(false);
				var_dump($teacher->name);
			} else if($action=='Kabinetai'){
				
			} else if($action=='Moksleiviai'){
				
				$student = new Student;
				$student->id = $href;
				$student->name = $name;
				$student->save(false);
				
				echo $name.":\n";
				
				//Crawl lessons also
				$url = 'http://www.azuolynas.klaipeda.lm.lt/tvark/tvark_2014-2015_2pusm/'.$a->href;
				
				//$url code is so shitty we need to use regex
				preg_match_all("/<a href=\"([0-9].+).htm\">(.+)<\/a>/", file_get_contents($url), $output);
				
				foreach($output[1] as $id=>$link){
					$lesson = new Lesson;
					$lesson->student_id = $student->id;
					$lesson->short = $link;
					echo $link;
					$lesson->name = $output[2][$id];
					$lesson->save(false);
				}
			}

		}

	}
}
