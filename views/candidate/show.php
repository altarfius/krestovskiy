<?php

use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\bs4dropdown\ButtonDropdown;
use kartik\icons\Icon;

$this->title = 'Кандидаты';

$this->params['breadcrumbs'][] =  'Персонал';
$this->params['breadcrumbs'][] =  $this->title;

echo Html::beginTag('div', ['class' => 'row']);

    echo Html::beginTag('div', ['class' => 'col-3']);
        echo Html::beginTag('div', ['class' => 'row']);
//            echo $this->render('modal');
            echo Html::button(Icon::show('plus') . ' Новый кандидат', [
                'class' => 'btn btn-primary mt-2 ml-3',
                'data-toggle' => 'modal',
                'data-target' => '#new-candidate-modal',
            ]);
        echo Html::endTag('div');
    echo Html::endTag('div');

    echo Html::beginTag('div', ['class' => 'col-9']);
        echo Html::beginTag('div', ['class' => 'row float-right']);
            echo Html::a('За вчера', ['candidate/show'], ['class' => 'btn btn-primary mt-2 mr-3 disabled']);
            echo Html::a('За сегодня', ['candidate/show'], ['class' => 'btn btn-primary mt-2 mr-3 disabled']);
            echo Html::a('За неделю', ['candidate/show'], ['class' => 'btn btn-primary mt-2 mr-3 disabled']);
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
            'containerOptions' => [
                'class' => 'mt-2'
            ],
            'dataProvider'=> $candidateProvider,
            'rowOptions' => function($model) {
                return ['class' => $model->styleByStatus];
            },
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
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'gender',
                    'value' => function($candidate) {
                        return $candidate->genderFullText;
                    },
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'age',
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
                    'attribute' => 'division.name',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'status.name',
                    'format' => 'raw',
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
                ],
                [
                    'attribute' => 'interview_date',
                    'format' => ['date', 'dd MMMM'],
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
            ],
        ]);
    echo Html::endTag('div');
echo Html::endTag('div');
