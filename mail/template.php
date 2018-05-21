<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<?php
$css = <<<'EOT'
    .header {
        background-color: #00b5db;
        border-radius: 10px;
        margin-bottom: 6px;
    }
    img {
        display: block;
        margin: auto;
    }
    .cuerpo {
        border-radius: 10px;
        border: 1px solid black;
        padding: 10px;
    }
EOT;
$this->registerCss($css);
?>
</head>
<body>
    <div class="container">
        <div class="header">
            <?= Html::img('https://raw.githubusercontent.com/rafabernal94/sanlucar/master/web/images/logo.png', [
                'height' => '60px',
            ]) ?>
        </div>
        <div class="cuerpo">
            <?= $cuerpo ?>
        </div>
    </div>
</body>
</html>
