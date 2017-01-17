$( document ).ready(
    selectDefaultValue
);

function selectDefaultValue(){
	
	var options = document.getElementById('print_options_header').options;
		
	$.each(options, function(index, element){
	    
		if(element.text === "PACKING SHEET AND PRO FORMA INVOICE"){
			$("#print_options_header").value = element;
		}
    })  
}