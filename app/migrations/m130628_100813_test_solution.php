<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_log_actions
 */
class m130628_100813_test_solution extends Migration
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

        $this->createTable('{{%test_solution}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull(),
            'quiz_id' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-test_solution-user_id',
            'test_solution',
            'user_id'
        );

        $this->addForeignKey(
            'fk-test_solution-user_id',
            'test_solution',
            'user_id',
            'users',
            'id',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-test_solution-quiz_id',
            'test_solution',
            'user_id'
        );

        $this->addForeignKey(
            'fk-test_solution-quiz_id',
            'test_solution',
            'quiz_id',
            'quizizz',
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

        $this->dropForeignKey(
            'fk-test_solution-quiz_id',
            'test_solution'
        );

        $this->dropIndex(
            'idx-test_solution-quiz_id',
            'test_solution'
        );

        $this->dropTable('{{%test_solution}}');
    }
}
