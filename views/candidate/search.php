<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap4\ButtonGroup;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_INLINE,
    'action' => ['candidate/show'],
    'method' => 'get',
    'fieldConfig' => [
        'options' => ['class' => 'form-group  mt-2 mr-3'],
    ],
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'compactGrid' => true,
    'attributes' => [
        'date_from' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DatePicker::class,
            'options' => [
                'type' => DatePicker::TYPE_RANGE,
                'attribute2' => 'date_to',
                'separator' => '-',
                'pluginOptions' => [
                    'autoclose' => true,
                ],
                'options' => ['autocomplete' => 'off'],
                'options2' => ['autocomplete' => 'off'],
            ],
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => 'Период',
                    ],
                    'append' => [
                        'content' => Html::submitButton('Найти', [
                            'class' => 'btn btn-primary',
                        ]),
                        'asButton' => true,
                    ],
                ],
            ],
        ],
    ]
]);

ActiveForm::end();