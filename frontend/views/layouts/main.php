<?php

use yii\bootstrap\Nav;
use yii\bootstrap\Html;
use common\widgets\Alert;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);

        if (Yii::$app->user->isGuest) {
            $menuItems = [
                ['label' => 'Signup', 'url' => ['/site/signup']],
                ['label' => 'Login', 'url' => ['/site/login']],
            ];
        } else {
            $menuItems = [
                ['label' => 'Fitnes Club', 'url' => ['/fitnes-club/index']],
                ['label' => 'Client', 'url' => ['/client/index']],
                ['label' => 'Action logs', 'url' => ['/action-log']],
                ['label' => 'Logout', 'url' => ['/site/logout']],
            ];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">
                &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>
            </p>
            <p class="float-end">
                <?= Yii::powered() ?>
            </p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
