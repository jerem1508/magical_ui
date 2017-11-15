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


function go_to(to) {
	$('html, body').animate( { scrollTop: $("#"+ to).offset().top }, 2000 ); // Go
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