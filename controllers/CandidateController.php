<?php
namespace app\controllers;

use app\models\CandidateSearch;
use app\models\Division;
use app\models\DivisionType;
use app\models\Nationality;
use app\models\Status;
use app\models\Trainee;
use app\models\User;
use kartik\form\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\Candidate;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use Yii;
use yii\web\Response;

class CandidateController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
//                'only' => ['show', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
//                        'actions' => ['login', 'signup'],
                        'roles' => ['@'],
                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['logout'],
//                        'roles' => ['@'],
//                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['candidate/show']);
    }

    public function actionShow()
    {
        $candidateSearch = new CandidateSearch();
        $candidateProvider = $candidateSearch->search(Yii::$app->request->get());

        return $this->render('show', [
            'candidateProvider' => $candidateProvider,
            'candidateSearch' => $candidateSearch,
            'nationalities' => Nationality::find()->all(),
            'categories' => Category::find()->all(),
            'metros' => Metro::find()->all(),
            'statuses' => Status::find()->byStage()->all(), //TODO: Резервы не все отображаются при фильтре
            'managers' => User::find()->all(),
        ]);
    }

    public function actionEdit($id = null)
    {
        $candidate = Candidate::findOne($id);
        if ($candidate == null) {
            $candidate = new Candidate();
        }

        if (Yii::$app->request->isAjax && $candidate->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($candidate, 'phone');
        }

        if ($candidate->load(Yii::$app->request->post()) && $candidate->save()) {
            Yii::$app->session->setFlash('success', $candidate->fullname . ' сохранён в кандидаты');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('form', [
            'formId' => 'candidate-form-' . $candidate->uniqueId,
            'candidate' => $candidate,
            'categories' => Category::find()->all(),
            'sources' => Source::find()->all(),
            'metros' => Metro::find()->all(),
            'nationalities' => Nationality::find()->all(),
            'divisions' => Division::find()->all(),
            'divisionTypes' => DivisionType::find()->all(),
            'statuses' => Status::find()->all(),
        ]);
    }

    public function actionFind($q) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $candidates = Candidate::find()->likeFullname($q)->all();

        $out = [];

        foreach ($candidates as $candidate) {
            $out[] = [
                'id' => $candidate->id,
                'value' => $candidate->fullname
            ];
        }

        return $out;
    }

    //TODO: ajax
    public function actionUpdatestatus($id, $statusId)
    {
        $candidate = Candidate::findOne($id);

        $candidate->setStatus($statusId);
        if ($candidate->save()) {
            if ($candidate->status->next_stage == Trainee::STAGE_ID) {
                return $this->redirect(['trainee/edit', 'id' => $candidate->id]);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}