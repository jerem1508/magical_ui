function set_sample_html(nb_rows=10, random=false, filter=null, module_name="INIT", div) {
	var obj_rows = null;

	var dataType = "json";
	var contentType = "application/json; charset=utf-8";

	console.log("Sample");
    var tparams = {
        "module_name": module_name
    }

	$.ajax({
		type: 'post',
		dataType: dataType,
		contentType: contentType,
		url: '<?php echo BASE_API_URL;?>' + '/api/last_written/normalize/<?php echo $_SESSION['project_id'];?>',
		data: JSON.stringify(tparams),
		success: function (result) {

			if(result.error){
				console.log("API error");
				console.log(result.error);
			}
			else{
                console.log("success");
                console.dir(result);
				/*
				Object
				file_name:"ref.csv"
				module_name:"INIT"
				project_id:"0899384fa6f44c0afb7d38e0c07f89df"
				project_type:"normalize"
				*/

	            tparams = {
	            	"data_params": {
	                	"module_name": result.module_name,
	                	"file_name": result.file_name
	                },
	                "sampler_module_name": "standard"
	            }
				console.log("appel sample");
				
				$.ajax({
					type: 'post',
					dataType: dataType,
					contentType: contentType,
					url: '<?php echo BASE_API_URL;?>/api/sample/normalize/<?php echo $_SESSION['project_id'];?>',
					data: JSON.stringify(tparams),
					success: function (result) {

						if(result.error){
							console.log("API error");
							console.dir(result.error);
						}
						else{
	                        console.log("success sample");
	                        console.dir(result.sample);

	                        // Remplissage de la modale
	                        var ch = '<table class="table table-responsive table-condensed table-striped">';
	                        ch += "<tr>";
							$.each(columns, function( j, name) {
								  ch += '<th>' + name + "</th>";
								});
	                        ch += "</tr>";
	                        console.dir(columns);
							$.each(result.sample, function( i, obj) {
								ch += "<tr>";
								$.each(columns, function( j, name) {
									ch += "<td>" + obj[name] + "</td>";
								});
								ch += "</tr>";
							});
							ch += "</table>";

							$("#" + div).html(ch);

	                    }
	                },
	                error: function (result, status, error){
	                    console.log("error");
	                    console.log(result);
	                    err = true;
	                }
	            });// /ajax
            }
        },
        error: function (result, status, error){
            console.log("error");
            console.log(result);
            err = true;
        }
    });// /ajax

	return obj_rows;	
}