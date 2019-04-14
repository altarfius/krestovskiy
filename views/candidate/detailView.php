<?php

use kartik\detail\DetailView;

echo DetailView::widget([
    'model' => $candidate,
//    'condensed' => true,
//    'striped' => true,
//    'bordered' => false,
    'attributes' => [
//        'surname',
//        'name',
//        'patronymic',
        [
            'attribute' => 'nationality',
            'value' => $candidate->nationality->name,
        ],
        'age',
        [
            'attribute' => 'metro',
            'format' => 'raw',
            'value' => $candidate->metro->renderNameWithImg(),
        ],
    ],
]);