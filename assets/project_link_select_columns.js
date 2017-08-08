	function get_columns_html(tab_columns, target) {
		// Retourne au format HTML l'ensemble des colonnes passées en paramètre

		var html = "";
		var li = "";

		for (var i = 0; i < tab_columns.length; i++) {
			if(target == 'src'){
				li = '<span class="glyphicon glyphicon-star color_src"></span>';
			}
			else{
				li = '<span class="glyphicon glyphicon-star color_ref"></span>';
			}

			html += '<div class="draggable ' + target + '_column">' + li + " " + tab_columns[i] + '</div>';
		}

		return html;
	}


	function change_target(id_bloc, target) {
		// Change l'apparence de la cible au moment du DRAG

		$(id_bloc).addClass("target_" + target);
	}

	function unchange_target(id_bloc, target) {
		// Change l'apparence de la cible à la fin du DRAG

		$(id_bloc).removeClass("target_" + target);
	}

	function analysis_bloc(id_bloc) {
		// Analyse le contenu d'un bloc et écrit le résultat sous le bloc

		// Compte les éléments pour affichage message
		var cpt_src = 0;
		var cpt_ref = 0;

		// Partie SOURCE
		var tab_src = new Array();
		$("#bloc_src_" + id_bloc + ">div").each(function(index) {
			var libelle = $(this).text();

			// Ajout au tableau si inexistant
			if(tab_src.indexOf('"' + libelle + '"') === -1){
				cpt_src++;
				tab_src.push('"' + libelle + '"');
			}
		}); // /each

		// Partie REFERENTIEL
		var tab_ref = new Array();
		$("#bloc_ref_" + id_bloc + ">div").each(function(index) {
			var libelle = $(this).text();

			// Ajout au tableau si inexistant
			if(tab_ref.indexOf('"' + libelle + '"') === -1){
				cpt_ref++;
				tab_ref.push('"' + libelle + '"');
			}
		}); // /each

		var name = "bloc_" + id_bloc;
		var ch = '{"' + name+ '": {"src": ' + tab_src + ',"ref": ' + tab_ref + '}}';
		$("#bloc_analysis_" + id_bloc).html(ch);


		// Si au moins un élément SRC, suppression du message dans la box
		if(cpt_src > 0){
			$("#txt_src_" + id_bloc).css("display", "none");}
		else{
			$("#txt_src_" + id_bloc).css("display", "inherit");}

		// Si au moins un élément REF, suppression du message dans la box
		if(cpt_ref > 0){
			$("#txt_ref_" + id_bloc).css("display", "none");}
		else{
			$("#txt_ref_" + id_bloc).css("display", "inherit");}
	}


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
	}


	function remove_bloc(id_bloc) {
		// Suppression d'un bloc

		$("#bloc_" + id_bloc).remove();
	}

	function change_lib_bloc(id_bloc) {
		// Modification du libellé d'un bloc via Modale

		// Sauvegarde en global de l'identifiant du bloc
		id_bloc_to_change = id_bloc;

		// Affichage de la modale
		$('#modal_bloc').modal('show');
	}


	function new_bloc(id_bloc) {
		// Ajout d'un nouveau bloc au format HTML

		var html = "";
		html += '<div id="bloc_' + id_bloc + '">';
		html += '<div class="row">';
		html += '<div class="col-xs-11 text-left">';
		html += '<h4>';
		html += '<span id="lib_bloc_' + id_bloc + '">Association ' + id_bloc + '</span> ';
		html += '<a onclick="change_lib_bloc(' + id_bloc + ');"><span class="glyphicon glyphicon-pencil"></span></a>';
		html += '</h4>';
		html += '</div>';
		html += '<div class="col-xs-1 text-right">';
		html += '<a onclick="remove_bloc(' + id_bloc + ');" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>';
		html += '</div>';
		html += '</div>';
		html += '<div class="row">';
		html += '<div class="col-xs-6 text-right">';
		html += '<div id="bloc_src_'+id_bloc+'" class="bloc text-left"><span class="txt_src" id="txt_src_' + id_bloc + '">Veuillez glisser au moins une colonne de votre fichier source</span></div>';
		html += '</div>';
		html += '<div class="col-xs-6 text-left">';
		html += '<div id="bloc_ref_'+id_bloc+'" class="bloc text-left"><span class="txt_ref" id="txt_ref_' + id_bloc + '">Veuillez glisser au moins une colonne du référentiel</span></div>';
		html += '</div>';
		html += '</div>';

		html += '<div class="row">';
		html += '<div class="col-xs-12 text-left" id="bloc_analysis_' + id_bloc + '">';
		html += '</div>';
		html += '</div>';

		html += '</div>';

		// Ajout du nouveau bloc
		$("#blocs").html($("#blocs").html() + html);

		// Ajout du javascript
		add_js_bloc(id_bloc);
	}