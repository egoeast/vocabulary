<?php

use yii\db\Migration;

/**
 * Class m171130_084439_create_vocabulary
 */
class m171130_084439_create_vocabulary extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('vocabulary', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'description' => $this->text()->defaultValue(''),
            'lang_pair' => $this->text()->notNull()->defaultValue(''),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('vocabulary');
        //echo "m171130_084439_create_vocabulary cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171130_084439_create_vocabulary cannot be reverted.\n";

        return false;
    }
    */
}
