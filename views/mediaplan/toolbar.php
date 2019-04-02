<?php

use kartik\helpers\Html;

//echo Html::beginTag('div', ['style' => 'width: 750px;']);

echo Html::button(\kartik\icons\Icon::show('chevron-left'), ['class' => 'btn btn-primary']);

echo Html::button('Март', ['class' => 'btn btn-link', 'style' => 'margin: 0 42.8%;']);

echo Html::button(\kartik\icons\Icon::show('chevron-right'), ['class' => 'btn btn-primary']);

//echo Html::endTag('div');