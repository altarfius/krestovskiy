<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'action' => ['candidate/edit'],
]);

echo Form::widget([
    'model' => $candidate,
    'form' => $form,
    'columns' => 1,
    'compactGrid' => true,
    'attributes' => [
        'call_type' => [
            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
            'items' => [0 => 'Входящий', 1 => 'Исходящий'],
        ],
        'surname' => [
            'type' => Form::INPUT_TEXT,
        ],
        'name' => [
            'type' => Form::INPUT_TEXT,
        ],
        'patronymic' => [
            'type' => Form::INPUT_TEXT,
        ],
        'gender' => [
            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
            'items' => [0 => 'Мужской', 1 => 'Женский'],
        ],
        'age' => [
            'type' => Form::INPUT_TEXT,
        ],
        'phone' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => '+7 (999) 999-99-99',
            ],
        ],
        'metro' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($metros, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'type' => [
            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
            'items' => [0 => 'Офис', 1 => 'Ресторан'],
        ],
        'category' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($categories, 'id', 'name', function ($category) {
                    return $category->categoryType->name;
                }),
                'options' => ['placeholder' => 'Выберите...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'source' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($sources, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'interview_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => '99.99.9999',
            ],
        ],
        'status' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($statuses, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
                'hideSearch' => true,
            ],
        ],
    ]
]);

ActiveForm::end();