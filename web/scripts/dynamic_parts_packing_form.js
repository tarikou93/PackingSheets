var $collectionHolder;

 	// setup an "add a part" link
     var $addPartLink = $('<br/><a href="#" class="add_part_link"><button type="button" class="btn btn-success outline"><span class="glyphicon glyphicon-copy"></span> Add a Part </button></a>');
     var $newLinkLi = $('<li></li>').append($addPartLink);
    
     jQuery(document).ready(function() {

         // Get the ul that holds the collection of parts
         $collectionHolder = $('ul.parts');
        
         // add a delete link to all of the existing part form li elements
         $collectionHolder.find('li').each(function() {
            addPartFormDeleteLink($(this));
         });
    	    
         // Get the ul that holds the collection of parts
         //$collectionHolder = $('ul.parts');
    
         // add the "add a Part" anchor and li to the parts ul
         $collectionHolder.append($newLinkLi);
    
         // count the current form inputs we have (e.g. 2), use that as the new
         // index when inserting a new item (e.g. 2)
         $collectionHolder.data('index', $collectionHolder.find(':input').length);
    
         $addPartLink.on('click', function(e) {
             // prevent the link from creating a "#" on the URL
             e.preventDefault();
    
             // add a new part form (see next code block)
             addPartForm($collectionHolder, $newLinkLi);
         });
     });

     function addPartForm($collectionHolder, $newLinkLi) {
    	    // Get the data-prototype explained earlier
    	    var prototype = $collectionHolder.data('prototype');

    	    // get the new index
    	    var index = $collectionHolder.data('index');

    	    // Replace '__name__' in the prototype's HTML to
    	    // instead be a number based on how many items we have
    	    var newForm = prototype.replace(/__name__/g, index);

    	    // increase the index with one for the next item
    	    $collectionHolder.data('index', index + 1);

    	    // Display the form in the page in an li, before the "Add a Part" link li
    	    var $newFormLi = $('<li></li>').append(newForm);
    	    $newLinkLi.before($newFormLi);

    	 	// add a delete link to the new form
    	    addPartFormDeleteLink($newFormLi);
    	}

	function addPartFormDeleteLink($partFormLi) {
	    var $removeFormA = $('<p><a href="#"><button type="button" class="btn btn-danger outline"><span class="glyphicon glyphicon-paste"></span> Delete this Part </button></a></p>');
	    $partFormLi.append($removeFormA);

	    $removeFormA.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // remove the li for the part form
	        $partFormLi.remove();
	    });
	}