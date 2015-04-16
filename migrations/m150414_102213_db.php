<?php

use yii\db\Schema;
use yii\db\Migration;

class m150414_102213_db extends Migration
{
    public function up()
    {
		$this->createTable('teacher',[
			'id' => 'string',
			'name' => 'string',
		]);
    }

    public function down()
    {
        echo "m150414_102213_db cannot be reverted.\n";

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
