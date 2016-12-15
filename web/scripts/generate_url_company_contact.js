<script>
    var $btn = $('#btnFilter');
    $btn.click (function() {
   	var $selectedId = ($('#codesComplete').val());
   	var url = $(location).attr('href');

   	url = url.replace(/\d+/g,'');

   	if(url.slice(-1) !== "/"){
       	url += "/";
    }
   	window.location.href = url+$selectedId;
	});
</script> 