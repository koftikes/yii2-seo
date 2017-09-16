<?php

class m314315_215216_create_seo_table extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%seo}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'modelName' => $this->string(150)->notNull(),
            'title' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%seo}}');
    }
}
