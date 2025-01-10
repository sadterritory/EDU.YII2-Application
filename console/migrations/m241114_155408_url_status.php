<?php

use yii\db\Migration;

/**
 * Class m241114_155408_url_status
 */
class m241114_155408_url_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("url_status", [
            "hash_string" => $this->string(32)->notNull(),
            "created_at"=> $this->dateTime()->notNull(),
            "updated_at"=>$this->dateTime()->notNull(),
            "url"=>$this->string(255)->notNull(),
            "status_code"=>$this->integer(),
            "query_count"=>$this->integer()
        ]);

        $this->addPrimaryKey(
            'pk-url_status-hash_string',
            'url_status',
            'hash_string'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(
            'url_status'
        );
    }
}
