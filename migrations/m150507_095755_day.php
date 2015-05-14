<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_095755_day extends Migration
{
    public function up()
    {
		$this->addColumn('lesson', 'day', 'integer');
    }

    public function down()
    {
        echo "m150507_095755_day cannot be reverted.\n";

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
