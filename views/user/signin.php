<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;

Modal::begin([
    'size' => Modal::SIZE_SMALL,
    'title' => 'Войти в систему',
    'options' => [
        'tabindex' => false,
        'id' => 'signin-modal',
    ],
    'clientOptions' => [
        'show' => true,
        'keyboard' => false,
        'focus' => true,
        'backdrop' => 'static',
    ],
    'closeButton' => false,
    'footer' =>
        Html::submitButton(Icon::show('sign-in-alt') . ' Войти', [
            'type' => 'button',
            'form' => 'signin-form',
            'class' => 'btn btn-primary btn-block',
        ]
    ),
]);
    $form = ActiveForm::begin([
        'id' => 'signin-form',
        'type' => ActiveForm::TYPE_VERTICAL,
        'action' => ['user/login'],
    ]);

    echo Form::widget([
        'model' => $user,
        'form' => $form,
        'compactGrid' => true,
        'attributes' => [
            'login' => [
                'type' => Form::INPUT_TEXT,
            ],
            'password' => [
                'type' => Form::INPUT_PASSWORD,
            ],
        ],
    ]);

    ActiveForm::end();

Modal::end();