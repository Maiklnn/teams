<?php
namespace app\controllers;
use app\models\Task;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class TaskController extends AppController{

    public function actionIndex(){
        $tasks = Task::find()->limit(6)->all();
        $this->setMeta('Задачник');
        return $this->render('index', compact('tasks'));
    }
        


} 