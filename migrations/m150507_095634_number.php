<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_095634_number extends Migration
{
    public function up()
    {
		$this->addColumn('lesson', 'number', 'integer');
    }

    public function down()
    {
        echo "m150507_095634_number cannot be reverted.\n";

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
