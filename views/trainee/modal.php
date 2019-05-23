<?php

use app\models\Division;
use app\models\DivisionType;
use kartik\icons\Icon;
use kartik\helpers\Html;
use yii\bootstrap4\Modal;
use app\models\Trainee;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use app\models\Status;

$formId = 'w' . rand(1000, 2000);

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'title' => Icon::show('user') . ' Новый стажёр',
    'clientOptions' => [
        'show' => true,
        'focus' => true,
    ],
    'options' => [
        'tabindex' => false,
    ],
    'footer' => join('', [
        Html::tag('div', 'Создан ' . Yii::$app->formatter->asDatetime($trainee->create_time), ['style' => 'width: 100%;']),
        Html::resetButton('Закрыть', [
            'type' => 'button',
            'form' => $formId,
            'class' => 'btn btn-secondary',
            'onclick' => new \yii\web\JsExpression('$("#w0").modal("hide")'),
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
        'divisions' => Division::find()->byType($trainee->division->division_type_id)->all(),
        'divisionTypes' => DivisionType::find()->all(),
    ]);
Modal::end();