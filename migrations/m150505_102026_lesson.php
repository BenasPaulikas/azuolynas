<?php

use yii\db\Schema;
use yii\db\Migration;

class m150505_102026_lesson extends Migration
{
    public function up()
    {
		$this->createTable('lesson', [
			'id' => 'pk',
			'student_id' => 'string',
			'short' => 'string',
			'name' => 'string',
		]);
    }

    public function down()
    {
        echo "m150505_102026_lesson cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
