<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admins}}', [
            'id' => $this->primaryKey(),

            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'kindergarten_id' => $this->integer(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()'),
        ], $tableOptions);

        $this->createIndex(
            'idx-kindergarten-kindergarten_id',
            'admins',
            'kindergarten_id'
        );

        $this->addForeignKey(
            'fk-kindergarten-kindergarten_id',
            'admins',
            'kindergarten_id',
            'kindergartens',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-kindergarten-kindergarten_id',
            'admins'
        );

        $this->dropIndex(
            'idx-kindergarten-kindergarten_id',
            'admins'
        );

        $this->dropTable('{{%admins}}');
    }
}
