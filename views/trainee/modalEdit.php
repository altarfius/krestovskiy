<?php

use app\models\Division;
use kartik\icons\Icon;
use kartik\helpers\Html;
use yii\bootstrap4\Modal;
use app\models\Trainee;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use app\models\Status;

$id = 'w' . rand(1000, 2000);
$formId = 'w' . rand(1000, 2000);

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'title' => Icon::show('user') . ' Редактирование стажёра',
    'clientOptions' => [
        'keyboard' => true,
        'focus' => true,
    ],
    'options' => [
        'tabindex' => false,
        'id' => $id,
    ],
    'toggleButton' => [
        'label' => $trainee->fullname,
        'class' => 'btn btn-link',
    ],
    'footer' => join('', [
        Html::resetButton('Закрыть', [
            'type' => 'button',
            'form' => $formId,
            'class' => 'btn btn-secondary',
            'onclick' => new \yii\web\JsExpression('$("#' . $id . '").modal("hide")'),
        ]),
        Html::submitButton('Сохранить', [
            'type' => 'button',
            'form' => $formId,
            'class' => 'btn btn-primary',
        ])
    ]),
]);
    echo $this->render('form', [
        'formId' => $formId,
        'trainee' => $trainee,
        'categories' => Category::find()->all(),
        'sources' => Source::find()->all(),
        'metros' => Metro::find()->all(),
        'statuses' => Status::find()->byStage(Trainee::STAGE_ID)->all(),
        'divisions' => Division::find()->all(),
    ]);
Modal::end();