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
use yii\bootstrap4\Button;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Сотрудники';

echo GridView::widget([
//    'summary' => false,
    'bordered' => false,
//    'condensed' => true,
    'responsive' => false,
//    'rowOptions' => function($model) {
//        return ['class' => $model->styleByCompletion];
//    },
    'panel' => [
        'type' => GridView::TYPE_DEFAULT,
        'heading' => Html::tag('h6', $this->title, ['class' => 'mb-0']),
                'before' => false,
        'after' => false,
        'footer' => false,
    ],
//    'toolbar' => [
//        [
//            'content' => Html::button(
//                Icon::show('plus') . ' Новый сотрудник',
//                ['class' => 'btn btn-primary disabled']
//            ),
//            'options' => ['class' => '']
//        ],
//    ],
    'summaryOptions' => ['class' => 'h6 m-0'],
    'showPageSummary' => true,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary'],
    'dataProvider'=> $employeeProvider,
//    'rowOptions' => function($model) {
//        return ['class' => $model->styleByStatus];
//    },
//    'filterModel' => $candidateSearch,
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
//            'value' => function($model) {
//                return $this->render('modal', [
//                        'candidate' => $model,
//                    ]) .
//                    PopoverX::widget([
//                        'header' => false,
//                        'closeButton' => false,
//                        'placement' => PopoverX::ALIGN_RIGHT,
//                        'content' => $this->render('detailView', [
//                            'candidate' => $model,
//                        ]),
//                        'toggleButton' => [
//                            'label' => $model->fullname,
//                            'class' => 'btn btn-link',
//                            'onclick' => new JsExpression('
//                                    $("#candidate-modal-' . $model->uniqueId . '").modal("show");
//                                '),
//                        ],
//                        'pluginOptions' => [
//                            'trigger' => 'hover',
//                        ],
//                    ]);
//            },
//            'width' => '265px',
            'vAlign' => GridView::ALIGN_MIDDLE,
//            'filterType' => GridView::FILTER_TYPEAHEAD,
//            'filterWidgetOptions' => [
//                'pluginOptions' => ['highlight' => true],
//                'dataset' => [
//                    [
//                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                        'display' => 'value',
//                        'remote' => [
//                            'url' => Url::to(['candidate/find']) . '&q=%QUERY',
//                            'wildcard' => '%QUERY'
//                        ],
//                    ]
//                ]
//            ],
//            'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
            'pageSummary' => function ($summary) {
                return 'Всего ' . $summary . ' сотрудников';
            },
            'pageSummaryFunc' => GridView::F_COUNT,
        ],
        [
            'attribute' => 'phone',
//            'width' => '90px',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'attribute' => 'division',
            'value' => 'division.name',
//            'width' => '160px',
            'vAlign' => GridView::ALIGN_MIDDLE,
//            'filterType' => GridView::FILTER_SELECT2,
//            'filter' => ArrayHelper::map($divisions, 'id', 'name'),
//            'filterWidgetOptions' => [
//                'pluginOptions' => ['allowClear' => true],
//            ],
//            'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
        ],
        [
            'attribute' => 'category',
            'value' => function($model) {
                return $model->category->name;
            },
            'width' => '250px',
            'vAlign' => GridView::ALIGN_MIDDLE,
//            'filterType' => GridView::FILTER_SELECT2,
//            'filter' => ArrayHelper::map($categories, 'id', 'name', 'categoryType.name'),
//            'filterWidgetOptions' => [
//                'pluginOptions' => ['allowClear' => true],
//            ],
//            'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
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
                        'class' => 'btn-'. $model->status->style .' btn-sm ',
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
            'attribute' => 'manager',
            'value' => function($model) {
                return $model->manager->initials;
            },
//            'width' => '105px',
            'vAlign' => GridView::ALIGN_MIDDLE,
//            'filterType' => GridView::FILTER_SELECT2,
//            'filter' => ArrayHelper::map($managers, 'id', 'initials'),
//            'filterWidgetOptions' => [
//                'pluginOptions' => [
//                    'allowClear' => true,
//                    'autoclose' => true,
//                    'todayHighlight' => true,
//                ],
//                'options' => [
//                    'autocomplete' => 'off',
//                ],
//            ],
//            'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
        ],
//        [
//            'attribute' => 'create_time',
//            'format' => ['date', 'd MMMM в HH:mm'],
//            'width' => '85px',
//            'vAlign' => GridView::ALIGN_MIDDLE,
//        ],
    ],
]);
//echo Html::endTag('div');
//echo Html::endTag('div');
