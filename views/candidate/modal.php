<?php

use app\models\Division;
use app\models\Nationality;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;
use app\models\Candidate;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use app\models\Status;

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'title' => Icon::show('user') . ' Новый кандидат',
    'options' => [
        'tabindex' => false,
        'id' => 'new-candidate-modal',
    ],
    'footer' => join('', [
        Html::resetButton('Закрыть', [
            'type' => 'button',
            'form' => 'new-candidate-form',
            'class' => 'btn btn-secondary',
            'onclick' => new \yii\web\JsExpression('$("#new-candidate-modal").modal("hide")'),
        ]),
        Html::submitButton('Сохранить', [
            'type' => 'button',
            'form' => 'new-candidate-form',
            'class' => 'btn btn-primary',
        ])
    ]),
]);
    echo $this->render('form', [
        'candidate' => new Candidate(),
        'categories' => Category::find()->all(),
        'sources' => Source::find()->all(),
        'metros' => Metro::find()->all(),
        'divisions' => Division::find()->all(),
        'nationalities' => Nationality::find()->all(),
        'statuses' => Status::find()->byStage()->all(),
    ]);
Modal::end();