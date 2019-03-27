<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\touchspin\TouchSpin;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin([
    'id' => $formId,
    'type' => ActiveForm::TYPE_VERTICAL,
    'action' => ['job/show', 'id' => $job->id],
    'fieldConfig' => [
        'labelSpan' => 4,
    ],
]);

//echo Form::widget([
//    'model' => $candidate,
//    'form' => $form,
//    'columns' => 1,
//    'compactGrid' => true,
//    'attributes' => [
//        'type' => [
//            'type' => Form::INPUT_WIDGET,
//            'widgetClass' => Select2::class,
//            'options' => [
//                'data' => ArrayHelper::map($divisionTypes, 'id', 'name'),
//                'options' => [
//                    'id' => 'candidate-types-' . $candidate->uniqueId,
//                    'placeholder' => 'Выберите...',
//                ],
//                'hideSearch' => true,
//            ],
//        ],
//        'division' => [
//            'type' => Form::INPUT_WIDGET,
//            'widgetClass' => DepDrop::class,
//            'options' => [
//                'data' => ArrayHelper::map($divisions, 'id', 'name'),
//                'type' => DepDrop::TYPE_SELECT2,
//                'select2Options' => [
//                    'pluginOptions' => [
//                        'allowClear' => true,
//                    ],
//                ],
//                'pluginOptions' => [
//                    'depends' => ['job-types-' . $candidate->uniqueId],
//                    'placeholder' => 'Выберите...',
//                    'url' => Url::to(['division/getdivisionsbytype']),
//                ],
//                'options' => [
//                    'id' => 'candidate-divisions-' . $candidate->uniqueId,
//                ],
//            ],
//        ],
//    ],
//]);

echo Form::widget([
    'model' => $job,
    'form' => $form,
//    'columns' => 2,
    'compactGrid' => true,
    'attributes' => [
        'division' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($divisions, 'id', 'name'),
                'options' => [
                    'id' => 'job-divisions-' . $job->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('building'),
                    ],
                ],
            ],
        ],
        'category' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($categories, 'id', 'name', 'categoryType.name'),
                'options' => [
                    'id' => 'job-categories-' . $job->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('user-tie'),
                    ],
                ],
            ],
        ],
        'begin_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DatePicker::class,
            'options' => [
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                ],
                'options' => [
                    'id' => 'job-date-opened-' . $job->uniqueId,
                    'autocomplete' => 'off',
                ],
            ],
        ],
        'count_opened' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => TouchSpin::class,
            'options' => [
                'pluginOptions' => [
                    'buttonup_txt' => Icon::show('plus'),
                    'buttondown_txt' => Icon::show('minus'),
                    'initval' => 1,
                ]
            ],
        ],
    ],
]);

ActiveForm::end();