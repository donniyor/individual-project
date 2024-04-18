<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_log_actions
 */
class m130628_100814_problem_solving extends Migration
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

        $this->createTable('{{%problem_solving}}', [
            'id' => $this->primaryKey(),

            'question_id' => $this->integer()->notNull(),
            'answer_id' => $this->integer()->notNull(),
            'test_solution_id' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-problem_solving-question_id',
            'problem_solving',
            'question_id'
        );
        $this->addForeignKey(
            'fk-problem_solving-question_id',
            'problem_solving',
            'question_id',
            'questions',
            'id',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-problem_solving-answer_id',
            'problem_solving',
            'answer_id'
        );
        $this->addForeignKey(
            'fk-problem_solving-answer_id',
            'problem_solving',
            'answer_id',
            'answer_options',
            'id',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-problem_solving-test_solution_id',
            'problem_solving',
            'test_solution_id'
        );
        $this->addForeignKey(
            'fk-problem_solving-test_solution_id',
            'problem_solving',
            'test_solution_id',
            'test_solution',
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
            'fk-problem_solving-question_id',
            'problem_solving'
        );
        $this->dropIndex(
            'idx-problem_solving-question_id',
            'problem_solving',
        );

        $this->dropForeignKey(
            'fk-problem_solving-answer_id',
            'problem_solving'
        );
        $this->dropIndex(
            'idx-problem_solving-answer_id',
            'problem_solving',
        );

        $this->dropForeignKey(
            'fk-problem_solving-test_solution_id',
            'problem_solving'
        );
        $this->dropIndex(
            'idx-problem_solving-test_solution_id',
            'problem_solving',
        );

        $this->dropTable('{{%problem_solving}}');
    }
}
