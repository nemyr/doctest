<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ads}}`.
 */
class m200908_181006_create_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ads}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200),
            'description' => $this->text(),
            'main_photo' => $this->string(1000),
            'photo2' => $this->string(1000),
            'photo3' => $this->string(1000),
            'price' => $this->float(),
            'date' => $this->dateTime()->defaultExpression("NOW()"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ads}}');
    }
}
