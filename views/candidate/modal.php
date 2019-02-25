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
    'toggleButton' => [
        'label' => Icon::show('plus') . ' Новый кандидат',
        'class' => 'btn btn-primary mt-2 ml-3',
    ],
    'options' => [
        'tabindex' => false,
    ],
    'footer' => join('', [
        Html::resetButton('Закрыть', [
            'type' => 'button',
            'form' => 'w1',
            'class' => 'btn btn-secondary',
            'onclick' => new \yii\web\JsExpression('$("#w0").modal("hide")'),
        ]),
        Html::submitButton('Сохранить', [
            'type' => 'button',
            'form' => 'w1',
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