
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

		//console.log(elementId);
		//console.log(elementId.attr('id'));

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

		//console.log(childElement);
		//console.log($(location).attr('href')+" "+$form.attr('method'));
		
		//alert(childElement);
		//console.log($data);
		//console.log($(location).attr('href'));
		
		$.ajax ({
			url: $(location).attr('href'),
			type: 'POST',
			data: $data,
			success: function(datas) {
				
				//console.log("Received Data");
				//console.log(datas);
    			select = document.getElementById('packing_sheet_'.concat(childElement));
    			
    			//datastring = JSON.stringify(data.childElement);
    			//alert(datastring);
    			 			
    			$('#packing_sheet_'.concat(childElement)).empty();
    			
    			console.log("ChildElements");
    			console.log(datas);
  			
    			$.each(datas['packing_sheet_'.concat(childElement)], function(index, element){

    				//console.log("element");
    				//console.log(element);
        			
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
        		}
			}
		});
	};
	