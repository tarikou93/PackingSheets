$( document ).ready(
    disableAll
);


function disableAll(){
		   
    var fields = $('*[id^="packing_sheet_"]');
    
    $.each(fields, function(index, element){
    	
    	//Selects
    	
    	if(('<' + element.tagName.toLowerCase() + '>') === '<select>'){ 		          
        	var completeName = "#".concat(element.getAttribute("id").concat(" option:not(:selected)"));
        	var elementComplete = eval("completeName");
        	$(elementComplete).prop("disabled", true);       
    	}
    	
    	//Text Inputs
    	
    	else if(('<' + element.tagName.toLowerCase() + '>') === '<input>'){ 		          
        	var completeName = "#".concat(element.getAttribute("id"));
        	var elementComplete = eval("completeName");
        	$(elementComplete).attr("readonly", 'readonly');    
    	}
    	
    	//Checkboxes
    	
    	else { 		          
        	var completeName = "#".concat(element.getAttribute("id"));
        	var elementComplete = eval("completeName");
        	$(elementComplete).attr("onclick", 'return false;');       
    	}
    })
    
    //Packings
    
    var packingFields = $('*[id^="packing_sheet_packings_"]');
    
    $.each(packingFields, function(index, element){
    	if(('<' + element.tagName.toLowerCase() + '>') === '<select>'){
   		
            if(element.getAttribute("readonly") === "readonly"){
            
            	var completeName = "#".concat(element.getAttribute("id").concat(" option:not(:selected)"));
            	var elementComplete = eval("completeName");
            	$(elementComplete).prop("disabled", true);
            }
    	}
    })
}
