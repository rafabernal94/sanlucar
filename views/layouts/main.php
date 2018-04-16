<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo.png', [
            'alt' => 'SanluCar',
            'width' => '140px;',
            'style' => 'margin-top: -4px',
        ]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'Regístrate', 'url' => ['usuarios/registrar']],
            ['label' => 'Inicia sesión', 'url' => ['site/login']]
        ];
    } else {
        $foto = Yii::$app->user->identity->url_avatar;
        $items = [
            [
                'label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-send'])
                    . ' Publicar trayecto',
                'url' => ['trayectos/publicar'],
                'encode' => false,
            ],
            [
                'label' => Html::img($foto,
                    [
                        'class' => 'img-thumbnail',
                        'style' => 'height: 40px; width: 40px; margin: -14px 0px -14px 0px',
                    ]
                ),
                'encode' => false,
                'items' => [
                    [
                        'label' => 'Mi perfil',
                        'url' => ['usuarios/perfil', 'id' => Yii::$app->user->id],
                    ],
                    [
                        'label' => 'Mis trayectos',
                        'url' => ['trayectos/trayectos-publicados'],
                    ],
                    [
                        'label' => 'Cerrar sesión',
                        'url' => ['site/logout'],
                        'linkOptions' => ['data-method' => 'POST'],
                    ],
                ],
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right">
            Desarrollado por <a href="https://github.com/rafabernal94" target="_blank">rafabernal94</a>
            <?= Html::img('@web/images/github.png', [
                'alt' => 'github-logo',
                'style' => 'margin-left: 6px'
            ]) ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
