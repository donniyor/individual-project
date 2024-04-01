<?php

namespace app\controllers;

use app\components\behaviorsUserTrait;
use app\models\Transactions;
use app\models\TransactionsSearch;
use app\components\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * TransactionsController implements the CRUD actions for Transactions model.
 */
class TransactionsController extends Controller
{
    use behaviorsUserTrait;

    /**
     * @throws InvalidConfigException
     */
    public function actionExport($start, $end): void
    {
        $start = Yii::$app->formatter->asDate($start == '' ? date('d.m.Y', strtotime("-30 days")) : $start, 'php:Y-m-d');
        $end = date('Y-m-d', strtotime(Yii::$app->formatter->asDate($end == '' ? date('d.m.Y') : $end, 'php:Y-m-d') . ' +1 day'));

        $transactions = Transactions::find()
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<=', 'created_at', $end])
            ->orderBy(['created_at' => SORT_ASC])
            ->with('user', 'kindergarten')
            ->all();

        $key = 1;
        $newArray = [
            0 => [
                'ID',
                'Детский Сад',
                'Статус Оплаты',
                'Цена',
                'ID Процесса',
                'Gnk Поля',
                'Назначение',
                'Пользователь',
                'Desc',
                'Tin',
                'Персональный Аккаунт',
                'Дата Добавления',
                'Дата Обновления',
            ]
        ];

        foreach ($transactions as $transaction) {
            $newArray[$key][] = $transaction->id;
            $newArray[$key][] = $transaction->kindergarten->name['ru'] ?? '';
            $newArray[$key][] = $transaction->getPaymentStatusLabel();
            $newArray[$key][] = $transaction->amount;
            $newArray[$key][] = $transaction->processing_id;
            $newArray[$key][] = $transaction->gnk_fields;
            $newArray[$key][] = $transaction->getTotalPrices($transaction, ' ');
            $newArray[$key][] = $transaction->user->name;
            $newArray[$key][] = $transaction->desc;
            $newArray[$key][] = $transaction->tin;
            $newArray[$key][] = $transaction->personal_account;
            $newArray[$key][] = $transaction->created_at;
            $newArray[$key][] = $transaction->updated_at;
            $key++;
        }

        $filename = 'export_' . date('Ymd');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($newArray);
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Transactions ' . $filename . '.xlsx"');
        $writer->save("php://output");
        exit;
    }

    /**
     * Lists all Transactions models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new TransactionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transactions model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Transactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Transactions
    {
        if (($model = Transactions::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
