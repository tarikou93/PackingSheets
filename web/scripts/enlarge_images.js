$( document ).ready(
    applyZoom
);

function applyZoom(){
	
	var images = $("img"); // finds all image tags
	console.log(images) 
	
	$.each(images, function(index, element){
		$(element).zoomify();
	})
}
