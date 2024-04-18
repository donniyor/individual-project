<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_log_actions
 */
class m130628_100814_answer_options extends Migration
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

        $this->createTable('{{%answer_options}}', [
            'id' => $this->primaryKey(),

            'answer' => $this->text()->notNull(),
            'question_id' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-answer_options-question_id',
            'answer_options',
            'question_id'
        );

        $this->addForeignKey(
            'fk-answer_options-question_id',
            'answer_options',
            'question_id',
            'questions',
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
            'fk-answer_options-question_id',
            'answer_options'
        );

        $this->dropIndex(
            'idx-answer_options-question_id',
            'answer_options',
        );
        $this->dropTable('{{%answer_options}}');
    }
}
