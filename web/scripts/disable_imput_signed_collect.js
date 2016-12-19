$( document ).ready(
    collectImput
);

$( document ).ready(
    applyReadonly
);

$('#packing_sheet_collect').change(collectImput);

$('#packing_sheet_signed').change(collectImput).change(applyReadonly);


function collectImput() {

    var isChecked = document.getElementById("packing_sheet_collect").checked;

    if(isChecked) {
        $("#packing_sheet_imputId").attr("style", 'visibility:hidden'); 
    } else {
        $("#packing_sheet_imputId").removeAttr("style");
    }

};


function applyReadonly() {
	
    var isChecked = document.getElementById("packing_sheet_signed").checked;

    if(isChecked) {
    	disableAll();
    }
    
    else {
        enableAll();
    }	
};


function disableAll(){
				   
    var fields = $('*[id^="packing_sheet_"]');
    
    $.each(fields, function(index, element){
    	
    	//Selects
    	
    	if(('<' + element.tagName.toLowerCase() + '>') === '<select>'){ 		
    		var completeName = "#".concat(element.getAttribute("id"));
        	var completeNameOptions = "#".concat(element.getAttribute("id").concat(" option:not(:selected)"));
        	
        	var elementComplete = eval("completeName");
        	var elementCompleteOptions = eval("completeNameOptions");
        	
        	$(elementCompleteOptions).prop("disabled", true);
        	$(elementComplete).attr("readonly", 'readonly');
    	}
    	
    	//Text Inputs
    	
    	else if(('<' + element.tagName.toLowerCase() + '>') === '<input>'){ 		          
        	var completeName = "#".concat(element.getAttribute("id"));
        	var elementComplete = eval("completeName");
        	$(elementComplete).attr("readonly", 'readonly');    
    	}
    	    	
    })
    
    //CheckBox
    
    $("#packing_sheet_collect").attr("onclick", 'return false;');
};


function enableAll(){
		   
    var fields = $('*[id^="packing_sheet_"]');
    
    $.each(fields, function(index, element){
    	
    	//Selects
    	
    	if(('<' + element.tagName.toLowerCase() + '>') === '<select>'){ 		          
    		var completeName = "#".concat(element.getAttribute("id"));
        	var completeNameOptions = "#".concat(element.getAttribute("id").concat(" option:not(:selected)"));
        	
        	var elementComplete = eval("completeName");
        	var elementCompleteOptions = eval("completeNameOptions");
        	
        	$(elementCompleteOptions).prop("disabled", false);
        	$(elementComplete).removeAttr("readonly");  
    	}
    	
    	//Text Inputs
    	
    	else if(('<' + element.tagName.toLowerCase() + '>') === '<input>'){ 		          
        	var completeName = "#".concat(element.getAttribute("id"));
        	var elementComplete = eval("completeName");
        	$(elementComplete).removeAttr("readonly");    
    	}
    	
    })
    
    //CheckBox
    
    $("#packing_sheet_collect").removeAttr("onclick");
    
    //Unchangeable fields
    
    $("#packing_sheet_ref").attr("readonly", 'readonly');
    $("#packing_sheet_autority").attr("readonly", 'readonly');
    $("#packing_sheet_groupId").attr("readonly", 'readonly');
    $("#packing_sheet_groupId option:not(:selected)").prop("disabled", true);
    
    $("#packing_sheet_weight").attr("readonly", 'readonly');
    $("#packing_sheet_totalPrice").attr("readonly", 'readonly');
    $("#packing_sheet_nbrPieces").attr("readonly", 'readonly');
    
};