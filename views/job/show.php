<?php

use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap4\Progress;
use yii\web\JsExpression;

$this->title = 'Вакансии';

//$this->params['breadcrumbs'][] =  'Персонал';
//$this->params['breadcrumbs'][] =  $this->title;

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-3']);
    echo Html::beginTag('div', ['class' => 'row']);
//        echo $this->render('modal', [
//            'job' => $job,
//        ]);
    echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-9']);
    echo Html::beginTag('div', ['class' => 'row float-right']);

    echo Html::endTag('div');
echo Html::endTag('div');

echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-12']);
        echo GridView::widget([
            'bordered' => false,
            'condensed' => true,
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
//                    'width' => '45px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => 'Всего:',
                ],
                [
                    'attribute' => 'division',
                    'value' => function($model) {
                        return $model->division->name;
                    },
//                    'width' => '45px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'begin_date',
                    'format' => ['date', 'dd MMMM yyyy'],
//                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'end_date',
                    'format' => ['date', 'dd MMMM yyyy'],
//                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'count_opened',
//                    'width' => '150px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_assigned_interviews',
//                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_conducted_interviews',
//                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_trainees',
//                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'attribute' => 'count_closed',
//                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'pageSummary' => true,
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{closed}',
                    'buttons' => [
                        'closed' => function($url, $model) {
                            return Html::a(Icon::show('thumbs-up'), ['job/close', 'id' => $model->id], [
                                'class' => 'btn btn-success',
                            ]);
                        },
                    ],
                ]
            ],
        ]);
    echo Html::endTag('div');
echo Html::endTag('div');