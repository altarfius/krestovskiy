<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap4\Alert;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Candidate;

$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'action' => ['candidate/edit'],
    'fieldConfig' => [
        'labelSpan' => 4,
    ],
]);

//echo Alert::widget([
//    'body' => Icon::show('exclamation-circle') . ' Все поля обязательны для заполнения!',
//    'closeButton' => false,
//    'options' => [
//        'class' => 'alert-warning',
//    ],
//]);

echo Form::widget([
    'model' => $candidate,
    'form' => $form,
    'columns' => 2,
    'compactGrid' => true,
    'attributes' => [
        'call_type' => [
            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
            'items' => [0 => 'Входящий', 1 => 'Исходящий'],
            'options' => ['class' => 'btn-block'],
        ],
    ],
]);
echo Form::widget([
    'model' => $candidate,
    'form' => $form,
    'columns' => 2,
    'compactGrid' => true,
    'attributes' => [
        'surname' => [
            'type' => Form::INPUT_TEXT,
        ],
        'name' => [
            'type' => Form::INPUT_TEXT,
        ],
        'patronymic' => [
            'type' => Form::INPUT_TEXT,
        ],
        'age' => [
            'type' => Form::INPUT_TEXT,
        ],
        'gender' => [
            'beginLabel' => 'asd',
            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
            'items' => [0 => 'Мужской', 1 => 'Женский'],
            'options' => ['class' => 'btn-block'],
        ],
        'nationality' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($nationalities, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('flag'),
                    ],
                ],
            ],
        ],
        'phone' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => '+7 (999) 999-99-99',
                'clientOptions' => [
                    'clearIncomplete' => true,
                ],
            ],
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('mobile-alt'),
                    ],
                ],
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
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('subway'),
                    ],
                ],
            ],
        ],
    ],
]);

echo Form::widget([
    'model' => $candidate,
    'form' => $form,
    'columns' => 2,
    'compactGrid' => true,
//    'contentBefore' => Html::tag('legend', Html::tag('small', 'Вакансия'), ['class' => 'text-info']),
    'attributes' => [
//        'type' => [
//            'type' => Form::INPUT_RADIO_BUTTON_GROUP,
//            'items' => [0 => 'Офис', 1 => 'Ресторан'],
//            'options' => ['class' => 'btn-block'],
//        ],
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
            'columnOptions' => ['colspan' => 2],
        ],
        'division' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($divisions, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'interview_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DatePicker::class,
            'options' => [
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                ],
                'options' => [
                    'autocomplete' => 'off',
                ],
            ],
            'fieldConfig' => [
                'labelSpan' => 6,
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
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('newspaper'),
                    ],
                ],
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
    ],
]);

ActiveForm::end();