<?php
namespace app\controllers;

use app\models\CandidateSearch;
use app\models\Status;
use app\models\Trainee;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\Candidate;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use Yii;

class CandidateController extends Controller
{
    public function actionIndex()
    {
        return $this->actionShow();
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

    public function actionEdit()
    {
        $candidate = new Candidate();

        if ($candidate->load(\Yii::$app->request->post()) && $candidate->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('form', [
            'candidate' => $candidate,
            'categories' => Category::find()->all(),
            'sources' => Source::find()->all(),
            'metros' => Metro::find()->all(),
        ]);
    }

    //TODO: ajax
    public function actionUpdatestatus($id, $statusId)
    {
        $candidate = Candidate::findOne($id);

        $candidate->setStatus($statusId);

        if ($candidate->save()) {
//            return $this->renderAjax('statusDropdown', [
//                'model' => $candidate,
//            ]);
            if ($candidate->status->next_stage == Trainee::STAGE_ID) {
                return $this->redirect(['trainee/edit', 'id' => $candidate->id]);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}