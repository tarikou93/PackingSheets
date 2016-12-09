$('#packing_sheet_collect').change( function() {
    var isChecked = this.checked;

    if(isChecked) {
        $("#packing_sheet_imputId").attr("style", 'visibility:hidden'); 
    } else {
        $("#packing_sheet_imputId").removeAttr("style");
    }

});


if($("#packing_sheet_groupId").attr("readonly") === "readonly"){
	$("#packing_sheet_groupId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_autorityId").attr("readonly") === "readonly"){
	$("#packing_sheet_autorityId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_contentId").attr("readonly") === "readonly"){
	$("#packing_sheet_contentId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_priorityId").attr("readonly") === "readonly"){
	$("#packing_sheet_priorityId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_shipperId").attr("readonly") === "readonly"){
	$("#packing_sheet_shipperId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_customStatusId").attr("readonly") === "readonly"){
	$("#packing_sheet_customStatusId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_incTypeId").attr("readonly") === "readonly"){
	$("#packing_sheet_incTypeId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_incLocId").attr("readonly") === "readonly"){
	$("#packing_sheet_incLocId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_currencyId").attr("readonly") === "readonly"){
	$("#packing_sheet_currencyId option:not(:selected)").prop("disabled", true);
}

if($("#packing_sheet_serviceId").attr("readonly") === "readonly"){
	$("#packing_sheet_serviceId option:not(:selected)").prop("disabled", true);
}