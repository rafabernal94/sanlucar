<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use kartik\icons\Icon;

AppAsset::register($this);
Icon::map($this);
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
            [
                'label' => Icon::show('registered') . ' Regístrate',
                'url' => ['usuarios/registrar'],
                'encode' => false,
            ],
            [
                'label' => Icon::show('sign-in') . ' Iniciar sesión',
                'url' => ['site/login'],
                'encode' => false,
            ]
        ];
    } else {
        $foto = Yii::$app->user->identity->url_avatar;
        $items = [
            [
                'label' => Icon::show('search') . ' Buscar trayecto',
                'url' => ['trayectos/buscar'],
                'encode' => false,
            ],
            [
                'label' => Icon::show('plus-circle') . ' Publicar trayecto',
                'url' => ['trayectos/publicar'],
                'encode' => false,
            ],
            [
                'label' => Icon::show('comments', ['class' => 'fa-2x']),
                'url' => ['conversaciones/buzon'],
                'linkOptions' => ['class' => 'pt-10 pb-5 hidden-xs', 'title' => 'Mensajes'],
                'encode' => false,
            ],
            [
                'label' => Icon::show('comments') . ' Mensajes',
                'url' => ['conversaciones/buzon'],
                'linkOptions' => ['class' => 'visible-xs'],
                'encode' => false,
            ],
            [
                'label' => Html::img($foto,
                    [
                        'class' => 'img-circle',
                        'style' => 'height: 40px; width: 40px; margin: -14px 0px -14px 0px',
                    ]
                ),
                'encode' => false,
                'items' => [
                    [
                        'label' => Icon::show('user-circle') . ' Mi perfil',
                        'url' => ['usuarios/perfil', 'id' => Yii::$app->user->id],
                        'encode' => false
                    ],
                    [
                        'label' => Icon::show('map-signs') . ' Mis trayectos',
                        'url' => ['trayectos/trayectos-publicados'],
                        'encode' => false,
                    ],
                    [
                        'label' => Icon::show('car') . ' Mis coches',
                        'url' => ['coches/mis-coches'],
                        'encode' => false,
                    ],
                    [
                        'label' => Icon::show('sign-out') . ' Cerrar sesión',
                        'url' => ['site/logout'],
                        'linkOptions' => ['data-method' => 'POST'],
                        'encode' => false,
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
            <span>
                Desarrollado por <a href="https://github.com/rafabernal94" target="_blank">rafabernal94</a>
                <?= Icon::show('github', ['style' => 'font-size: 18px']) ?>
            </span>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
