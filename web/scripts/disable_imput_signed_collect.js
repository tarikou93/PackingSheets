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
    	
    	//General Infos
    	
        $("#packing_sheet_imputId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_imputId").attr("readonly") === "readonly"){
        	$("#packing_sheet_imputId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_contentId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_contentId").attr("readonly") === "readonly"){
        	$("#packing_sheet_contentId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_priorityId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_priorityId").attr("readonly") === "readonly"){
        	$("#packing_sheet_priorityId option:not(:selected)").prop("disabled", true);
        }

        $("#packing_sheet_shipperId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_shipperId").attr("readonly") === "readonly"){
        	$("#packing_sheet_shipperId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_customStatusId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_customStatusId").attr("readonly") === "readonly"){
        	$("#packing_sheet_customStatusId option:not(:selected)").prop("disabled", true);
        }

        $("#packing_sheet_incTypeId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_incTypeId").attr("readonly") === "readonly"){
        	$("#packing_sheet_incTypeId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_incLocId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_incLocId").attr("readonly") === "readonly"){
        	$("#packing_sheet_incLocId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_currencyId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_currencyId").attr("readonly") === "readonly"){
        	$("#packing_sheet_currencyId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_serviceId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_serviceId").attr("readonly") === "readonly"){
        	$("#packing_sheet_serviceId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_AWB").attr("readonly", 'readonly');
        
        $("#packing_sheet_dateIssue").attr("readonly", 'readonly');
        
        $("#packing_sheet_collect").attr("onclick", 'return false;');
        
        $("#packing_sheet_yrOrder").attr("readonly", 'readonly');
        
        //Contacts
        
        $("#packing_sheet_consignedCode").attr("readonly", 'readonly');
        
        if($("#packing_sheet_consignedCode").attr("readonly") === "readonly"){
        	$("#packing_sheet_consignedCode option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_deliveryCode").attr("readonly", 'readonly');
        
        if($("#packing_sheet_deliveryCode").attr("readonly") === "readonly"){
        	$("#packing_sheet_deliveryCode option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_consignedAddressId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_consignedAddressId").attr("readonly") === "readonly"){
        	$("#packing_sheet_consignedAddressId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_deliveryAddressId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_deliveryAddressId").attr("readonly") === "readonly"){
        	$("#packing_sheet_deliveryAddressId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_consignedContactId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_consignedContactId").attr("readonly") === "readonly"){
        	$("#packing_sheet_consignedContactId option:not(:selected)").prop("disabled", true);
        }
        
        $("#packing_sheet_deliveryContactId").attr("readonly", 'readonly');
        
        if($("#packing_sheet_deliveryContactId").attr("readonly") === "readonly"){
        	$("#packing_sheet_deliveryContactId option:not(:selected)").prop("disabled", true);
        }
                
    } else {
        
    	//General Infos
    	
        $("#packing_sheet_imputId").removeAttr("readonly");
        $("#packing_sheet_imputId option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_contentId").removeAttr("readonly");
        $("#packing_sheet_contentId option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_priorityId").removeAttr("readonly");
        $("#packing_sheet_priorityId option:not(:selected)").prop("disabled", false);

        $("#packing_sheet_shipperId").removeAttr("readonly");
        $("#packing_sheet_shipperId option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_customStatusId").removeAttr("readonly");
        $("#packing_sheet_customStatusId option:not(:selected)").prop("disabled", false);

        $("#packing_sheet_incTypeId").removeAttr("readonly");
        $("#packing_sheet_incTypeId option:not(:selected)").prop("disabled", false);

        $("#packing_sheet_incLocId").removeAttr("readonly");
        $("#packing_sheet_incLocId option:not(:selected)").prop("disabled", false);

        $("#packing_sheet_currencyId").removeAttr("readonly");
        $("#packing_sheet_currencyId option:not(:selected)").prop("disabled", false);
      
        $("#packing_sheet_serviceId").removeAttr("readonly");
        $("#packing_sheet_serviceId option:not(:selected)").prop("disabled", false);

        $("#packing_sheet_AWB").removeAttr("readonly");
        
        $("#packing_sheet_dateIssue").removeAttr("readonly");
        
        $("#packing_sheet_collect").removeAttr("onclick");
        
        $("#packing_sheet_yrOrder").removeAttr("readonly");
        
        //Contacts
        
        $("#packing_sheet_consignedCode").removeAttr("readonly");
        $("#packing_sheet_consignedCode option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_deliveryCode").removeAttr("readonly");
        $("#packing_sheet_deliveryCode option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_consignedAddressId").removeAttr("readonly");
        $("#packing_sheet_consignedAddressId option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_deliveryAddressId").removeAttr("readonly");
        $("#packing_sheet_deliveryAddressId option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_consignedContactId").removeAttr("readonly");
        $("#packing_sheet_consignedContactId option:not(:selected)").prop("disabled", false);
        
        $("#packing_sheet_deliveryContactId").removeAttr("readonly");
        $("#packing_sheet_deliveryContactId option:not(:selected)").prop("disabled", false);
    }

};