<?php

namespace sbs\migrations;

use yii\db\Connection;
use yii\db\Migration;

class m314315_215216_seo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db instanceof Connection && 'mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%seo}}', [
            'id'          => $this->primaryKey(),
            'item_id'     => $this->integer(),
            'item_model'  => $this->string(150)->notNull(),
            'title'       => $this->string(),
            'keywords'    => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%seo}}');
    }
}
