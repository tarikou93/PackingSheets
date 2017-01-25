$( document ).ready(
    selectDefaultValue
);

//Archive Status Confirmation

$("#print_options_archive").change(function() {
    if(this.checked) {
    	var box= confirm("Are you sure you want to archive this Packing Sheet ?");
        if (box==true)
        	document.getElementById('print_options_archive').checked = true;
        else
        	document.getElementById('print_options_archive').checked = false;
    }
});

// Setting default Header

function selectDefaultValue(){
	
	var options = document.getElementById('print_options_header').options;
		
	$.each(options, function(index, element){
	    
		if(element.text === "PACKING SHEET AND PRO FORMA INVOICE"){
			element.selected = true;
		}
    })  
}