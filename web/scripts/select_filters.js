
function getFilteredAddresses() {
    
    if( !$('#code').val() ) {
        $('#address').empty();
        $('#contact').empty();       
    }
    
    var codeVar = $("#code").val();

    //var route = "{{ path('sheets', { 'id': "PLACEHOLDER" }) }}";
    //window.location = route.replace("PLACEHOLDER", codeVar);
    //alert(route);

    $.get("{{ path('sheets_ajax_address') }}", {code: codeVar}, function (data) {

        //var addresses = data.addresses[0].address_label;
        //alert(addresses);

        select = document.getElementById('address');

        var cpt = 0;
        for (address in data.addresses) {
            cpt++;
        }


        $('#address')
                .empty()
                ;

        //alert(cpt);
        var i;
        for (i = 0; i <= (cpt - 1); i++) {
            var opt = document.createElement('option');
            opt.value = data.addresses[i].address_id;
            opt.innerHTML = data.addresses[i].address_label;
            select.appendChild(opt);
        }

        if (cpt === 1) {
            getFilteredContacts();
        }
    });
}
function getFilteredContacts() {
    var addressVar = $("#address").val();

    //var route = "{{ path('sheets', { 'id': "PLACEHOLDER" }) }}";
    //window.location = route.replace("PLACEHOLDER", codeVar);
    //alert(route);

    $.get("{{ path('sheets_ajax_contact') }}", {address: addressVar}, function (data) {

        //var addresses = data.addresses[0].address_label;
        //alert(addresses);

        select = document.getElementById('contact');

        var cpt = 0;
        for (contact in data.contacts) {
            cpt++;
        }

        $('#contact')
                .empty()
                ;

        //alert(cpt);
        var i;
        for (i = 0; i <= (cpt - 1); i++) {
            var opt = document.createElement('option');
            opt.value = data.contacts[i].contact_id;
            opt.innerHTML = data.contacts[i].contact_name;
            select.appendChild(opt);
        }
    });
}


