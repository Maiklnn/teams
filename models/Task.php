<?php
namespace app\models;
use yii\db\ActiveRecord;


class Task extends ActiveRecord{
    public static function tableName(){
        return 'tasks';
    }
   public static function getStatus($status){
        if($status == 1) { $status = 'Выполнена'; } else { $status = 'Невыполнена'; }
        return $status;
    }


} 