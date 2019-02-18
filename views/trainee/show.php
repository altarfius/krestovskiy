<?php

use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\bs4dropdown\ButtonDropdown;

$this->title = 'Стажёры';

$this->params['breadcrumbs'][] =  'Персонал';
$this->params['breadcrumbs'][] =  $this->title;

echo Html::beginTag('div', ['class' => 'row']);

    echo Html::beginTag('div', ['class' => 'col-6']);
        echo Html::beginTag('div', ['class' => 'row']);

            if (isset($newTrainee)) {
                echo $this->render('modal', [
                    'trainee' => $newTrainee,
                ]);
            }

        echo Html::endTag('div');
    echo Html::endTag('div');

    echo Html::beginTag('div', ['class' => 'col-6']);
        echo Html::beginTag('div', ['class' => 'row float-right']);
            echo Html::a('За вчера', ['trainee/show'], ['class' => 'btn btn-primary mt-2 mr-3 disabled']);
            echo Html::a('За сегодня', ['trainee/show'], ['class' => 'btn btn-primary mt-2 mr-3 disabled']);
            echo Html::a('За неделю', ['trainee/show'], ['class' => 'btn btn-primary mt-2 mr-3 disabled']);
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
            'containerOptions' => [
                'class' => 'mt-2'
            ],
            'dataProvider'=> $traineeProvider,
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
                    'attribute' => 'surname',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'name',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'patronymic',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'phone',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'category.name',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'status.name',
                    'format' => 'raw',
                    'content' => function($model) use ($statuses) {
                        return ButtonDropdown::widget([
                            'label' => $model->status->name,
                            'buttonOptions' => ['class' => 'btn-success btn-sm'],
                            'dropdown' => [
                                'items' => $model->renderDropdownItems(),
                            ],
                        ]);
                    },
                ]
            ],
        ]);
    echo Html::endTag('div');
echo Html::endTag('div');
