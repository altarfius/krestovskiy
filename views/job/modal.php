<?php

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

$modalId = 'job-modal-' . $job->uniqueId;
$formId = 'job-form-' . $job->uniqueId;

Modal::begin([
    'size' => Modal::SIZE_SMALL,
    'title' => 'Новая вакансия',
    'options' => [
        'tabindex' => false,
        'id' => $modalId,
    ],
    'clientOptions' => [
        'show' => boolval($job->errors),
    ],
    'toggleButton' => $job->isNewRecord ? [
        'label' => Icon::show('plus') . ' Новая вакансия',
        'class' => 'btn btn-primary',
    ] : [
        'label' => Icon::show('edit') . ' Редактирование вакансии',
        'class' => 'btn btn-link',
    ],
    'footer' => join('', [
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
        'job' => $job,
        'categories' => Category::find()->all(),
        'divisions' => Division::find()->all(),
    ]);

Modal::end();