<?php

namespace app\controllers;

use app\models\Job;
use app\models\JobSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class JobController extends Controller
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

    public function actionShow($id = null) {
        $job = Job::findOne($id);
        if ($job == null) {
            $job = new Job();
        }

        if ($job->load(Yii::$app->request->post()) && $job->save()) {
            Yii::$app->session->setFlash('success', 'Вакансия добавлена');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $jobSearch = new JobSearch();
        $jobProvider = $jobSearch->search(Yii::$app->request->get());

        return $this->render('show', [
            'jobProvider' => $jobProvider,
            'jobSearch' => $jobSearch,
            'job' => $job,
        ]);
    }

    public function actionClose($id) {
        $job = Job::findOne($id);

        if ($job != null) {
            $job->end_date = date('Y-m-d');

            if ($job->save()) {
                Yii::$app->session->setFlash('success', 'Вакансия закрыта');
            }
            else {
                Yii::$app->session->setFlash('danger', 'Вакансия не закрыта. Обратитесь к администратору');
            }
        }
        else {
            Yii::$app->session->setFlash('warning', 'Вакансия не существует. Возможно она былв удалена ранее');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}