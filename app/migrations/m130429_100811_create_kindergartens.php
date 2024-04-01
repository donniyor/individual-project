<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_kindergartens
 */
class m130429_100811_create_kindergartens extends Migration
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

        try {
            $this->execute("CREATE TYPE property_value AS ENUM ('public', 'private')");
        } catch (\Exception $e) {
        }

        $this->createTable('{{%kindergartens}}', [
            'id' => $this->primaryKey(),

            'name' => $this->json()->notNull(),
            'address' => $this->json(),
            'property' => "property_value NOT NULL",
            'tin' => $this->string(50)->notNull(),
            'images' => $this->json(),
            'region_id' => $this->integer()->notNull(),
            'personal_account' => $this->string(255)->notNull(),
            'pay_external_service_id' => $this->integer()->notNull(),
            'pay_client_id' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);


        $this->createIndex(
            'idx-kindergartens-region_id',
            'kindergartens',
            'region_id'
        );

        $this->addForeignKey(
            'fk-kindergartens-region_id',
            'kindergartens',
            'region_id',
            'regions',
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
            'fk-kindergartens-region_id',
            'kindergartens'
        );

        $this->dropIndex(
            'idx-kindergartens-region_id',
            'kindergartens'
        );

        $this->execute("DROP TYPE IF EXISTS property_value");

        $this->dropTable('{{%kindergartens}}');
    }
}
