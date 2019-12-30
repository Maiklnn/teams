<?php
use yii\helpers\Html;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container-fluid">
        <div class = 'row'>
            <br>
            <div class = 'content'>
                <div class = 'col-md-12'>
                    <?php if(!Yii::$app->user->isGuest): ?>
                        <a href="<?= \yii\helpers\Url::to(['/site/logout'])?>"><?= Yii::$app->user->identity['username']?> (Выход)</a><br>
                        <a href="<?= \yii\helpers\Url::to(['/admin/tasks'])?>">Редактировать</a>
                    <?php else: ?>
                        <a href="<?= \yii\helpers\Url::to(['/admin/tasks'])?>">Login</a>          
                    <?php endif;?>
                </div> 
            <div>
            <br>    
        </div>
      <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
