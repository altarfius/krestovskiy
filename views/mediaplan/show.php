<?php

use kartik\grid\ActionColumn;
use kartik\grid\FormulaColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\icons\Icon;

echo GridView::widget([
    'bordered' => false,
//    'condensed' => true,
    'responsive' => false,
//    'rowOptions' => function($model) {
//        return ['class' => $model->styleByCompletion];
//    },
    'panel' => [
        'type' => GridView::TYPE_DEFAULT,
        'heading' => Html::tag('h6', 'Медиа-план', ['class' => 'mb-0']),
//                'before' => false,
        'after' => false,
        'footer' => false,
    ],
    'toolbar' => [
        [
            'content' => $this->render('toolbar'),
//                $this->render('modal', [
//                    'job' => $job,
//                ]),
            'options' => ['class' => 'float-right', 'style' => 'width: 730px;']
        ],
    ],
    'summaryOptions' => ['class' => 'h6 m-0'],
    'showPageSummary' => true,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary'],
    'dataProvider'=> $sourceFactProvider,
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
            'attribute' => 'source',
            'value' => function($model) {
                return $model->source->name;
            },
            'vAlign' => GridView::ALIGN_MIDDLE,
            'pageSummary' => 'Факт:',
        ],
        [
            'attribute' => 'value',
            'format' => 'currency',
            'width' => '150px',
            'vAlign' => GridView::ALIGN_MIDDLE,
            'pageSummary' => true,
        ],
        [
            'attribute' => 'count_calls',
            'width' => '150px',
            'vAlign' => GridView::ALIGN_MIDDLE,
            'pageSummary' => true,
        ],
        [
            'attribute' => 'count_assigned_interviews',
            'width' => '150px',
            'vAlign' => GridView::ALIGN_MIDDLE,
            'pageSummary' => true,
        ],
        [
            'attribute' => 'count_conducted_interviews',
            'width' => '150px',
            'vAlign' => GridView::ALIGN_MIDDLE,
            'pageSummary' => true,
        ],
        [
            'class' => FormulaColumn::class,
            'header' => 'Стоимость соискателя',
            'value' => function ($model, $key, $index, $widget) {
                $p = compact('model', 'key', 'index');
                return  $widget->col(5, $p) != 0 ? $widget->col(3, $p) / $widget->col(5, $p) : 0;
            },
            'width' => '150px',
            'vAlign' => GridView::ALIGN_MIDDLE,
            'pageSummary' => true,
        ],
    ],
]);