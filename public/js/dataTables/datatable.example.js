$(function() {
	//wait till the page is fully loaded before loading table
	//dataTableSearch() is optional.  It is a jQuery plugin that looks for input fields in the thead to bind to the table searching
	$("#sampleOrderTable").dataTable({
		 processing: true,
        serverSide: true,
        ajax: {
            "url": JS_BASE_URL + "/product/datatable",
            "type": "POST"
        },
        columns: [
        	{ data: "p.title" },
        	{ data: "p.description" },
        	{ data: "p.status" }
        ]
	}).dataTableSearch(500);
});
