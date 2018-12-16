function search() {
	// Declare variables
	var input, filter, table, tr, td, i, existence, n=8;
	input = document.getElementById("search");
	filter = input.value.toUpperCase();
	if(document.getElementById("table-items") !==null){
		table = document.getElementById("table-items");
	} else {
		table = document.getElementById("table-order");
		n = 7
	}
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 1; i < tr.length; i++) {
		existence = false;
		for (j = 0; j < n; j++) {
			td = tr[i].getElementsByTagName("td")[j];
			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					existence = true;
				}
			}
		}
		if (existence == false) {
			tr[i].style.display = "none";
		}
		else{
			tr[i].style.display = "";
		}
	}
	set_background();
}
$(document).on('change', '#sortBuyer', function() {
	sort_buyer();
});

function sort_buyer() {
	var input, filter, table, tr, td, i, existence;
	select = document.getElementById("sortBuyer");
	filter = select.value.toUpperCase();
	table = document.getElementById("table-order");
	tr = table.getElementsByTagName("tr");

	for (i = 1; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
	set_background();
}