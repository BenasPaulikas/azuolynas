<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_102510_teacher_id extends Migration
{
    public function up()
    {
		$this->addColumn('lesson', 'teacher_id', 'string');
    }

    public function down()
    {
        echo "m150514_102510_teacher_id cannot be reverted.\n";

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
