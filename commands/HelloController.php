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

class HelloController extends Controller
{

    public function actionIndex($message = 'hello world')
    {
		Teacher::deleteAll();
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
			
			if($action=='Mokytojai'){
	
				$teacher = new Teacher;
				$teacher->id = str_replace('.htm','',$a->href);
				$teacher->name = iconv("", "UTF-8//TRANSLIT//IGNORE", $a->plaintext);
				$teacher->save(false);
				var_dump($teacher->name);
			} else if($action=='Kabinetai'){
				
			} else if($action=='Moksleiviai'){

			}

		}

	}
}
