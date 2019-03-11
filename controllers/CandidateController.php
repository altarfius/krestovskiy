<?php
namespace app\controllers;

use app\models\CandidateSearch;
use app\models\Division;
use app\models\DivisionType;
use app\models\Nationality;
use app\models\Status;
use app\models\Trainee;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Candidate;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use Yii;

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
            'statuses' => Status::find()->all(),
        ]);
    }

    public function actionEdit($id = null)
    {
        $candidate = Candidate::findOne($id);
        if ($candidate == null) {
            $candidate = new Candidate();
        }

        if ($candidate->load(Yii::$app->request->post()) && $candidate->save()) {
            Yii::$app->session->setFlash('success', 'Кандидат сохранён');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('form', [
            'candidate' => $candidate,
            'categories' => Category::find()->all(),
            'sources' => Source::find()->all(),
            'metros' => Metro::find()->all(),
            'nationalities' => Nationality::find()->all(),
            'divisions' => Division::find()->all(),
            'statuses' => Status::find()->all(),
        ]);
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