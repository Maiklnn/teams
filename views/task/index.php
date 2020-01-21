<? 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php if( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif;?>

<?php if( Yii::$app->session->hasFlash('error') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif;?>

<section>
    <div class="content">
        <div class="row header-main">
            <div class="col-2"> <a href="<?= \yii\helpers\Url::to(['/task/matches'])?>">К списку матчей</a></div>
            <div class="col-8">
                <? $form = ActiveForm::begin(['options' => ['id' => 'testForm']]) ?>
                        <?php echo $form->field($form_model, 'id_one_team')->dropDownList(\yii\helpers\ArrayHelper::map(
                            app\models\Task::find()->all(), 'id', 'team')) ?>

                       <?= $form->field($form_model, 'gol_one_team')->textInput(['placeholder'=>'Количество голов 1 команды']) ?>

                        <?php echo $form->field($form_model, 'id_two_team')->dropDownList(\yii\helpers\ArrayHelper::map(
                            app\models\Task::find()->all(), 'id', 'team')) ?>

                       <?= $form->field($form_model, 'gol_two_team')->textInput(['placeholder'=>'Количество голов 2 команды']) ?>
                       <?= Html::submitButton('Добавить', ['class' => 'btn btn-success'])?>
                 <? ActiveForm::end() ?>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</section>
