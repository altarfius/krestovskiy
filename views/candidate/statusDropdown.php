<?php

use kartik\bs4dropdown\ButtonDropdown;;

echo ButtonDropdown::widget([
    'label' => $model->status->name,
    'buttonOptions' => ['class' => 'btn-success btn-sm'],
    'dropdown' => [
        'items' => $model->renderDropdownItems(),
    ],
]);