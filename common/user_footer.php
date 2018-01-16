<script src="libraries/jQuery/jQuery-2.1.4.min.js"></script>
<script src="libraries/bootstrap.min.js"></script>
<!-- App -->
<script src="assets/js/app.min.js"></script>
<script src="assets/js/jquery.bootgrid.js"></script>
<script>
	var grid = $("#grid-command-buttons").bootgrid({
		formatters: {
			"commands": function(column, row) {
				return "<button  class=\"btn btn-primary command-view\" data-row-id=\"" + row.id + "\">View</button>";
			},
			"instructions": function(column, row) {
				//console.log(row.id3);
                var instruct = row.id3;
                var id3_splited = instruct.split("_");
//                <h4 class='text-uppercase'>proof to member</h4>
				return "<address>" +
					"<p class='ins'><span>drive:<em>" + id3_splited['1'] + "</em></span> <span>format:<em>" + id3_splited['2'] + "</em></span></p>" +
					"<p class='ins'><span>member:<em>" + id3_splited['0'] + "</em></span> <span>receipt:<em>" + id3_splited['3'] + "</em></span></p>" +
					"<p class='ins'><span>doc:<em>" + id3_splited['4'] + "</em></span> <span>rev:<em>none</em></span> <span>mem<em>" + id3_splited['5'] + "</em></span></p>" +
					"<p class='ins'><span>city/st:<em>" + id3_splited['6'] + ","+ id3_splited['7'] +"</em></span></p>" +
					"<p class='ins'><span>publisher:<em>" + id3_splited['8'] + "</em></span></p>" +
					"<p class='ins'><span>name:<em>" + id3_splited['9'] + "</em></span></p>" +
					//"<p class='ins process-id'><span>process id:<em>5485454</em></span></p>" +
					"</address>";
			}
		}
	}).on("loaded.rs.jquery.bootgrid", function() {
		/* Executes after data is loaded and rendered */
		grid.find(".command-edit").on("click", function(e) {
			alert("You pressed edit on row: " + $(this).data("row-id"));
		}).end().find(".command-delete").on("click", function(e) {
			alert("You pressed delete on row: " + $(this).data("row-id"));
		}).end().find(".command-view").on("click", function(e) {
			//alert("You pressed view on row: " + $(this).data("row-id"));
			window.location = 'carddetails.php?cardId=' + $(this).data("row-id");
		});
	});

</script>
