<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_regions
 */
class m130430_100811_create_feedbacks extends Migration
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

        $this->createTable('{{%feedbacks}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull(),
            'kindergarten_id' => $this->integer()->notNull(),
            'images' => $this->json(),
            'phone' => $this->string(20)->notNull(),
            'subject' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),

            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex(
            'idx-feedbacks-kindergarten_id',
            'feedbacks',
            'kindergarten_id'
        );

        $this->addForeignKey(
            'fk-feedbacks-kindergarten_id',
            'feedbacks',
            'kindergarten_id',
            'kindergartens',
            'id',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-feedbacks-user_id',
            'feedbacks',
            'user_id'
        );

        $this->addForeignKey(
            'fk-feedbacks-user_id',
            'feedbacks',
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
            'fk-feedbacks-kindergarten_id',
            'feedbacks',
        );

        $this->dropIndex(
            'idx-feedbacks-kindergarten_id',
            'feedbacks',
        );

        $this->dropForeignKey(
            'fk-feedbacks-user_id',
            'feedbacks',
        );

        $this->dropIndex(
            'idx-feedbacks-user_id',
            'feedbacks',
        );

        $this->dropTable('{{%feedbacks}}');
    }
}
