<?php

use app\models\Candidate;
use app\models\Division;
use app\models\DivisionType;
use app\models\Nationality;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;
use app\models\Category;
use app\models\Source;
use app\models\Metro;
use app\models\Status;
use yii\web\JsExpression;

$modalId = 'candidate-modal-' . $candidate->uniqueId;
$formId = 'candidate-form-' . $candidate->uniqueId;

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'title' => Icon::show('user') . ($candidate->isNewRecord ? ' Новый кандидат' : ' ' . $candidate->fullname),
    'options' => [
        'tabindex' => false,
        'id' => $modalId,
    ],
    'toggleButton' => false,
    'footer' => join('', [
        Html::tag('div', 'Создан ' . Yii::$app->formatter->asDatetime($candidate->create_time), ['style' => 'width: 100%;']),
        Html::resetButton('Закрыть', [
            'type' => 'button',
            'form' => $formId,
            'class' => 'btn btn-secondary',
            'onclick' => new JsExpression('$("#' . $modalId . '").modal("hide")'),
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
        'candidate' => $candidate,
        'categories' => Category::find()->all(),
        'sources' => Source::find()->all(),
        'metros' => Metro::find()->all(),
        'divisions' => Division::find()->byType(Division::RESTAURANT)->all(),
        'nationalities' => Nationality::find()->all(),
        'statuses' => Status::findActive()->byStage(Candidate::STAGE_ID)->byParent($candidate->status_id)->all(),
        'divisionTypes' => DivisionType::find()->all(),
    ]);
Modal::end();