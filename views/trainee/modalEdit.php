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

$modalId = 'trainee-modal-' . $trainee->uniqueId;
$formId = 'trainee-form-' . $trainee->uniqueId;

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'title' => Icon::show('user') . ' Редактирование стажёра',
    'clientOptions' => [
        'keyboard' => true,
        'focus' => true,
    ],
    'options' => [
        'tabindex' => false,
        'id' => $modalId,
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
            'onclick' => new \yii\web\JsExpression('$("#' . $modalId . '").modal("hide")'),
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