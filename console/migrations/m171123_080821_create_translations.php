<?php

use yii\db\Migration;

/**
 * Class m171123_080821_create_translations
 */
class m171123_080821_create_translations extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('translations', [
            'id' => $this->primaryKey(),
            'id_voc' => $this->integer()->notNull(),
            'text' => $this->text()->notNull()->defaultValue(''),
            'translation' => $this->text()->notNull()->defaultValue(''),
            'date' => $this->dateTime()->notNull()->defaultValue(''),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('translations');
        //echo "m171123_080821_create_translations cannot be reverted.\n";

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171123_080821_create_translations cannot be reverted.\n";

        return false;
    }
    */
}
