<?php

use yii\db\Schema;
use yii\db\Migration;

class m150421_101224_student extends Migration
{
    public function up()
    {
		$this->createTable('student',[
			'id' => 'string',
			'name' => 'string',
		]);
    }

    public function down()
    {
        echo "m150421_101224_student cannot be reverted.\n";

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
