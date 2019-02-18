<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\file\FileInput;
use kartik\icons\Icon;
use kartik\bs4dropdown\ButtonDropdown;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use app\models\Trainee;

$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'action' => ['trainee/edit', 'id' => $trainee->id],
    'options' => ['enctype' => 'multipart/form-data'],
]);

echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-5']);

        echo Form::widget([
            'model' => $trainee,
            'form' => $form,
            'columns' => 1,
            'compactGrid' => true,
            'attributes' => [
                'photo' => [
                    'label' => false,
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => FileInput::class,
                    'options' => [
                        'pluginOptions' => [
                            'required' => true,
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'hideThumbnailContent' => true,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => Icon::show('camera'),
                            'browseLabel' =>  'Загрузить фото'
                        ],
                        'options' => ['accept' => 'image/*']
                    ],
                ],
            ]
        ]);

    echo Html::endTag('div');
    echo Html::beginTag('div', ['class' => 'col-7']);

            echo Form::widget([
                'model' => $trainee,
                'form' => $form,
                'columns' => 1,
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
                    'gender' => [
                        'type' => Form::INPUT_RADIO_BUTTON_GROUP,
                        'items' => [0 => 'Мужской', 1 => 'Женский'],
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
                    'passport_type' => [
                        'type' => Form::INPUT_HIDDEN,
                    ],
                ]
            ]);

    echo Html::endTag('div');
echo Html::endTag('div');

echo Form::widget([
    'model' => $trainee,
    'form' => $form,
    'columns' => 12,
    'compactGrid' => true,
    'attributes' => [
        'passport_number' => array_merge([], [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => $trainee->passportMask,
            ],
            'columnOptions' => ['colspan' => 7],
            'label' => false,
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => ButtonDropdown::widget([
                            'label' => $trainee->passport_type == Trainee::FOREIGN_PASSPORT ? 'Иностранный паспорт' : 'Паспорт РФ',
                            'dropdown' => [
                                'items' => [
                                    ['label' => 'Паспорт РФ', 'url' => '#', 'linkOptions' => [
                                        'onclick' => new JsExpression('
                                            $("#w4-button").text("Паспорт РФ"); 
                                            $("#trainee-passport_number").inputmask("9999 999999");
                                            $("#trainee-passport_type").val(' . Trainee::RUSSIAN_PASSPORT . ');
                                        '),
                                    ]],
                                    ['label' => 'Иностранный паспорт', 'url' => '#', 'linkOptions' => [
                                        'onclick' => new JsExpression('
                                            $("#w4-button").text("Иностранный паспорт");
                                            $("#trainee-passport_number").inputmask("*{1,100}");
                                            $("#trainee-passport_type").val(' . Trainee::FOREIGN_PASSPORT . ');
                                        '),
                                    ]],
                                ],
                            ],
                            'buttonOptions' => ['class' => 'btn-primary'],
                            'renderContainer' => false,
                        ]),
                        'asButton' => true,
                    ],
                ],
            ],
        ]),
        'passport_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'columnOptions' => ['colspan' => 5],
            'options' => [
                'mask' => '99.99.9999',
            ],
            'fieldConfig' => [
                'labelSpan' => 5,
                'addon' => [
                    'append' => [
                        'content' => \kartik\icons\Icon::show('calendar'),
                    ],
                ],
            ],
        ],
    ]
]);

echo Form::widget([
    'model' => $trainee,
    'form' => $form,
    'compactGrid' => true,
    'attributes' => [
        'passport_issued' => [
            'type' => Form::INPUT_TEXTAREA,
            'options' => [
                'placeholder' => $trainee->getAttributeLabel('passport_issued'),
                'style' => 'resize: none;',
            ],
        ],
    ]
]);

ActiveForm::end();