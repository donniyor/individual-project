<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_regions
 */
class m130430_100811_create_transactions extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'uuid' => "uuid UNIQUE NOT NULL DEFAULT (gen_random_uuid())",

            'kindergarten_id' => $this->integer(),
            'payment_status' => $this->string(20)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'prices' => $this->json()->notNull(),
            'processing_id' => $this->string(),
            'gnk_fields' => $this->string(),
            'amount' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'desc' => $this->string(),
            'tin' => $this->string(20),
            'personal_account' => $this->string(50),

            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-transactions-kindergarten_id',
            'transactions',
            'kindergarten_id'
        );

        $this->addForeignKey(
            'fk-transactions-kindergarten_id',
            'transactions',
            'kindergarten_id',
            'kindergartens',
            'id',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-transactions-user_id',
            'transactions',
            'user_id'
        );

        $this->addForeignKey(
            'fk-transactions-user_id',
            'transactions',
            'user_id',
            'users',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-transactions-kindergarten_id',
            'transactions',
        );

        $this->dropIndex(
            'idx-transactions-kindergarten_id',
            'transactions',
        );

        $this->dropForeignKey(
            'fk-transactions-user_id',
            'transactions',
        );

        $this->dropIndex(
            'idx-transactions-user_id',
            'transactions',
        );

        $this->dropTable('{{%transactions}}');
    }
}
