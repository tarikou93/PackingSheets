/*var $code = $('#packing_sheet_consignedCode');
	$code.change (function() {
	
		var $form = $(this).closest('form');
		var $data = {};
		$data[$code.attr('id')] = $code.val();
		$data['flag'] = "consigned_code";
		//alert($data[$code.attr('id')]);
		$.ajax ({
			url: $(location).attr('href'),
			type: $form.attr('method'),
			data: $data,
			success: function(data) {
				//alert('test');
				select = document.getElementById('packing_sheet_consignedAddressId');
				
				datastring = JSON.stringify(data.consignedAddresses);
				alert(datastring);

				$('#packing_sheet_consignedAddressId').empty();
				$.each(data.consignedAddresses, function(index, element){
					//alert(element.id);
					var opt = document.createElement('option');
                    opt.value = element.id;
                    opt.innerHTML = element.label;
                    select.appendChild(opt);
				});
    			
			}
		});
	});*/

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
		
		$.ajax ({
			url: $(location).attr('href'),
			type: 'POST',
			data: $data,
			success: function(datas) {

				console.log("Received Data");
				console.log(datas);
    			select = document.getElementById('packing_sheet_'.concat(childElement));
    			
    			//datastring = JSON.stringify(data.childElement);
    			//alert(datastring);
    			 			
    			$('#packing_sheet_'.concat(childElement)).empty();
    			
    			console.log("ChildElements");
    			console.log(datas['packing_sheet_'.concat(childElement)]);
  			
    			$.each(datas['packing_sheet_'.concat(childElement)], function(index, element){

    				console.log("element");
    				console.log(element);
        			
    				var opt = document.createElement('option');
                    opt.value = element.id;
                    opt.innerHTML = element.label;
                    select.appendChild(opt);
    			});

    			/*if(datas['packing_sheet_'.concat(childElement)].lenght === 1){
    				dropdownUpdate($('#packing_sheet_'.concat(childElement)));
        		}*/
			}
		});
	};