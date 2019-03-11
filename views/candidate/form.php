<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin([
    'id' => 'new-candidate-form',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'action' => ['candidate/edit'],
    'fieldConfig' => [
        'labelSpan' => 4,
    ],
]);

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
            'fieldConfig' => [
                'labelSpan' => 2,
            ],
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
//                    'templateResult' => new JsExpression('function format(state) {
//                        var lineStyleArray = ' . \yii\helpers\Json::encode(Metro::$lineStyleArray) . ';
//
//                        return "<span style=\"color: " + lineStyleArray[state.id] + ";\">" + state.text + "</span>";
//                    }'),
//                    'templateSelection' => new JsExpression('function format(state) {
//                        if (!state.id) return state.text;
//                        return state.text + "!";
//                    }'),
//                    'escapeMarkup' => new JsExpression("function(m) { return m; }"),
                    'allowClear' => true,
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
    'attributes' => [
        'type' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($divisionTypes, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
                'hideSearch' => true,
            ],
        ],
        'division' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DepDrop::class,
            'options' => [
                'data' => ArrayHelper::map($divisions, 'id', 'name'),
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => [
                    'hideSearch' => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
                'pluginOptions' => [
                    'depends' => ['candidate-type'],
                    'placeholder' => 'Выберите...',
                    'url' => Url::to(['division/getdivisionsbytype']),
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
    'attributes' => [
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