<?php

namespace app\controllers;

use app\models\Job;
use app\models\JobSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

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
            Yii::$app->session->setFlash('success', 'Вакансия ' . $job->category->name . ' добавлена');
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

    public function actionEditcommentary() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('editableKey');
        $index = Yii::$app->request->post('editableIndex');

        $job = Job::findOne($id);

        $job->commentary = Yii::$app->request->post('Job')[$index]['commentary'];

        if ($job->update()) {
            $message = '';
        } else {
            $message = $job->errors;
        }

        return ['output' => $job->commentary, 'message' => $message];
    }

    public function actionEditenddate() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('editableKey');
        $index = Yii::$app->request->post('editableIndex');

        $job = Job::findOne($id);

        $job->end_date = Yii::$app->request->post('Job')[$index]['end_date'];

        if ($job->save()) {
            $message = '';
        } else {
            $message = $job->errors;
        }

        return ['output' => Yii::$app->formatter->asDate($job->end_date, 'd MMMM yyyy'), 'message' => $message];
    }
}