<?php
namespace app\controllers;
use app\models\Task;
use app\models\AddResult;
use Yii;
class TaskController extends AppController{
    public function actionIndex(){
        $form_model = new AddResult();
        if( $form_model->load(Yii::$app->request->post()) ){
            if( $form_model->save() ){
                Yii::$app->session->setFlash('success', 'Данные приняты');
                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }
        $this->setMeta('Выбор команды');
        return $this->render('index', compact('tasks', 'form_model'));
    }
    public function actionMatches(){
    	$model = new AddResult();
    	$results = $model::find()->all();
    	$model_teams = new Task();
    	$teams = $model_teams::find()->all();
		$this->setMeta('Список матчей');
     	return $this->render('matches', compact('results','teams'));
    }

} 