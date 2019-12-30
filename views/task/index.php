<?php
use yii\helpers\Html;
?>
<?php if( !empty($tasks) ): ?>
    <?php foreach($tasks as $task): ?>
        <section>
            <div class="content">
                <div class="row header-main">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <div class = "task">
                            <h1>Задача</h1>
                            <p><?=$task->task?></p>
                        <div>
                        <div class="main-info">
                            <div class="main-info_published">Опубликовал: <strong><?=$task->author?></strong></div>
                            <div class="main-info_email">Email: <strong><?=$task->email?></strong></div>
                            <div class="main-info_status">Статус: <strong><?=$task->getStatus($task->status); ?></strong></div>
                        </div>  
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>
        </section>
    <?php endforeach;?>
<?php endif; ?>

