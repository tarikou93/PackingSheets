
	var consignedCode = $('#packing_sheet_search_consignedCode');
	consignedCode.change (function(){
		dropdownUpdate(consignedCode)
	});

	var consignedAddress = $('#packing_sheet_search_consignedAddressId');
	consignedAddress.change (function () {
		dropdownUpdate(consignedAddress)
	});

	
	function dropdownUpdate(elementId){

		var $form = $(this).closest('form');
		var $data = {};

		$data[elementId.attr('id')] = elementId.val();
		$data['flag'] = elementId.attr('id');
		
		childElement = "";
		
		switch (elementId.attr('id')) {
    	    case "packing_sheet_search_consignedCode":
    	    	childElement = 'consignedAddressId';
    	        break;
    	    case "packing_sheet_search_consignedAddressId" :
    	    	childElement = 'consignedContactId';
    	        break;
		}
		
		$.ajax ({
			url: $(location).attr('href'),
			type: 'POST',
			data: $data,
			success: function(datas) {
				
    			select = document.getElementById('packing_sheet_search_'.concat(childElement));
    					 			
    			$('#packing_sheet_search_'.concat(childElement)).empty();
    			
    			
    			var optEmpty = document.createElement('option');
				optEmpty.value = '';
				optEmpty.innerHTML = '';
				select.appendChild(optEmpty);
  			
    			$.each(datas['packing_sheet_search_'.concat(childElement)], function(index, element){
    			
    				var opt = document.createElement('option');
                    opt.value = element.id;
                    if(childElement === 'consignedContactId'){
                    	opt.innerHTML = element.name;
                    }
                    else{
                    	opt.innerHTML = element.label;
                    }
                    select.appendChild(opt);
    			});

    			if(datas['packing_sheet_search_'.concat(childElement)].lenght === 1){
    				dropdownUpdate($('#packing_sheet_search_'.concat(childElement)));
        		}
			}
		});
	};
	