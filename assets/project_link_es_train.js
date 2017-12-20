// ready
$(function(){
	tab_user_filters = new Array();
	tab_by_num_assoc = new Array();
});// /ready


function add_user_filter(column_src, term, num_assoc) {
	// Ajoute un filtre utilisateur
	if(typeof tab_user_filters[column_src] == 'undefined'){
		tab_user_filters[column_src] = term;
	}
	else {
		tab_user_filters[column_src] += "," + term;
	}

	if(typeof tab_by_num_assoc[num_assoc] == 'undefined'){
		tab_by_num_assoc[num_assoc] = new Array();
	}
	tab_by_num_assoc[num_assoc].push(term);

	add_user_filter_html(tab_user_filters, num_assoc);
}// /add_user_filter()


function add_user_filter_html(tab, num_assoc) {
	// Affiche les filtres utilisateur temporaires
	var html = '';
	var user_filters = new Object();
	for(column in tab){
		var tab_filters = new Array();
		html += '<label>' + column + ' :</label>';
		// Décomposition des tags
		tab_tags = tab[column].split(',');
		for(tag in tab_tags){
			html += '&nbsp;<span class="badge">' + tab_tags[tag] + '</span>';
			tab_filters.push(tab_tags[tag]);
		}
		html += "<br>";
		user_filters[column] = tab_filters;
	}
	$("#bt_user_filters_delete").css("visibility", "visible");

	// Ajout au container
	$("#user_filters").html(html);

	// MAJ des filtres utilisateur au niveau de l'API
	add_user_filters_api(user_filters, num_assoc);
}// /add_user_filter_html()


function delete_user_filter() {
	// Suppression visuelle
	delete_user_filter_html();

	// Suppression dans l'api
	delete_user_filter_api();
}// /delete_user_filter()


function delete_user_filter_html() {
	// Suppression des filtres utilisateur temporaires
	tab_user_filters = [];
	tab_by_num_assoc = [];

	$("#bt_user_filters_delete").css("visibility", "hidden");
	$("#user_filters").html('<i class="fa fa-info-circle"></i> Pour ajouter un filtre temporaire, vous devez cliquer sur un ou plusieurs termes de la source. Cela à pour but de cibler plus précisément les recherches et donc d\'optimiser la proposition faite.');
}// /delete_user_filter_html()
