function get_columns_html(tab_columns, infer_columns, target) {
	// Retourne au format HTML l'ensemble des colonnes passées en paramètre
	var html = "";
	var li = "";

	var tab_types = [];
	tab_types['undefined'] = new Array();

	for (var i = 0; i < tab_columns.length; i++) {
		var column_type = '';

		if(typeof infer_columns[tab_columns[i]] === 'undefined'
			|| typeof infer_columns[tab_columns[i]] === 'function'){
			tab_types['undefined'].push(tab_columns[i]);
			column_type = 'Inconnu';
		}
		else{
			if(tab_types.indexOf(infer_columns[tab_columns[i]]) == -1){
				tab_types[infer_columns[tab_columns[i]]] = new Array();
			}
			tab_types[infer_columns[tab_columns[i]]].push(tab_columns[i]);
			column_type = infer_columns[tab_columns[i]];
		}

		if(column_type == 'Inconnu' || column_type == ''){
			html += '<div class="box" onclick="add_column(\'' + target + '\',\'' + tab_columns[i] + '\');">';
			html += '<div class="row">';
			html += '	<div class="col-md-1">';
			html += '		<div style="width: 15px;margin:0;padding:0;height:40px;background-color:#ddd;"></div>'
			html += '	</div>';
			html += '	<div class="col-md-9">';
			html += '		<div class="tag ' + target + '_column"><span class="fa fa-arrow-circle-right" aria-hidden="true"></span>&nbsp;' + tab_columns[i] + '</div>';
			html += '	</div>';
			html += '	<div class="col-md-2">';
			html += '		<i class="fa fa-plus-circle add" style="font-size: 40px;"></i>';
			html += '	</div>';
			html += '</div>';
			html += '</div>';
		}
		else {

			try {
				var searched_tab = scale_reverse[column_type]; // ex: scale_geo
				var couleur = scale_color[searched_tab][column_type];
			}
			catch(error) {
			  	var couleur = "#aaa";
			}

			html += '<div class="box" onclick="add_column(\'' + target + '\',\'' + tab_columns[i] + '\');">';
			html += '<div class="row">';
			html += '	<div class="col-md-1">';
			html += '		<div style="width: 15px;margin:0;padding:0;height:40px;background-color:' + couleur + ';"></div>'
			html += '	</div>';
			html += '	<div class="col-md-9">';
			html += '		<div class="tag ' + target + '_column"><span class="fa fa-arrow-circle-right" aria-hidden="true"></span>&nbsp;' + tab_columns[i] + '</div>';
			html += '		<div class="type">Type : ' + column_type + '</div>';
			html += '	</div>';
			html += '	<div class="col-md-2">';
			html += '		<i class="fa fa-plus-circle add" style="font-size: 40px;""></i>';
			html += '	</div>';
			html += '</div>';
			html += '</div>';
		}
	}
	return html;
}// /get_columns_html()


function change_target(id_bloc, target) {
	// Change l'apparence de la cible au moment du DRAG

	$(id_bloc).addClass("target_" + target);
}// /change_target()


function unchange_target(id_bloc, target) {
	// Change l'apparence de la cible à la fin du DRAG

	$(id_bloc).removeClass("target_" + target);
}// /unchange_target()


function analysis_bloc(id_bloc) {
	// Analyse le contenu d'un bloc et écrit le résultat sous le bloc

	var source = $("#input_src_" + id_bloc).val();
	var tab_source = source.split(',');
	source = JSON.stringify(tab_source);

	var referentiel = $("#input_ref_" + id_bloc).val();
	var tab_referentiel = referentiel.split(',');
	referentiel = JSON.stringify(tab_referentiel);

	var exact_only = $('#chk_' + id_bloc).is(':checked');

	// Chain jSon
	var ch = '{"source":' + source + ',"ref":' + referentiel + ',"exact_only":' + exact_only + '}';

	$("#bloc_analysis_" + id_bloc).html(ch);

}// /analysis_bloc()


function add_js_bloc(id_bloc) {
	// Ajout du code JS de DRAG&DROp du nouveau bloc

	// SOURCE -------------------------
	$(".src_column").draggable({
		appendTo: '#bloc_src_' + id_bloc,
	    containment: "window",
		cursor: 'move',
		helper: 'clone',
	    start: function(){
	    	// Changement apparence cible
	    	change_target('#bloc_src_' + id_bloc, "src");
	    },
	    stop: function(){
	    	// Changement apparence cible
	    	unchange_target('#bloc_src_' + id_bloc, "src");

	    	// Analyse contenu
	    	analysis_bloc(id_bloc);
	    }
	});

	$("#bloc_src_" + id_bloc).droppable({
	    accept: ".src_column",
		drop: function (event, ui) {
			ui.helper.clone().appendTo('#bloc_src_' + id_bloc);
	    }
	});

	// REFERENTIEL -------------------------
	$(".ref_column").draggable({
		//grid: [ 20, 20 ],
		appendTo: '#bloc_ref_' + id_bloc,
	    containment: "window",
		cursor: 'move',
		//revertDuration: 100,
		//revert: 'invalid',
		helper: 'clone',
	    start: function(){
	    	// Changement apparence cible
	    	change_target('#bloc_ref_' + id_bloc, "ref");
	    },
	    stop: function(){
	    	// Changement apparence cible
	    	unchange_target('#bloc_ref_' + id_bloc, "ref");

	    	// Analyse contenu
	    	analysis_bloc(id_bloc);
	    }
	});

	$("#bloc_ref_" + id_bloc).droppable({
	    accept: ".ref_column",
		drop: function (event, ui) {
			ui.helper.clone().appendTo('#bloc_ref_' + id_bloc);
	    }
	});
}// /add_js_bloc()


function remove_bloc(id_bloc) {
	// Suppression d'un bloc
	$("#bloc_" + id_bloc).remove();
}// /remove_bloc()


function change_lib_bloc(id_bloc) {
	// Modification du libellé d'un bloc via Modale

	// Sauvegarde en global de l'identifiant du bloc
	id_bloc_to_change = id_bloc;

	// Affichage de la modale
	$('#modal_bloc').modal('show');
}// /change_lib_bloc()


function new_bloc(id_bloc) {
	// Ajout d'un nouveau bloc au format HTML

	var html = "";

	html += '<div id="bloc_' + id_bloc + '" class="association association-select" onclick="set_current_association(' + id_bloc + ');">';

	html += '<div class="row">';
	html += '<div class="col-xs-11 text-left">';
	html += '<h4>';
	html += '<span id="lib_bloc_' + id_bloc + '" class="badge">Association ' + id_bloc + '</span> ';
	html += '<a onclick="change_lib_bloc(' + id_bloc + ');"><span class="glyphicon glyphicon-pencil"></span></a>';
	html += '</h4>';
	html += '</div>';
	html += '<div class="col-xs-1 text-right">';
	html += '<a onclick="remove_bloc(' + id_bloc + ');" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>';
	html += '</div>';
	html += '</div>';

	html += '<div class="row" style="padding-bottom:5px;">';
	html += '	<div class="col-xs-2 text-left"><i class="fa fa-table" aria-hidden="true"></i>&nbsp;Source :</div>';
	html += '	<div class="col-xs-9 text-left">';
	html += '		<div id="tags_src_' + id_bloc + '" class="tags"></div>';
	html += '		<input type="hidden" class="input_src" id="input_src_' + id_bloc + '">';
	html += '	</div>';
	html += '	<div class="col-xs-1 text-left" style="padding-left: 0px;"">';
	html += '		<button class="btn btn-default" onclick="reset_line(\'src\',' + id_bloc + ');"><i class="fa fa-trash"></i></button>'
	html += '	</div>';
	html += '</div>';
	html += '<div class="row" style="padding-bottom:5px;">';
	html += '	<div class="col-xs-2 text-left"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;Référentiel :</div>';
	html += '	<div class="col-xs-9 text-left">';
	html += '		<div id="tags_ref_' + id_bloc + '" class="tags"></div>';
	html += '		<input type="hidden" class="input_ref" id="input_ref_' + id_bloc + '">';
	html += '	</div>';
	html += '	<div class="col-xs-1 text-left" style="padding-left: 0px;"">';
	html += '		<button class="btn btn-default" onclick="reset_line(\'ref\',' + id_bloc + ');"><i class="fa fa-trash"></i></button>'
	html += '	</div>';
	html += '</div>';

	html += '<div class="row" style="padding-bottom:5px;">';
		html += '<div class="col-xs-6 text-left">';
			html += '<div class="checkbox" style="margin-top:0;">';
			html += '	<label>';
			html += '		<input type="checkbox" id="chk_' + id_bloc + '" onchange="analysis_bloc(' + id_bloc + ');"> Association parfaite';
			html += '	</label>';
			html += '</div>';
		html += '</div>';
		html += '<div class="col-xs-6 text-right" style="padding-right:30px;">';
			html += '<a style="cursor:pointer;" id="bt_toggle_json_bloc_' + id_bloc + '" onclick="toggle_json(' + id_bloc + ');">{JSON}</a>';
		html += '</div>';
	html += '</div>';

	html += '<div class="row text-left">';
	html += '	<div class="col-xs-12 text-left blocs_analysis" id="bloc_analysis_' + id_bloc + '" style="display:none;"></div>';
	html += '</div>';

	html += '</div>';

	// Ajout du nouveau bloc
	$("#blocs").html($("#blocs").html() + html);

	// Définit le bloc association en cours
	set_current_association(id_bloc);
}// /new_bloc()


function toggle_json(id_bloc) {
	// Affiche ou cache la chaine json dans chaque bloc
	$("#bloc_analysis_" + id_bloc).slideToggle();
}// /toggle_json()


function set_current_association(id_bloc) {
	// Id de l'association sélectionnée
	console.log('select id : ' + id_bloc);
	id_bloc_to_change = id_bloc;

	// Reset de la class css pour toutes les associations
	reset_css_association();

	// Ajout de la class css de selection sur l'association en cours
	$("#bloc_" + id_bloc).addClass("association-select");
	$("#lib_bloc_" + id_bloc).css("background-color", "#25358C");
}// /set_current_association()


function reset_css_association() {
	for (var i = 0; i < cpt_bloc+1; i++) {
		$("#bloc_" + i).removeClass("association-select");
		$("#lib_bloc_" + i).css("background-color", "#777");
	}
}// /reset_css_association()


function add_column(sub_target, column_name) {
	// EX sub_target : src/ref
	// Id de l'association sélectionnée
	// id_bloc_to_change

	// Ajout du tagsInput
	if($("#input_" + sub_target + "_" + id_bloc_to_change).val() == ''){
		$("#input_" + sub_target + "_" + id_bloc_to_change).val(column_name);
	}
	else{
		$("#input_" + sub_target + "_" + id_bloc_to_change).val($("#input_" + sub_target + "_" + id_bloc_to_change).val() + "," + column_name);
	}

	var html_tag = '<span class="badge my_badge">' + column_name + '<a class="cross" onclick="delete_tag(this,\''+sub_target+'\', \''+id_bloc_to_change+'\');">x</a></span>';
	$("#tags_" + sub_target + "_" + id_bloc_to_change).html($("#tags_" + sub_target + "_" + id_bloc_to_change).html() + html_tag);

	// Gère le json qui sera envoyé
	analysis_bloc(id_bloc_to_change);

}// /add_column()


function reset_line(sub_target, id_bloc) {
	$("#tags_"+ sub_target +"_" + id_bloc).html("");
	$("#input_"+ sub_target +"_" + id_bloc).val("");

	analysis_bloc(id_bloc);
}// /reset_line()


function delete_tag(tag, sub_target, id_bloc) {
	// Suppression du tag
	var column_to_delete = tag.parentNode.innerHTML.substring(0, tag.parentNode.innerHTML.indexOf("<a"));

	tag.parentNode.remove()

	// Récupération de toutes les colonnes déjà ajoutées
	var added_columns = $("#input_" + sub_target + "_" + id_bloc).val();
	var tab_columns = added_columns.split(',');
	var tab_temp = new Array();

	// parcours de toutes les colonnes pour les réajouter en excluant celle à supprimer
	for (var i = 0; i < tab_columns.length; i++) {
		if(tab_columns[i] != column_to_delete){
			tab_temp.push(tab_columns[i]);
		}
	}

	// MAJ du champ caché
	$("#input_" + sub_target + "_" + id_bloc).val(tab_temp.join(','));

	// Actualisation du json
	analysis_bloc(id_bloc);
}// /delete_tag()
