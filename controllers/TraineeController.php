<?php

namespace app\controllers;

use app\models\Status;
use app\models\Trainee;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;

class TraineeController extends Controller
{
    public function actionIndex()
    {
        return $this->actionShow();
    }

    public function actionShow()
    {
        return $this->render('show', [
            'traineeProvider' => new ActiveDataProvider([
                'query' => Trainee::find(),
            ]),
            'statuses' => Status::find()->all(),
        ]);
    }

    public function actionEdit($id)
    {
        $trainee = Trainee::findOne($id);

        if ($trainee->load(Yii::$app->request->post())) {
            Yii::debug($trainee->attributes, __METHOD__);

            if ($trainee->save()) {
                return $this->redirect(['trainee/show']);
            } else {
                Yii::debug($trainee->errors, __METHOD__);
            }
        }

        return $this->render('show', [
            'traineeProvider' => new ActiveDataProvider([
                'query' => Trainee::find(),
            ]),
            'newTrainee' => Trainee::findOne($id),
            'statuses' => Status::find()->all(),
        ]);
    }

    public function actionUpdatestatus($id, $statusId)
    {
        $trainee = Trainee::findOne($id);

        $trainee->setStatus($statusId);

        if ($trainee->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::debug($trainee->getErrorSummary(true), __METHOD__);
            $message = 'Не удалось выполнить изменения.<br>' . implode('<br>', $trainee->getErrorSummary(true));
            Yii::$app->session->setFlash('danger', $message);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}