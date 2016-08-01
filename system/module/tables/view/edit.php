<div id="table"></div>
<input type="hidden" name="content" id="your_table">

<script>
var data = function () {
	var data = <?=$result?>;
	if (!data.length){
		data = Handsontable.helper.createEmptySpreadsheetData(10, 6);
	}
	return data
};

var container = document.getElementById('table');

var hot = new Handsontable(container, {
	data: data(),
	minSpareCols: 1,
	minSpareRows: 1,
	colWidths: 150,
	rowHeaders: true,
	colHeaders: true,
	manualRowResize: true,
    manualColumnResize: true,
});

$(document).on('submit', 'form', function(event){
	$('#your_table').val(JSON.stringify(table2array()));
});

function table2array() {
	var array = [], max = 0, newarray = [];

	$('.htCore:eq(0)>tbody>tr').each(function(i) {
		array[i] = [];
		$(this).find('>td').each(function(j) {
			if (j == 0 && $(this).text() == '') {
				return false;
			}
			if ($(this).text() != '') {
				max = Math.max(j, max);
			}
			array[i][j] = $(this).text();
		});    
	});

	$.each(array, function (i, v){
		if (v.length == 0) {
			return false;
		}
		newarray[i] = v.slice(0, max+1);
	})

	return newarray;
}
</script>

<style>
.menu-top #menu {
	z-index: 200;
}
</style>