<?php

use kartik\icons\Icon;
use kartik\helpers\Html;
use yii\bootstrap4\Modal;
use app\models\Trainee;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use app\models\Status;

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'title' => Icon::show('user') . ' Новый стажёр',
    'clientOptions' => [
        'show' => $trainee instanceof Trainee,
        'keyboard' => false,
        'focus' => true,
        'backdrop' => 'static',
    ],
    'closeButton' => false,
    'footer' => join('', [
        Html::resetButton('Закрыть', [
            'type' => 'button',
            'form' => 'w1',
            'class' => 'btn btn-secondary',
        ]),
        Html::submitButton('Сохранить', [
            'type' => 'button',
            'form' => 'w1',
            'class' => 'btn btn-primary',
        ])
    ]),
]);
    echo $this->render('form', [
        'trainee' => $trainee,
        'categories' => Category::find()->all(),
        'sources' => Source::find()->all(),
        'metros' => Metro::find()->all(),
        'statuses' => Status::find()->byStage(Trainee::STAGE_ID)->all(),
    ]);
Modal::end();