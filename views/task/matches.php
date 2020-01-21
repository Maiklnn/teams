<? 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section>
    <div class="content">
        <div class="row">
            <div class="col-2"><a href="<?= \yii\helpers\Url::home()?>">Добавить матч</a> </div>
            <div class="col-8">
            	<? foreach($results as $result) : ?>
            	<p> <?= $result->getTeams($teams, $result->id_one_team, $result->id_two_team); ?> 
            	    <?= $result->gol_one_team ?> - <?= $result->gol_two_team ?></p>
            	<? endforeach; ?>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</section>
