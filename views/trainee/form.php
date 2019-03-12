<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\file\FileInput;
use kartik\icons\Icon;
use kartik\bs4dropdown\ButtonDropdown;
use kartik\switchinput\SwitchInput;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use app\models\Trainee;

$form = ActiveForm::begin([
    'id' => $formId,
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'action' => ['trainee/edit', 'id' => $trainee->id],
]);

echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-5']);
//        echo Html::img('img/test.jpg', ['class' => 'img-thumbnail', 'style' => 'height: 300px;']);
//        echo Form::widget([
//            'model' => $trainee,
//            'form' => $form,
//            'columns' => 1,
//            'compactGrid' => true,
//            'attributes' => [
//                'photo' => [
//                    'label' => false,
//                    'type' => Form::INPUT_WIDGET,
//                    'widgetClass' => FileInput::class,
//                    'options' => [
//                        'pluginOptions' => [
//                            'required' => true,
//                            'showCaption' => false,
//                            'showRemove' => false,
//                            'showUpload' => false,
//                            'hideThumbnailContent' => !boolval($trainee->photo),
//                            'browseClass' => 'btn btn-primary btn-block',
//                            'browseIcon' => Icon::show('camera'),
//                            'browseLabel' =>  'Загрузить фото'
//                        ],
//                        'options' => ['accept' => 'image/*']
//                    ],
//                ],
//            ]
//        ]);

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
                        'options' => ['class' => 'btn-block'],
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

//if ($trainee->passport_scan != null) {
//    $qwe = [
//        'passport_scan' => [
//            'type' => Form::INPUT_HIDDEN,
//        //        'staticValue' => $trainee->passport_scan,
//        ],
//        'qwe' => [
//            'type' => Form::INPUT_STATIC,
//            'staticValue' => Html::a('Просмотр', 'passport/qwe.png', ['class' => 'btn btn-primary', 'target' => '_blank']),
//            'columnOptions' => ['colspan' => 12],
//        ],
//    ];
//} else {
//    $qwe = [
//        'type' => Form::INPUT_WIDGET,
//        'widgetClass' => FileInput::class,
//        'options' => [
//            'pluginOptions' => [
//                'required' => true,
//                'showPreview' => false,
//                'showCaption' => true,
//                'showRemove' => true,
//                'showUpload' => false,
//                'browseClass' => 'btn btn-primary',
//                'browseLabel' =>  'Загрузить',
//            ],
//            'options' => ['accept' => 'image/*']
//        ],
//        'columnOptions' => ['colspan' => 12],
//    ];
//}

echo Form::widget([
    'model' => $trainee,
    'form' => $form,
    'columns' => 12,
    'compactGrid' => true,
//    'contentBefore' => Html::tag('legend', Html::tag('small', 'Паспортные данные'), ['class' => 'text-info']),
    'attributes' => [
        'passport_number' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => $trainee->passportMask,
                'clientOptions' => [
                    'clearIncomplete' => $trainee->isRussian(),
                ],
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
                                            $("#trainee-passport_number").inputmask("9999 999999", { "clearIncomplete": true });
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
        ],
        'passport_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DatePicker::class,
            'options' => [
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
//                    'endDate' => '24.02.2019',
                ],
                'options' => [
                    'autocomplete' => 'off',
                ],
            ],
            'fieldConfig' => [
                'labelSpan' => 5,
            ],
            'columnOptions' => ['colspan' => 5],
        ],
        'passport_issued' => [
            'type' => Form::INPUT_TEXTAREA,
            'options' => [
                'style' => 'resize: none;',
            ],
            'columnOptions' => ['colspan' => 12],
        ],
        'passport_scan_file' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => FileInput::class,
            'options' => [
//                'id' => ''
                'pluginOptions' => [
                    'required' => false,
                    'showPreview' => false,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary',
                    'browseLabel' =>  'Загрузить',
                ],
                'options' => ['accept' => 'image/*']
            ],
            'columnOptions' => ['colspan' => 12],
            'visible' => $trainee->passport_scan == null,
        ],
        'passport_scan' => [
            'type' => Form::INPUT_STATIC,
            'staticValue' => Html::a('Просмотр', 'passport/' . $trainee->passport_scan, ['class' => 'btn btn-primary', 'target' => '_blank']),
            'columnOptions' => ['colspan' => 12],
            'visible' => $trainee->passport_scan != null,
        ],
    ]
]);

echo Form::widget([
    'model' => $trainee,
    'form' => $form,
    'columns' => 12,
    'compactGrid' => true,
//    'contentBefore' => Html::tag('legend', Html::tag('small', 'ЛМК'), ['class' => 'text-info']),
    'attributes' => [
        'medical' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => SwitchInput::class,
            'label' => 'Личная медицинская книжка',
            'options' => [
                'pluginOptions' => [
                    'onText' => 'Есть',
                    'offText' => 'Нет',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ],
            ],
            'fieldConfig' => [
                'labelSpan' => 6,
            ],
            'columnOptions' => ['colspan' => 7],
        ],
        'medical_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => '99.99.9999',
                'clientOptions' => [
                    'clearIncomplete' => true,
                ],
            ],
            'fieldConfig' => [
                'addon' => [
                    'prepend' => [
                        'content' => Icon::show('calendar'),
                    ],
                ],
                'labelSpan' => 5,
            ],
            'columnOptions' => ['colspan' => 5],
        ],

    ]
]);

echo Form::widget([
    'model' => $trainee,
    'form' => $form,
    'columns' => 12,
    'compactGrid' => true,
//    'contentBefore' => Html::tag('legend', Html::tag('small', 'Стажировка'), ['class' => 'text-info']),
    'attributes' => [
        'division' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'label' => 'Направлен в ресторан',
            'options' => [
                'data' => ArrayHelper::map($divisions, 'id', 'name'),
                'options' => ['placeholder' => 'Выберите...'],
//                'pluginOptions' => [
//                    'allowClear' => true
//                ],
            ],
            'fieldConfig' => [
                'labelSpan' => 4,
            ],
            'columnOptions' => ['colspan' => 8],
        ],
        'trainee_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DatePicker::class,
            'label' => 'с',
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
                'labelSpan' => 2,
            ],
            'columnOptions' => ['colspan' => 4],
        ],
    ]
]);

ActiveForm::end();