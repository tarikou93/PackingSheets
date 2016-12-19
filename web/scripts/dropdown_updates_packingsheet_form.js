
	var consignedCode = $('#packing_sheet_consignedCode');
	consignedCode.change (function(){
		dropdownUpdate(consignedCode)
	});

	var deliveryCode = $('#packing_sheet_deliveryCode');
	deliveryCode.change (function (){
		dropdownUpdate(deliveryCode)
	});

	var consignedAddress = $('#packing_sheet_consignedAddressId');
	consignedAddress.change (function () {
		dropdownUpdate(consignedAddress)
	});

	var deliveryAddress = $('#packing_sheet_deliveryAddressId');
	deliveryAddress.change (function () {
		dropdownUpdate(deliveryAddress)
	});
	
	function dropdownUpdate(elementId){

		var $form = $(this).closest('form');
		var $data = {};

		$data[elementId.attr('id')] = elementId.val();
		$data['flag'] = elementId.attr('id');
		
		childElement = "";
		
		switch (elementId.attr('id')) {
    	    case "packing_sheet_consignedCode":
    	    	childElement = 'consignedAddressId';
    	        break;
    	    case "packing_sheet_deliveryCode" :
    	    	childElement = 'deliveryAddressId';
    	        break;
    	    case "packing_sheet_consignedAddressId" :
    	    	childElement = 'consignedContactId';
    	        break;
    	    case "packing_sheet_deliveryAddressId" :
    	    	childElement = 'deliveryContactId';
    	        break;
		}
		
		$.ajax ({
			url: $(location).attr('href'),
			type: 'POST',
			data: $data,
			success: function(datas) {
				
    			select = document.getElementById('packing_sheet_'.concat(childElement));
    					 			
    			$('#packing_sheet_'.concat(childElement)).empty();
    			
    			
    			var optEmpty = document.createElement('option');
				optEmpty.value = '';
				optEmpty.innerHTML = '';
				select.appendChild(optEmpty);
  			
    			$.each(datas['packing_sheet_'.concat(childElement)], function(index, element){
    			
    				var opt = document.createElement('option');
                    opt.value = element.id;
                    if(childElement === 'consignedContactId' || childElement === 'deliveryContactId'){
                    	opt.innerHTML = element.name;
                    }
                    else{
                    	opt.innerHTML = element.label;
                    }
                    select.appendChild(opt);
    			});

    			if(datas['packing_sheet_'.concat(childElement)].lenght === 1){
    				dropdownUpdate($('#packing_sheet_'.concat(childElement)));
    				alert('test');
        		}
			}
		});
	};
	