<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 28.03.2019
 * Time: 8:13
 */

namespace app\controllers;

use app\models\Source;
use app\models\SourceFact;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class MediaplanController extends Controller
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

    public function actionShow() {
        $sourceFacts = SourceFact::find()->all();

        if ($sourceFacts == null) {
            $sources = Source::find()->all();

            array_walk($sources, function($source) {
                $sourceFact = new SourceFact();
                $sourceFact->source = $source;
                $sourceFact->create_user_id = \Yii::$app->user->id;
                $sourceFact->create_time = date(DATE_ISO8601);
                $sourceFact->save();
            });
        }

        $sourceFactProvider = new ActiveDataProvider([
            'query' => SourceFact::find(),
        ]);

        return $this->render('show', [
            'sourceFactProvider' => $sourceFactProvider,
        ]);
    }
}