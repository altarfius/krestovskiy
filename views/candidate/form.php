<?php

use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin([
    'id' => $formId,
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
            'options' => [
                'id' => 'candidate-surname-' . $candidate->uniqueId,
            ],
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
                'options' => [
                    'id' => 'candidate-nationalities-' . $candidate->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
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
                'options' => [
                    'id' => 'candidate-phone-' . $candidate->uniqueId,
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    'clearIncomplete' => true,
                ],
            ],
            'fieldConfig' => [
                'enableAjaxValidation' => true,
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
                'options' => [
                    'id' => 'candidate-metros-' . $candidate->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
                'pluginOptions' => [
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
                'options' => [
                    'id' => 'candidate-types-' . $candidate->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
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
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
                'pluginOptions' => [
                    'depends' => ['candidate-types-' . $candidate->uniqueId],
                    'placeholder' => 'Выберите...',
                    'url' => Url::to(['division/getdivisionsbytype']),
                ],
                'options' => [
                    'id' => 'candidate-divisions-' . $candidate->uniqueId,
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
                'data' => ArrayHelper::map($categories, 'id', 'name', 'categoryType.name'),
                'options' => [
                    'id' => 'candidate-categories-' . $candidate->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'interview_datetime' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DatetimePicker::class,
            'options' => [
                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy HH:ii',
                    'minuteStep' => 15,
                ],
                'options' => [
                    'id' => 'candidate-interview-datetime-' . $candidate->uniqueId,
                    'autocomplete' => 'off',
                ],
            ],
            'fieldConfig' => [
                'labelSpan' => 5,
            ],
        ],
        'source' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($sources, 'id', 'name'),
                'options' => [
                    'id' => 'candidate-sources-' . $candidate->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
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
                'options' => [
                    'id' => 'candidate-statuses-' . $candidate->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
                'hideSearch' => true,
            ],
        ],
    ],
]);

ActiveForm::end();