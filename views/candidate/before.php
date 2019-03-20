<?php

use kartik\helpers\Html;
use kartik\icons\Icon;

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