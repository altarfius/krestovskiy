<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\nav\NavX;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
Icon::map($this);

$this->registerMetaTag(['charset' => Yii::$app->charset]);
$this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']);
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerCsrfMetaTags();
$this->registerJs('$(document).keydown(function(event){
    if (event.keyCode == 32 && (event.ctrlKey)) {
        event.preventDefault();
        $("#new-candidate-modal").modal("show");
    }
});', $this::POS_END);

$this->beginPage();

echo '<!DOCTYPE html>';
echo Html::beginTag('html', ['lang' => Yii::$app->language]);

echo Html::beginTag('head');
    echo Html::tag('title', Html::encode($this->title));

    $this->head();
echo Html::endTag('head');


echo Html::beginTag('body');
    $this->beginBody();

    echo Html::beginTag('div', ['class' => 'wrap']);

        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-expand-xl fixed-top navbar-dark bg-primary',
            ],
            'renderInnerContainer' => false,
        ]);
        echo NavX::widget([
            'options' => ['class' => 'navbar-nav mx-auto'],
            'items' => [
                ['label' => 'Персонал', 'items' => [
                    ['label' => 'Кандидаты', 'url' => ['/candidate/show']],
                    ['label' => 'Стажёры', 'url' => ['/trainee/show']],
                    ['label' => 'Сотрудники', 'url' => ['/employee/show'], 'linkOptions' => ['class' => 'disabled']],
                ]],
                ['label' => 'Рестораны', 'url' => ['/site/about'], 'linkOptions' => ['class' => 'disabled']],
                ['label' => 'Планирование', 'url' => ['/site/contact'], 'linkOptions' => ['class' => 'disabled']],
                ['label' => 'Финансы', 'url' => ['/site/about'], 'linkOptions' => ['class' => 'disabled']],
                ['label' => 'Отчётность', 'url' => ['/site/contact'], 'linkOptions' => ['class' => 'disabled']],
            ],
        ]);

        if (Yii::$app->user->isGuest) {
            echo Html::a('Войти', ['user/login'], ['class' => 'text-white']);
        } else {
            echo Html::tag('div', Yii::$app->user->identity->fullname . ' | ' . Html::a('Выйти', ['user/logout'], ['class' => 'text-white']), ['class' => 'text-white']);
        }

        NavBar::end();

        echo Html::beginTag('div', ['class' => 'container-fluid']);
            Alert::widget();

            echo Html::beginTag('div', ['class' => 'row mt-2']);
                echo Html::beginTag('div', ['class' => 'col-12']);

                    echo Breadcrumbs::widget([
                        'homeLink' => false,
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);

                echo Html::endTag('div');
            echo Html::endTag('div');

            echo $this->render('/candidate/modal');

            echo $content;

        echo Html::endTag('div');

    echo Html::endTag('div');
    ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php

