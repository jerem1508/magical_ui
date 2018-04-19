
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<div class="container-fluid">
	<div class="well text-justify">
        <div class="row text-center">
            <ul class="breadcrumb">
            </ul>
		</div>

        <div id="referentials"></div>
	</div><!--/ well-->
</div><!--/ container-fluid-->
<script type="text/javascript">

function get_public_projects()
{
    // Récupere les référentiels publiques via API
    $.ajax({
        type: 'get',
        url: '<?php echo BASE_API_URL;?>' + '/api/public_projects/normalize',
        success: function (referentials) {
            if(referentials.error){
                show_api_error(referentials, "API error - get_public_projects");
            }
            else{
                console.log("success - get_public_projects");
                console.log(referentials);

				var cpt = 0;
                for(referential in referentials){
					if(referentials[referential]['last_written']['file_name'] == ''){
						continue;
					}

                    var html = "";
					cpt ++;

                    var display_name = referentials[referential]["display_name"];
                    var description = referentials[referential]["description"];

                    // MAJ du breadcrumb
                    var html = '<li><a href="#' + display_name.toLowerCase() + '">' + display_name.toUpperCase() + '</a></li>';
                    load_data(".breadcrumb", html, true);

                    // Affiche la première partie des données récupérées
                    show_data_html(referentials, cpt);

                    // Récupération des données additionnelles via JSON lié
                    get_additional_data(cpt, display_name);

                    // // Récupération d'un sample
                    get_sample(cpt, referentials[referential]["project_id"], 20);
                }
            }
        },
        error: function (referentials, status, error){
            show_api_error(referentials, "error - get_public_projects");
        }
    });// /ajax
}// /get_public_projects()


function get_additional_data(id_div, display_name)
{
    console.log("get_additional_data(" + display_name + ")");

    var requestURL = '<?php echo base_url('assets/referentials/');?>' + display_name.toLowerCase() + '.json';

    var request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function() {
		var additional_data = request.response;

		var fields = additional_data['fields'];
	  	var html = '<table class="table table-condensed table-striped" style="margin-top: 20px;">';
		for (var field in fields) {
			html += '		  <tr>';
			html += '		  	<th>';
			html += field;
			html += '			</th>';
			html += '			<td><i>';
			html += fields[field];
			html += '			</i></td>';
			html += '		  </tr>';
		}
		html += '</table>';

		$("#" + id_div + " .fields_description").html(html);



    }
}// /get_additional_data()


function get_sample(id_div, project_id, nb_rows)
{
    //console.log("get_sample(" + project_id + ")");
    var tparams = {
        "module_name": "INIT"
    }
    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/' + project_id,
        data: JSON.stringify(tparams),
        success: function (result) {

            if(result.error){
                show_api_error(result.error, "API error - last_written");
            }
            else{
                tparams = {
                    "data_params": {
                        "module_name": result.module_name,
                        "file_name": result.file_name
                    },
                    "module_params":{
                        "sampler_module_name": "standard",
                        "sample_params": {
                            "num_rows": nb_rows
                        }
                    }
                }
                $.ajax({
                    type: 'post',
                    dataType: "json",
                    contentType: "application/json; charset=utf-8",
                    url: '<?php echo BASE_API_URL;?>/api/sample/normalize/' + project_id,
                    data: JSON.stringify(tparams),
                    success: function (result) {
                        if(result.error){
                            show_api_error(result.error, "API error - sample");
                        }
                        else{
                            // Remplissage de la modale
                            var ch = '<table class="table table-responsive table-condensed table-striped" id="' + id_div + '_sample_table">';

                            ch += "<thead><tr>";
                            $.each(result.sample[0], function( column_name, name) {
                            	ch += '<th>' + column_name + "</th>";
                            });
                            ch += "</tr></thead><tbody>";

                            var cpt = 0;
                            $.each(result.sample, function( i, obj) {
                                ch += "<tr>";

                                $.each(result.sample[cpt], function( j, name) {
                                    ch += "<td>" + name + "</td>";
                                });
                                ch += "</tr>";

                                cpt ++;
                            });
                            ch += "</tbody></table>";

                            load_data("#" + id_div + " .exemple", ch, false);

                            $("#" + id_div + "_sample_table").DataTable({
                                                    "language": {
                                                       "paginate": {
                                                            "first":      "Premier",
                                                            "last":       "Dernier",
                                                            "next":       "Suivant",
                                                            "previous":   "Précédent"
                                                        },
                                                        "search":         "Rechercher:",
                                                        "lengthMenu":     "Voir _MENU_ enregistrements par page"
                                                    },
                                                    "lengthMenu": [5,20,"ALL"],
                                                    "responsive": true
                                                });
                        }
                    },
                    error: function (result, status, error){
                        show_api_error(result.error, "error - sample");
                    }
                });// /ajax
            }
        },
        error: function (result, status, error){
            show_api_error(result.error, "error - last_written");
        }
    });// /ajax
}// /get_sample()


function toggle_sample(id)
{
	$("#" + id + " .exemple").slideToggle();

}// /toggle_sample()


function show_data_html(referentials, cpt)
{
    var display_name = referentials[referential]["display_name"];
    var description = referentials[referential]["description"];

	// test du logo
	let logo_exist = false;
	$.ajax({
		url:'<?php echo base_url('assets/img/');?>' + display_name.toLowerCase() + '.png',
		type:'HEAD',
		async: false,
		error: function()
		{
			logo_exist = false;
		},
		success: function()
		{
			logo_exist = true;
		}
	});

    // Restitution HTML
    var html = "";
	html += '<div id="' + display_name.toLowerCase() + '"></div>';
    html += '<div class="row" id="' + cpt + '">';
    html += '    <div class="col-md-2">';

	if(logo_exist){
		html += '        <img src="<?php echo base_url('assets/img/');?>' + display_name.toLowerCase() + '.png" class="" style="width:200px;">';
	}

	html += '    </div>';
    html += '    <div class="col-md-10">';
    html += '        <h2 class="title">' + display_name + '</h2>';
    html += '        <div class="date_dl"></div>';
    html += '        <div class="date_ul"></div>';
    html += '        <div class="short_description">' + description + '</div>';
    html += '        <div class="fields_description"></div>';
    html += '        <div class="exemple_title text-right">';
	html += '			<button onclick="toggle_sample(' + cpt + ')" class="btn btn-success2">Voir un échantillon <i class="fa fa-eye"></i></button>';
	html += 		'</div>';
    html += '        <div class="exemple" style="overflow-x:scroll;padding-top: 20px;"></div>';
    html += '    </div>';
    html += '</div>';
    html += '<hr>';

    // Chargement des données
    load_data("#referentials", html, true);

	//Repliement de la partie echantillon
	$("#" + cpt + " .exemple").toggle();
}// /show_data_html()


function load_data(target, value, is_incremental) {
    // Chargement des données dans une balise
    if(is_incremental){
        $(target).html($(target).html() + value);
    }
    else {
        $(target).html(value);
    }
}// /load_data()


$(function(){// ready
    // Récupération et affichage des projets publics
    get_public_projects()

});// /ready
</script>
