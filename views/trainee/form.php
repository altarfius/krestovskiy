<?php

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\file\FileInput;
use kartik\icons\Icon;
use kartik\bs4dropdown\ButtonDropdown;
use kartik\switchinput\SwitchInput;
use yii\helpers\Url;
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
    echo Html::beginTag('div', ['class' => 'col-6']);
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
                    'container' => [
                        'id' => 'trainee-photo-container-' . $trainee->uniqueId,
                        'style' => boolval($trainee->photo) ? 'display: none;' : '',
                    ],
                    'options' => [
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => Icon::show('camera'),
                            'browseLabel' =>  'Загрузить фото',
                            'maxFileSize' => 20000,
                        ],
                        'options' => ['
                            accept' => 'image/*',
                            'id' => 'trainee-photo-'.$trainee->uniqueId,
                        ],
                    ],
                ],
                'photoView' => [
                    'label' => false,
                    'type' => Form::INPUT_STATIC,
                    'container' => [
                        'id' => 'trainee-photo-view-container-' . $trainee->uniqueId,
                    ],
                    'staticValue' => function($model) {
                        return
                            Html::img(Yii::getAlias('@web/img/' . $model->photo), ['class' => 'img-fluid img-thumbnail']) .
                            Html::button('Удалить', [
                                'class' => 'btn btn-primary btn-block mt-2',
                                'onclick' => new JsExpression('
                                    jQuery.get("'
                                        . Url::to(['trainee/deletephoto', 'traineeId' => $model->id]) . '",
                                        {},
                                        function(data, textStatus) {
                                            if (textStatus == "success") {
                                                $("#trainee-photo-container-' . $model->uniqueId . '").removeAttr("style"); //Надо добавить класс и его убивать
                                                $("#trainee-photo-view-container-' . $model->uniqueId . '").css("display", "none");
                                            }
                                        },
                                        "json"' .
                                    ');
                                '),
                        ]);

                    },
                    'visible' => boolval($trainee->photo),
                ],
            ]
        ]);

    echo Html::endTag('div');
    echo Html::beginTag('div', ['class' => 'col-6']);

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
                            'options' => [
                                'id' => 'trainee-phone-' . $trainee->uniqueId,
                                'class' => 'form-control'
                            ],
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
                            'options' => [
                                'id' => 'select-metros-' . $trainee->uniqueId,
                                'placeholder' => 'Выберите...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                    ],
                    'passport_type' => [
                        'type' => Form::INPUT_HIDDEN,
                        'options' => [
                            'id' => 'trainee-passport-type-' . $trainee->uniqueId,
                        ],
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
    'columns' => 2,
    'compactGrid' => true,
    'attributes' => [
        'type' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($divisionTypes, 'id', 'name'),
                'options' => [
                    'id' => 'trainee-types-' . $trainee->uniqueId,
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
                    'depends' => ['trainee-types-' . $trainee->uniqueId],
                    'placeholder' => 'Выберите...',
                    'url' => Url::to(['division/getdivisionsbytype']),
                ],
                'options' => [
                    'id' => 'trainee-divisions-' . $trainee->uniqueId,
                ],
            ],
        ],
        'category' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'options' => [
                'data' => ArrayHelper::map($categories, 'id', 'name', 'categoryType.name'),
                'options' => [
                    'id' => 'trainee-categories-' . $trainee->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
    ],
]);

echo Form::widget([
    'model' => $trainee,
    'form' => $form,
    'columns' => 12,
    'compactGrid' => true,
    'attributes' => [
        'passport_number' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => $trainee->passportMask,
                'options' => [
                    'id' => 'trainee-passport-number-' . $trainee->uniqueId,
                    'class' => 'form-control'
                ],
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
                                            $("#trainee-passport-type-button-' . $trainee->uniqueId . '").text("Паспорт РФ"); 
                                            $("#trainee-passport-number-' . $trainee->uniqueId . '").inputmask("' . Trainee::RUSSIAN_PASSPORT_MASK . '", { "clearIncomplete": true });
                                            $("#trainee-passport-type-' . $trainee->uniqueId . '").val(' . Trainee::RUSSIAN_PASSPORT . ');
                                        '),
                                    ]],
                                    ['label' => 'Иностранный паспорт', 'url' => '#', 'linkOptions' => [
                                        'onclick' => new JsExpression('
                                            $("#trainee-passport-type-button-' . $trainee->uniqueId . '").text("Иностранный паспорт");
                                            $("#trainee-passport-number-' . $trainee->uniqueId . '").inputmask("' . Trainee::FOREIGN_PASSPORT_MASK . '");
                                            $("#trainee-passport-type-' . $trainee->uniqueId . '").val(' . Trainee::FOREIGN_PASSPORT . ');
                                        '),
                                    ]],
                                ],
                            ],
                            'buttonOptions' => [
                                'id' => 'trainee-passport-type-button-' . $trainee->uniqueId,
                                'class' => 'btn-primary',
                            ],
                            'renderContainer' => false,
                        ]),
                        'asButton' => true,
                    ],
                ],
            ],
        ],
//        'medical_date' => [
//            'type' => Form::INPUT_WIDGET,
//            'widgetClass' => MaskedInput::class,
//            'options' => [
//                'mask' => '99.99.9999',
//                'clientOptions' => [
//                    'clearIncomplete' => true,
//                ],
//                'options' => [
//                    'id' => 'trainee-medical-date-' . $trainee->uniqueId,
//                    'class' => 'form-control',
//                    'autocomplete' => 'off',
//                ],
//            ],
//            'fieldConfig' => [
//                'addon' => [
//                    'prepend' => [
//                        'content' => Icon::show('calendar'),
//                    ],
//                ],
//                'labelSpan' => 5,
//            ],
//            'columnOptions' => ['colspan' => 5],
//        ],
        'passport_date' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => MaskedInput::class,
            'options' => [
                'mask' => '99.99.9999',
                'clientOptions' => [
                    'clearIncomplete' => true,
                ],
                'options' => [
                    'id' => 'trainee-passport-date-' . $trainee->uniqueId,
                    'class' => 'form-control',
                    'autocomplete' => 'off',
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
                'options' => [
                    'id' => 'trainee-medical-' . $trainee->uniqueId,
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
                'options' => [
                    'id' => 'trainee-medical-date-' . $trainee->uniqueId,
                    'class' => 'form-control',
                    'autocomplete' => 'off',
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
    'attributes' => [
        'division' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => Select2::class,
            'label' => 'Направлен в ресторан',
            'options' => [
                'data' => ArrayHelper::map($divisions, 'id', 'name'),
                'options' => [
                    'id' => 'trainee-division-' . $trainee->uniqueId,
                    'placeholder' => 'Выберите...',
                ],
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
                    'todayHighlight' => true,
                ],
                'options' => [
                    'id' => 'trainee-trainee-date-' . $trainee->uniqueId,
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