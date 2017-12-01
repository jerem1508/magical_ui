// ready
$(function(){ 
	tab_user_filters = new Array();


});// /ready


function add_user_filter(column, term) {
	// Ajoute un filtre utilisateur

	if(typeof tab_user_filters[column] == 'undefined'){
		tab_user_filters[column] = term;
	}
	else {
		tab_user_filters[column] += "," + term;	
	}


	add_user_filter_html(tab_user_filters);
}// /add_user_filter()


function add_user_filter_html(tab) {
	// Affiche les filtres utilisateur temporaires

	// var html = '<form class="text-left">';
	var html = '';

	for(column in tab){
		html += '<label>' + column + ' :</label>';
		// Décomposition des tags
		tab_tags = tab[column].split(',');
		for(tag in tab_tags){
			html += '&nbsp;<span class="badge">' + tab_tags[tag] + '</span>';
		}
		html += "<br>";
	}

	// html += '<div style="width: 100%;margin-top:20px;" class="text-right">';
	// html += '<button class="btn btn-xs btn-danger" onclick="delete_user_filter();"><i class="fa fa-trash"></i>&nbsp;Effacer</button>';
	// html += '</div>';

	$("#bt_user_filters_delete").css("visibility", "visible");
	
	// Ajout au container
	$("#user_filters").html(html);

	// TODO
	console.log('TODO : lancement recherche filtrer user');

}// /add_user_filter_html()


function delete_user_filter() {
	// Suppression des filtres utilisateur temporaires
	tab_user_filters = [];

	$("#bt_user_filters_delete").css("visibility", "hidden");
	$("#user_filters").html('<i class="fa fa-info-circle"></i> Pour ajouter un filtre temporaire, vous devez cliquer sur un ou plusieurs termes de la source. Cela à pour but de cibler plus précisément les recherches et donc d\'optimiser la proposition faite.');
}// /delete_user_filter()