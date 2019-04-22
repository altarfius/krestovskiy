<?php

namespace app\controllers;

use app\models\Category;
use app\models\Division;
use app\models\EmployeeSearch;
use app\models\Status;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class EmployeeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['employee/show']);
    }

    public function actionShow() {
        $employeeSearch = new EmployeeSearch();
        $employeeProvider = $employeeSearch->search(Yii::$app->request->get());

        return $this->render('show', [
            'employeeProvider' => $employeeProvider,
            'employeeSearch' => $employeeSearch,
            'divisions' => Division::find()->all(),
            'categories' => Category::find()->all(),
            'statuses' => Status::find()->byStage(4)->all(),
            'managers' => User::find()->all(),
        ]);
    }
}