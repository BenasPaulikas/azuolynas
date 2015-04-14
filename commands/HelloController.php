<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
		$html = SHD::file_get_html('http://www.azuolynas.klaipeda.lm.lt/tvark/tvark_2014-2015_2pusm/index.htm'); 
		$tbody = $html->find('tbody',0);
       foreach($tbody->find('td') as $td) 
       {
             echo $td->plaintext . '<br>';
       }
    }
}
