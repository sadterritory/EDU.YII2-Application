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
            "created_ad"=> $this->dateTime()->notNull(),
            "updated_ad"=>$this->dateTime()->notNull(),
            "url"=>$this->string(255)->notNull(),
            "status_code"=>$this->integer(),
            "query_count"=>$this->integer()
        ]);

        $this->createIndex(
            'url_status_hash_string_uindex',
            'url_status',
            'hash_string',
            'true'
        );

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

        $this->dropIndex(
            'url_status_hash_string_uindex',
            'url_status'
        );

        $this->dropTable(
            'url_status'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241114_155408_url_status cannot be reverted.\n";

        return false;
    }
    */
}
