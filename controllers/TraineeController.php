<?php

namespace app\controllers;

use app\models\Category;
use app\models\Division;
use app\models\Status;
use app\models\Trainee;
use app\models\TraineeSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\web\Response;

class TraineeController extends Controller
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
        return $this->actionShow();
    }

    public function actionShow()
    {
        $traineeSearch = new TraineeSearch();
        $traineeProvider = $traineeSearch->search(Yii::$app->request->get());

        return $this->render('show', [
            'traineeProvider' => $traineeProvider,
            'traineeSearch' => $traineeSearch,
            'divisions' => Division::find()->all(),
            'categories' => Category::find()->all(),
            'statuses' => Status::findActive()->byStage(Trainee::STAGE_ID)->all(),
        ]);
    }

    public function actionEdit($id)
    {
        $trainee = Trainee::findOne($id);
        if ($trainee == null) {
            throw new HttpException(400,'Стажёра с таким id не существует');
        }

        Yii::debug(Yii::$app->request->post(), __METHOD__);

        if ($trainee->load(Yii::$app->request->post())) {
            Yii::debug($trainee->attributes, __METHOD__);

            if ($trainee->save()) {
                return $this->redirect(['trainee/show']);
            } else {
                Yii::debug($trainee->errors, __METHOD__);
            }
        }

        return $this->render('show', [
            'traineeSearch' => new TraineeSearch(),
            'traineeProvider' => new ActiveDataProvider([
                'query' => Trainee::find(),
            ]),
            'newTrainee' => $trainee,
            'divisions' => Division::find()->all(),
            'categories' => Category::find()->all(),
            'statuses' => Status::findActive()->byStage(Trainee::STAGE_ID)->all(),
        ]);
    }

    public function actionUpdatestatus($id, $statusId)
    {
        $trainee = Trainee::findOne($id);

        $trainee->setStatus($statusId);

        if ($trainee->readyNextLevel()) {
            $trainee->convertToEmployee();
        }

        if ($trainee->update(false)) {
            if ($trainee->is_employee) {
                return $this->redirect(['employee/show']);
            } else {
                Yii::$app->session->setFlash('success', $trainee->fullname . ' сохранён в стажеры');
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::debug($trainee->getErrorSummary(true), __METHOD__);
            $message = 'Не удалось выполнить изменения.<br>' . implode('<br>', $trainee->getErrorSummary(true));
            Yii::$app->session->setFlash('danger', $message);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeletephoto($traineeId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $trainee = Trainee::findOne($traineeId);
        if ($trainee == null) {
            throw new HttpException(400, 'Сотрудник с ID ' . $traineeId . ' не найден');
        }

        $photoUrlForPhysicalDeleted = Yii::getAlias('@webroot/img/' . $trainee->photo);

        $trainee->photo = null;

        if ($trainee->save() && @unlink($photoUrlForPhysicalDeleted)) {
            Yii::debug('Фотография сотрудника ' . $traineeId . ' успешно удалена', __METHOD__);

            return true;
        }

        Yii::debug($trainee->getErrorSummary(true), __METHOD__);

        return $photoUrlForPhysicalDeleted;
    }

    public function actionFind($q) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $trainees = Trainee::find()->likeFullname($q)->all();
        Yii::debug(Trainee::find()->likeFullname($q));

        $out = [];

        foreach ($trainees as $trainee) {
            $out[] = [
                'id' => $trainee->id,
                'value' => $trainee->fullname
            ];
        }

        return $out;
    }
}