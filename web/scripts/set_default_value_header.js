$( document ).ready(
    selectDefaultHeader
);

$( document ).ready(
	selectDefaultFooter
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

function selectDefaultHeader(){
	
	var options = document.getElementById('print_options_header').options;
		
	$.each(options, function(index, element){
	    
		if(element.text === "PACKING SHEET AND PRO FORMA INVOICE"){
			element.selected = true;
		}
    })  
}

//Setting default Footer

function selectDefaultFooter(){
	
	var options = document.getElementById('print_options_footer').options;
		
	$.each(options, function(index, element){
	    
		if(element.text === "Sabena Aerospace Engineering N.V. / S.A. Brussels Airport building 31 / Gate A www.sabena-aerospace.com - Sabena Aerospace Engineering N.V. / S.A. - BTW / TVA BE 465 150 137 - HRB / RCB 631 415"){
			element.selected = true;
		}
    })  
}


