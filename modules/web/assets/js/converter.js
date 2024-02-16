$( document ).ready( function () {
    $( 'input[name^="currency-name-"]' ).on( 'input', function () {
        var amount = $( this ).val();
        var type = $( this ).data( 'code' );

        $.ajax( {
            url: '/api/v1/currency/' + type + '/exchange',
            type: 'GET',
            data: {amount: amount},
            success: function ( response ) {
                console.log( response );
                updateInputs( response.items );
            },
            error: function ( error ) {
                console.error( 'Error:', error );
            }
        } );
    } );

    function updateInputs( items ) {
        items.forEach( function ( item ) {
            var inputName = 'currency-name-' + item.code;
            var input = $( 'input[name="' + inputName + '"]' );

            if ( input.length > 0 ) {
                input.val( item.amount );
            }
        } );
    }
} );
