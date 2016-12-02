 var $collectionHolder;
    
    // setup an "add a packing" link
     var $addPackingLink = $('<br/><a href="#" class="add_packing_link"><button type="button" class="btn btn-success outline"><span class="glyphicon glyphicon-copy"></span> Add a Packing </button></a>');
     var $newLinkLi = $('<li></li>').append($addPackingLink);
    
     jQuery(document).ready(function() {
    
         // Get the ul that holds the collection of packings
         $collectionHolder = $('ul.packings');
        
         // add a delete link to all of the existing packing form li elements
         $collectionHolder.find('li#packing').each(function() {
            addPackingFormDeleteLink($(this));
         });
    	    
         // Get the ul that holds the collection of packings
         //$collectionHolder = $('ul.packings');
    
         // add the "add a Packing" anchor and li to the packings ul
         $collectionHolder.append($newLinkLi);
    
         // count the current form inputs we have (e.g. 2), use that as the new
         // index when inserting a new item (e.g. 2)
         $collectionHolder.data('index', $collectionHolder.find(':input').length);
    
         $addPackingLink.on('click', function(e) {
             // prevent the link from creating a "#" on the URL
             e.preventDefault();
    
             // add a new packing form (see next code block)
             addPackingForm($collectionHolder, $newLinkLi);
         });
     });
    
     function addPackingForm($collectionHolder, $newLinkLi) {
    	    // Get the data-prototype explained earlier
    	    var prototype = $collectionHolder.data('prototype');
    
    	    // get the new index
    	    var index = $collectionHolder.data('index');
    
    	    // Replace '__name__' in the prototype's HTML to
    	    // instead be a number based on how many items we have
    	    var newForm = prototype.replace(/__name__/g, index);
    
    	    // increase the index with one for the next item
    	    $collectionHolder.data('index', index + 1);
    
    	    // Display the form in the page in an li, before the "Add a Packing" link li
    	    var $newFormLi = $('<li></li>').append(newForm);
    	    $newLinkLi.before($newFormLi);
    
    	 	// add a delete link to the new form
    	    addPackingFormDeleteLink($newFormLi);
    	}
    
    function addPackingFormDeleteLink($packingFormLi) {
        var $removeFormA = $('<p><a href="#"><button type="button" class="btn btn-danger outline"><span class="glyphicon glyphicon-paste"></span> Delete this Packing </button></a></p>');
        $packingFormLi.append($removeFormA);
    
        $removeFormA.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();
    
            // remove the li for the packing form
            $packingFormLi.remove();
        });
    }