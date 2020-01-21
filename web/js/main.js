	$(".btn").hover(function(e) { 
		team_one = $('#addresult-id_one_team option:selected').attr('value');
		team_two = $('#addresult-id_two_team option:selected').attr('value');
		if (team_one === team_two) 
		{ 
			alert('Нельзя выбирать две одинаковые команды')
			$('#addresult-id_two_team option:selected').remove();
		} 
		e.empty();
	});