<?php
namespace app\models;
use yii\db\ActiveRecord;


class Task extends ActiveRecord{
    public static function tableName(){
        return 'teams';
    }
   public static function getTeams(){
        if($status == 1) { $status = 'Выполнена'; } else { $status = 'Невыполнена'; }
        return $status;
    }
} 