<?php

use kartik\date\DatePicker;
use kartik\editable\Editable;
use kartik\grid\ActionColumn;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
use yii\bootstrap4\Progress;
use yii\web\JsExpression;

$this->title = 'Вакансии';

//$this->params['breadcrumbs'][] =  'Персонал';
//$this->params['breadcrumbs'][] =  $this->title;

        echo GridView::widget([
            'bordered' => false,
//            'condensed' => true,
            'responsive' => false,
            'rowOptions' => function($model) {
                return ['class' => $model->styleByCompletion];
            },
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => Html::tag('h6', 'Вакансии', ['class' => 'mb-0']),
//                'before' => false,
                'after' => false,
                'footer' => false,
            ],
            'toolbar' => [
                [
                    'content' =>
                        $this->render('modal', [
                            'job' => $job,
                        ]),
                    'options' => ['class' => '']
                ],
            ],
            'summaryOptions' => ['class' => 'h6 m-0'],
            'showPageSummary' => true,
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary'],
            'dataProvider'=> $jobProvider,
//            'filterModel' => $jobSearch,
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
                    'attribute' => 'category',
                    'value' => function($model) {
                        return $model->category->name;
                    },
                    'width' => '210px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => 'Всего:',
                ],
                [
                    'attribute' => 'division',
                    'value' => function($model) {
                        return $model->division->name;
                    },
                    'width' => '140px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'count_opened',
                    'width' => '60px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'begin_date',
                    'format' => ['date', 'd MMMM yyyy'],
                    'width' => '80px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'class' => EditableColumn::class,
                    'attribute' => 'end_date',
                    'format' => ['date', 'd MMMM yyyy'],
                    'width' => '80px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'editableOptions'=> function ($model, $key, $index) {
                        return [
                            'preHeader' => Icon::show('edit') . ' Редактирование ',
                            'header' => 'даты закрытия',
//                            'size' => PopoverX::SIZE_MEDIUM,
                            'placement' => PopoverX::ALIGN_LEFT,
                            'valueIfNull' => Html::tag('em', 'Не закрыто'),
                            'inputType' => Editable::INPUT_WIDGET,
                            'widgetClass' => DatePicker::class,
                            'options' => [
                                'type' => DatePicker::TYPE_INLINE,
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                    'format' => 'dd.mm.yyyy',
                                ],
                                'options' => [
                                    'id' => 'job-date-opened-' . $model->uniqueId,
                                    'autocomplete' => 'off',
                                ],
                            ],
                            'formOptions' => [
                                'action' => ['job/editenddate'],
                            ],
                        ];
                    },
                ],
                [
                    'attribute' => 'count_assigned_interviews',
                    'width' => '110px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_conducted_interviews',
                    'width' => '110px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_trainees',
                    'width' => '110px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_closed',
                    'width' => '80px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'class' => EditableColumn::class,
                    'attribute' => 'commentary',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'editableOptions'=> function ($model, $key, $index) {
                        return [
                            'preHeader' => Icon::show('edit') . ' Редактирование ',
                            'header' => 'комментария',
                            'size' => PopoverX::SIZE_MEDIUM,
                            'placement' => PopoverX::ALIGN_LEFT,
                            'valueIfNull' => Html::tag('em', 'Отсутствует'),
                            'inputType' => Editable::INPUT_TEXTAREA,
                            'options' => [
                                'rows' => 4,
                                'style' => 'resize: none;',
                            ],
                            'formOptions' => [
                                'action' => ['job/editcommentary'],
                            ],
                        ];
                    },
                ],
//                [
//                    'class' => ActionColumn::class,
//                    'template' => '{closed}',
//                    'buttons' => [
//                        'closed' => function($url, $model) {
//                            return Html::a(Icon::show('thumbs-up'), ['job/close', 'id' => $model->id], [
//                                'class' => 'btn btn-success',
//                            ]);
//                        },
//                    ],
//                ]
            ],
        ]);