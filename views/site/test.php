<?php

use kartik\helpers\Html;
use kartik\popover\PopoverX;

echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_RIGHT,
    'content' => 'test',
//    'size' => 'lg',
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Right', 'class'=>'btn btn-default'],
]);