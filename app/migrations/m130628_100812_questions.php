<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_log_actions
 */
class m130628_100812_questions extends Migration
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

        $this->createTable('{{%questions}}', [
            'id' => $this->primaryKey(),

            'question' => $this->text()->notNull(),
            'quiz_id' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-questions-quiz_id',
            'questions',
            'quiz_id'
        );

        $this->addForeignKey(
            'fk-questions-quiz_id',
            'questions',
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
            'fk-questions-quiz_id',
            'questions'
        );

        $this->dropIndex(
            'idx-questions-quiz_id',
            'questions',
        );
        $this->dropTable('{{%questions}}');
    }
}
