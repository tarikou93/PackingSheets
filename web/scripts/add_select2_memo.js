$(document).ready(function() {
	addSelect2();	
});

function addSelect2(){
	
	var fields = $('*[id^="packing_sheet_usualMemos"]');

	$.each(fields, function(index, element){
		
		//Selects
		
		if(('<' + element.tagName.toLowerCase() + '>') === '<select>'){ 		
			$(element).select2();
		}	    	
	})
}