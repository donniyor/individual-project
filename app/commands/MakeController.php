<?php

namespace app\commands;

use app\models\Kindergartens;
use app\models\Regions;
use app\models\Transactions;
use app\models\Users;
use Faker\Factory;
use yii\behaviors\TimestampBehavior;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

class MakeController extends Controller
{
    public function actionIndex()
    {
        $count = 100;

        //Transactions::deleteAll();
        //Users::deleteAll();
        //Kindergartens::deleteAll();
        //Regions::deleteAll();

        for ($id = 1; $id <= 1; $id++) {
            $model = new Users;
            $model->name = 'name';
            $model->phone = '+998991112233';
            $model->telegram_chat_id = mt_rand(1, 100);
            $model->status = 1;
            $model->save() && print "Users\n";
        }

        $region = new Regions();
        print "Region\n";
        $region->name = ["ru" => "s", "uz" => "s"];
        $model->status = 1;
        $region->save();

        for ($id = 1; $id <= 1; $id++) {
            $model = new Kindergartens();
            $model->name = ["ru" => "s", "uz" => "s"];
            $model->property = 'public';
            $model->tin = 'da';
            $model->region_id = 1;
            $model->personal_account = 'da';
            $model->pay_external_service_id = 1;
            $model->pay_client_id = 2;
            $model->status = 1;
            $model->save() && print "Kindergarten\n";
        }

        $startDate = '2023-01-01'; // Start date
        $endDate = '2023-12-31';   // End date

// Convert dates to timestamps
        $startTime = strtotime($startDate);
        $endTime = strtotime($endDate);

        for ($id = 1; $id <= $count; $id++) {
            $model = new Transactions();

            // Temporarily detach the TimestampBehavior
            $model->detachBehavior('timestamp');

            $model->kindergarten_id = 2;
            $model->payment_status = 'da';
            $model->processing_id = 'da';
            $model->gnk_fields = 'da';
            $price = mt_rand(100, 500);
            $model->prices = $price;
            $model->amount = $price;
            $model->user_id = 1;
            $model->desc = 'da';
            $model->status = 1;

            // Generate random timestamp within the date range
            $randomTimestamp = mt_rand($startTime, $endTime);
            $randomDate = date('Y-m-d H:i:s', $randomTimestamp);

            // Assign the random date to the created_at attribute
            $model->created_at = $randomDate;

            // Reattach the TimestampBehavior
            $model->attachBehavior('timestamp', [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ]);

            // Save the model
            if ($model->save()) {
                echo "Transactions\n";
            }
        }

        exit;
    }
}