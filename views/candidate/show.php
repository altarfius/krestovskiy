<?php

use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\helpers\Html;
use kartik\bs4dropdown\ButtonDropdown;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
            'containerOptions' => [
                'class' => 'mt-2'
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
                        ]);
                    },
                    'width' => '203px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_TYPEAHEAD,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
//                                'prefetch' => $baseUrl . '/samples/countries.json',
                            'remote' => [
                                'url' => Url::to(['candidate/find']) . '&q=%QUERY',
                                'wildcard' => '%QUERY'
                            ],
                            ]
                        ]
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'age',
                    'width' => '45px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'phone',
                    'width' => '90px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
                [
                    'attribute' => 'nationality',
                    'value' => function($model) {
                        return $model->nationality->name;
                    },
                    'width' => '105px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($nationalities, 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'category',
                    'value' => function($model) {
                        return $model->category->name;
                    },
                    'width' => '200px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($categories, 'id', 'name', 'categoryType.name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'metro',
                    'format' => 'raw',
                    'width' => '160px',
                    'value' => function($model) {
                        return $model->metro->renderNameWithImg();
                    },
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map($metros, 'id', 'name'),
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
                    'attribute' => 'interview_datetime',
                    'value' => function($model) {
                        $format = 'dd MMMM';
                        if ($model->interview_time != null) {
                            $format .= ' в HH:mm';
                        }
                        return Yii::$app->formatter->asDatetime($model->interview_datetime, $format);
                    },
                    'width' => '100px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
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
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Фильтровать по...'],
                ],
                [
                    'attribute' => 'create_time',
                    'format' => ['date', 'dd MMMM в HH:mm'],
                    'width' => '85px',
                    'vAlign' => GridView::ALIGN_MIDDLE,
                ],
            ],
        ]);
    echo Html::endTag('div');
echo Html::endTag('div');
