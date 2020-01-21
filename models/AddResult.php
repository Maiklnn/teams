<?php
namespace app\models;
use yii\base\Model;
use yii\db\ActiveRecord;


class AddResult extends ActiveRecord {
    public static function tableName(){
        return 'result';
    }
  	public function attributeLabels(){
        return [
            'id_one_team' => 'Выбирите первую команду',
            'id_two_team' => 'Выбирите вторую команду',
            'gol_one_team' => '',
            'gol_two_team' => '',
            
        ];
    }

	public function rules() {
		return [
			[ ['gol_one_team', 'gol_two_team'], 'required', 'message' => 'Поле обязательно для заполнения' ], 
			[ ['gol_one_team', 'gol_two_team'], 'integer', 'message' => 'Поле должно быть целым числом' ],
			[ ['id_one_team', 'id_two_team'], 'safe']
		];
	}
	public static function getTeams($teams, $team_one_id, $team_two_id){
        foreach($teams as $team) {
        	if ($team->id == $team_one_id ) $team_one = $team->team;
        	if ($team->id == $team_two_id ) $team_two = $team->team;
        	 
        }
  		return $team_one.' - '.$team_two;
    }
} 