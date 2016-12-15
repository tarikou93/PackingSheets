
var $code = $('#code');
$code.change (function() {
	var $form = $(this).closest('form');
	var $data = {};
	$data[$code.attr('id')] = $code.val();
	//alert($data[$code.attr('id')]);
	$.ajax ({
		url: $(location).attr('href'),
		type: $form.attr('method'),
		data: $data,
		success: function(data) {
			select = document.getElementById('addressId');
			
			datastring = JSON.stringify(data.addresses);
			//alert(datastring);
			
			$('#addressId').empty();
			$.each(data.addresses, function(index, element){
				//alert(element.id);
				var opt = document.createElement('option');
                opt.value = element.id;
                opt.innerHTML = element.label;
                select.appendChild(opt);
			});
			
		}
	});
});
