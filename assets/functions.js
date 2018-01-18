function write_report_html(modified_columns, cible, auto_scroll)
{
	var html = '<div><table class="table table-responsive table-condensed table-striped">';
	console.log(modified_columns);

	for(element in modified_columns){
		html += '<tr>';
		html += '<td>' + element + '</td>';
		html += '<td>' + modified_columns[element] + '</td>';
		html += '</tr>';
	}
	html += '</table></div>';

	$("#" + cible).html($("#" + cible).html() + html);

	// Gestion du scroll
	go_to(cible);
}// /write_report_html()


function precision_Round(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}// /precision_Round()


function go_to(to) {
	$('html, body').animate( { scrollTop: $("#"+ to).offset().top }, 2000 ); // Go
}// /go_to()


function go_to_speed(to, speed) {
	$('html, body').animate( { scrollTop: $("#"+ to).offset().top }, speed ); // Go
}// /go_to()


function set_height(div, size=0) {
	if(size != 0){
		$("#" + div).css('min-height',size);
	}
	else{
		var height = $(window).height();// 955
		var y_div = $("#" + div).position().top; // 215
		var h_footer = $("footer").height(); // 180

		var h_div = height - y_div - h_footer;

		$("#" + div).css('min-height',h_div);

		return h_div;
	}
}


function show_api_error(error, error_txt) {
	console.log(error_txt);
	console.log(error);

	var status = 'error.status';
	switch (error.status) {
		case 400:
			status = '400 : La syntaxe de la requête est erronée.';
			break;
		case 403:
			status = '403 : Le serveur a compris la requête, mais refuse de l\'exécuter.';
			break;
		case 404:
			status = '404 : Ressource non trouvée.';
			break;
		case 500:
			status = '500 : Erreur interne du serveur.';
			break;
	}

	$("#api_error_title").html(error_txt);
	$("#api_error").html(status + "<br>" + JSON.stringify(error));

	$("#modal_error_api").modal("show");
}// /show_api_error()


scale_other = {"Anglais" : "#b3e6b3","Article" : "#9fdf9f","Contenu d'article" : "#8cd98c","Corps et Grades" : "#79d279","Domaine de Recherche" : "#66cc66","Education Nationale" : "#53c653","Entité agro" : "#40bf40","Entité biomédicale" : "#39ac39","Entité Géo" : "#339933","Entité MESR" : "#2d862d","Français" : "#267326","Institution" : "#206020","Mention APB" : "#194d19","NIF" : "#133913","Nom d'essai clinique" : "#b3ffcc","Nom" : "#99ffbb","Phyto" : "#80ffaa","Publication" : "#66ff99","Résumé" : "#4dff88","Spécialité médicale" : "#33ff77","Texte" : "#1aff66","Titre de revue" : "#00ff55","TVA" : "#00e64d","Type structuré" : "#00cc44"};

scale_date = {"Année" : "#ff80bf","Date" : "#ffb3d9"};

scale_geo = {"Adresse" : "#ccebff","Code Postal" : "#b3e0ff","Code" : "#99d6ff","Commune" : "#80ccff","Département" : "#66c2ff","Pays" : "#4db8ff","Postal" : "#33adff","Région" : "#1aa3ff","Voie" : "#0099ff"};

scale_id =  {"DOI" : "#ffffcc","Email" : "#ffffb3","ID organisation" : "#ffff99","ID personne" : "#ffff80","ID publication" : "#ffff4d","ID" : "#ffff1a","ISSN" : "#ffff00","NIR" : "#e6e600","Numéro National de Structure" : "#cccc00","Numéro UMR" : "#b3b300","SIREN" : "#999900","SIRET" : "#808000","Téléphone" : "#666600","UAI" : "#ffff66","URL" : "#ffff33"};

scale_institution = {"Académie": "#ffcccc","Nom d'organisation": "#ffcccc","Collaborateur d'essai clinique": "#ffb3b3","Entreprise": "#ff9999","Etablissement d'Enseignement Supérieur": "#ff8080","Etablissement des premier et second degrés": "#ff6666","Etablissement": "#ff4d4d","Institution de recherche": "#ff3333","Partenaire de recherche": "#ff1a1a","Structure de recherche": "#ff0000"};

scale_person = {"Nom de personne" : "#e6ccff","Prénom" : "#cc99ff","Titre" : "#b366ff","Titre de personne" : "#b366ff"};

scale_color = {
	scale_other,
	scale_date,
	scale_geo,
	scale_id,
	scale_institution,
	scale_person};

scale_reverse ={"Anglais" : "scale_other",
				"Article" : "scale_other",
				"Contenu d'article" : "scale_other",
				"Corps et Grades" : "scale_other",
				"Domaine de Recherche" : "scale_other",
				"Education Nationale" : "scale_other",
				"Entité agro" : "scale_other",
				"Entité biomédicale" : "scale_other",
				"Entité Géo" : "scale_other",
				"Entité MESR" : "scale_other",
				"Français" : "scale_other",
				"Institution" : "scale_other",
				"Mention APB" : "scale_other",
				"NIF" : "scale_other",
				"Nom d'essai clinique" : "scale_other",
				"Nom" : "scale_other",
				"Phyto" : "scale_other",
				"Publication" : "scale_other",
				"Résumé" : "scale_other",
				"Spécialité médicale" : "scale_other",
				"Texte" : "scale_other",
				"Titre de revue" : "scale_other",
				"TVA" : "scale_other",
				"Type structuré" : "scale_other",
				"Année" : "scale_date",
				"Date" : "scale_date",
				"Adresse" : "scale_geo",
				"Code Postal" : "scale_geo",
				"Code" : "scale_geo",
				"Commune" : "scale_geo",
				"Département" : "scale_geo",
				"Pays" : "scale_geo",
				"Postal" : "scale_geo",
				"Région" : "scale_geo",
				"Voie" : "scale_geo",
				"DOI" : "scale_id",
				"Email" : "scale_id",
				"ID organisation" : "scale_id",
				"ID personne" : "scale_id",
				"ID publication" : "scale_id",
				"ID" : "scale_id",
				"ISSN" : "scale_id",
				"NIR" : "scale_id",
				"Numéro National de Structure" : "scale_id",
				"Numéro UMR" : "scale_id",
				"SIREN" : "scale_id",
				"SIRET" : "scale_id",
				"Téléphone" : "scale_id",
				"UAI" : "scale_id",
				"URL" : "scale_id",
				"Académie" : "scale_institution",
				"Nom d'organisation" : "scale_institution",
				"Collaborateur d'essai clinique" : "scale_institution",
				"Entreprise" : "scale_institution",
				"Etablissement d'Enseignement Supérieur" : "scale_institution",
				"Etablissement des premier et second degrés" : "scale_institution",
				"Etablissement" : "scale_institution",
				"Institution de recherche" : "scale_institution",
				"Partenaire de recherche" : "scale_institution",
				"Structure de recherche" : "scale_institution",
				"Nom de personne" : "scale_person",
				"Prénom" : "scale_person",
				"Titre de personne" : "scale_person",
				"Titre" : "scale_person"};
