<?php

use app\models\Status;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\bs4dropdown\ButtonDropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
            'filterModel' => $traineeSearch,
            'rowOptions' => function($model) {
                return ['class' => $model->styleByStatus];
            },
            'columns' => [
                [
                    'class' => SerialColumn::class,
                    'width' => '36px',
                    'header' => '#',
                ],
                [
                    'attribute' => 'fullname',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $this->render('modalEdit', [
                            'trainee' => $model,
                        ]);
                    },
                    'filterType' => GridView::FILTER_TYPEAHEAD,
                    'filterWidgetOptions' => [
                        'options' => [
                            'autocomplete'=> false,
                        ],
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['trainee/find']) . '&q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ],
                            ]
                        ]
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'phone',
                    'width' => '130px',
                    'filter' => Html::input('text', 'qwe'),
                ],
                [
                    'attribute' => 'division',
                    'value' => 'division.name',
                    'width' => '160px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($divisions, 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'category',
                    'value' => 'category.name',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'width' => '320px',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($categories, 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'status',
                    'value' => 'status.name',
                    'format' => 'raw',
                    'width' => '210px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'content' => function($model) use ($statuses) {
                        return ButtonDropdown::widget([
                            'label' => $model->status->name,
                            'buttonOptions' => ['class' => 'btn-success btn-sm ' . ($model->is_employee ? 'disabled' : '')],
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
                    'attribute' => 'trainee_date',
//                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->trainee_date != null ? Yii::$app->formatter->asDate($model->trainee_date, 'dd MMMM') : '';
                    },
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'width' => '170px',
                    'filterType' => GridView::FILTER_DATE,
                    'filter' => ArrayHelper::map($statuses, 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                        ],
                    ],
                ]
            ],
        ]);
    echo Html::endTag('div');
echo Html::endTag('div');
