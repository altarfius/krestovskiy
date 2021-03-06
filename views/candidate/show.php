<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\bs4dropdown\ButtonDropdown;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;

$this->title = 'Кандидаты';

$this->params['breadcrumbs'][] =  'Персонал';
$this->params['breadcrumbs'][] =  $this->title;

$today = new DateTime();
$dayInterval = new DateInterval('P1D');
$weekInterval = new DateInterval('P1W');

$weekAgo = clone $today;
$weekAgo->sub($weekInterval);

$yesterday = clone $today;
$yesterday->sub($dayInterval);

$tomorrow = clone $today;
$tomorrow->add($dayInterval);

echo Html::beginTag('div', ['class' => 'row']);

    echo Html::beginTag('div', ['class' => 'col-3']);
        echo Html::beginTag('div', ['class' => 'row']);
            echo Html::button(Icon::show('plus') . ' Новый кандидат', [
                'class' => 'btn btn-primary mt-2 ml-3',
                'data-toggle' => 'modal',
                'data-target' => '#candidate-modal-new',
            ]);
        echo Html::endTag('div');
    echo Html::endTag('div');

    echo Html::beginTag('div', ['class' => 'col-9']);
        echo Html::beginTag('div', ['class' => 'row float-right']);
            echo Html::a('За неделю', [
                'candidate/show',
                'CandidateSearch' => [
                    'date_from' => $weekAgo->format('d.m.Y'),
                    'date_to' => $today->format('d.m.Y'),
                ],
            ], [
                'class' => 'btn btn-primary mt-2 mr-3',
            ]);
            echo Html::a('За вчера', [
                'candidate/show',
                'CandidateSearch' => [
                    'date_from' => $yesterday->format('d.m.Y'),
                    'date_to' => $yesterday->format('d.m.Y'),
                ],
            ], [
                'class' => 'btn btn-primary mt-2 mr-3',
            ]);
            echo Html::a('За сегодня', [
                'candidate/show',
                'CandidateSearch' => [
                    'date_from' => $today->format('d.m.Y'),
                    'date_to' => $today->format('d.m.Y'),
                ],
            ], [
                'class' => 'btn btn-primary mt-2 mr-3',
            ]);
            echo Html::a('За завтра', [
                'candidate/show',
                'CandidateSearch' => [
                    'date_from' => $tomorrow->format('d.m.Y'),
                    'date_to' => $tomorrow->format('d.m.Y'),
                ],
            ], [
                'class' => 'btn btn-primary mt-2 mr-3',
            ]);
            echo $this->render('search', ['model' => $candidateSearch]);
        echo Html::endTag('div');
    echo Html::endTag('div');

echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-12']);
        echo GridView::widget([
            'summary' => false,
            'bordered' => false,
            'condensed' => true,
            'responsive' => false,
            'showPageSummary' => false,
            'containerOptions' => [
                'class' => 'mt-2',
            ],
            'dataProvider'=> $candidateProvider,
            'rowOptions' => function($model) {
                return ['class' => $model->styleByStatus];
            },
            'filterModel' => $candidateSearch,
            'columns' => [
                [
                    'class' => SerialColumn::class,
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '36px',
                    'header' => '#',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'fullname',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $this->render('modal', [
                            'candidate' => $model,
                        ]) .
                        PopoverX::widget([
                            'header' => false,
                            'closeButton' => false,
                            'placement' => PopoverX::ALIGN_RIGHT,
                            'content' => $this->render('detailView', [
                                'candidate' => $model,
                            ]),
                            'toggleButton' => [
                                'label' => $model->fullname,
                                'class' => 'btn btn-link',
                                'onclick' => new JsExpression('
                                    $("#candidate-modal-' . $model->uniqueId . '").modal("show");
                                '),
                            ],
                            'pluginOptions' => [
                                'trigger' => 'hover',
                            ],
                        ]);
                    },
                    'width' => '225px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_TYPEAHEAD,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['candidate/find']) . '&q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ],
                            ]
                        ]
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                    'pageSummary' => function ($summary, $data, $widget) { return 'Count is ' . $summary; },
                    'pageSummaryFunc' => GridView::F_COUNT,
                ],
                [
                    'attribute' => 'phone',
                    'width' => '130px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filter' => MaskedInput::widget([
                        'model' => $candidateSearch,
                        'attribute' => 'phone',
                        'mask' => '+7 (999) 999-99-99',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Фильтровать по...',
                        ],
                    ]),
                ],
                [
                    'attribute' => 'category',
                    'value' => function($model) {
                        return $model->category->name;
                    },
                    'width' => '250px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($categories, 'id', 'name', 'categoryType.name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'width' => '175px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'content' => function($model) use ($statuses) {
                        return ButtonDropdown::widget([
                            'label' => $model->status->name,
                            'buttonOptions' => [
                                'class' => 'btn-'. $model->status->style .' btn-sm ' . ($model->is_trainee || $model->is_employee ? 'disabled' : ''),
                            ],
                            'dropdown' => [
                                'items' => $model->renderDropdownItems(),
                            ],
                        ]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($statuses, 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'class' => EditableColumn::class,
                    'attribute' => 'interview_datetime',
                    'format' => ['datetime', 'd MMMM в HH:mm'],
                    'width' => '175px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_DATETIME,
                    'filterWidgetOptions' => [
//                        'pluginOptions' => [
//                            'autoclose' => true,
//                            'todayHighlight' => true,
//                        ],
                        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy HH:ii',
                            'minuteStep' => 30,
                            'todayHighlight' => true,
                        ],
                        'options' => [
                            'autocomplete' => 'off',
                        ],
                    ],
                    'editableOptions' => function ($model) {
                        return [
                            'widgetClass' => DateTimePicker::class,
                            'inputType' => Editable::INPUT_WIDGET,
                            'preHeader' => '',
                            'header' => 'Время собеседования',
                            'placement' => PopoverX::ALIGN_LEFT,
                            'valueIfNull' => Html::tag('em', 'Не назначено'),
                            'showButtonLabels' => true,
                            'submitButton' => [
                                'icon' => false,
                                'label' => 'Сохранить',
                                'class' => 'btn btn-sm btn-primary'
                            ],
                            'resetButton' => [
                                'icon' => false,
                            ],
                            'options' => [
                                'type' => DateTimePicker::TYPE_INLINE,
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd.mm.yyyy HH:ii',
                                    'minuteStep' => 30,
                                    'todayHighlight' => true,
                                ],
                                'options' => [
                                    'id' => 'candidate-interview-datetime-' . $model->uniqueId,
                                    'autocomplete' => 'off',
                                ],
                            ],
                            'formOptions' => [
                                'action' => ['candidate/editinterviewdatetime'],
                            ],
                        ];
                    },
                ],
                [
                    'class' => EditableColumn::class,
                    'attribute' => 'trainee_date',
                    'format' => ['date', 'd MMMM'],
                    'width' => '145px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                        ],
                    ],
                    'editableOptions' => function ($model) {
                        return [
                            'widgetClass' => DatePicker::class,
                            'inputType' => Editable::INPUT_WIDGET,
                            'preHeader' => '',
                            'header' => 'Дата начала стажировки',
                            'placement' => PopoverX::ALIGN_LEFT,
                            'valueIfNull' => Html::tag('em', 'Не назначено'),
                            'showButtonLabels' => true,
                            'submitButton' => [
                                'icon' => false,
                                'label' => 'Сохранить',
                                'class' => 'btn btn-sm btn-primary'
                            ],
                            'resetButton' => [
                                'icon' => false,
                            ],
                            'options' => [
                                'type' => DatePicker::TYPE_INLINE,
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                    'format' => 'dd.mm.yyyy',
                                ],
                                'options' => [
                                    'id' => 'edit-trainee-date-' . $model->uniqueId,
                                    'autocomplete' => 'off',
                                ],
                            ],
                            'formOptions' => [
                                'action' => ['candidate/edittraineedate'],
                            ],
                        ];
                    },
                ],
                [
                    'attribute' => 'manager',
                    'value' => function($model) {
                        return $model->manager->initials;
                    },
                    'width' => '105px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($managers, 'id', 'initials'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'allowClear' => true,
                            'autoclose' => true,
                            'todayHighlight' => true,
                        ],
                        'options' => [
                            'autocomplete' => 'off',
                        ],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'create_time',
                    'format' => ['date', 'd MMMM в HH:mm'],
                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
            ],
        ]);
    echo Html::endTag('div');
echo Html::endTag('div');
