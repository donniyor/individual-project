<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_log_actions
 */
class m130628_100811_quizizz extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%quizizz}}', [
            'id' => $this->primaryKey(),

            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'user_id' => $this->integer(),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-quizizz-user_id',
            'quizizz',
            'user_id'
        );

        $this->addForeignKey(
            'fk-quizizz-user_id',
            'quizizz',
            'user_id',
            'users',
            'id',
            'NO ACTION'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropForeignKey(
            'fk-quizizz-user_id',
            'quizizz'
        );

        $this->dropIndex(
            'idx-quizizz-user_id',
            'quizizz',
        );
        $this->dropTable('{{%quizizz}}');
    }
}
