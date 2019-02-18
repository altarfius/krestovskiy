<?php

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
    'title' => 'Новый кандидат',
    'toggleButton' => [
        'label' => Icon::show('plus') . ' Новый кандидат',
        'class' => 'btn btn-primary mt-2 ml-3',
    ],
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
        'candidate' => new Candidate(),
        'categories' => Category::find()->all(),
        'sources' => Source::find()->all(),
        'metros' => Metro::find()->all(),
        'statuses' => Status::find()->byStage()->all(),
    ]);
Modal::end();