$(document).on( 'click' , '.sort_medias' , sort_medias_attributes );
    

    function sort_medias_attributes(){

        $('.sort_medias').click( function() {

            var attribute = $(this).attr('name');
            var order = $(this).attr('order');
            var orderby = ( order == 'asc' ) ? '1' : '-1';
            var search_value = '';
            sort = attribute+':'+orderby;

            if ( $( '#search-filter' ).val() != '' ){

                search_value = $( '#search-filter' ).val();
            }    


            $.ajax({

                url: base_url + "index.php/" + page,
                type: 'POST',
                data: {
                    page_number: 1,
                    sort: sort,
                    search_value: search_value

                }, beforeSend: function () {
                
                    $('#table_content').html('<h1 class="loadingMsg"><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
                },
                success: function (data) {
                    
                    $('#table_content').html('');
                    $('#table_content').html(data);

                    // change attribute order (asc,desc) for current header, pe
                    // if header 'title' was asc, this change to 'desc'

                    var header = $(".sort_medias[name='" + attribute + "']");
                    header.attr( 'order' , getComplementaryOrder( order ) );
                    if(order == 'asc'){

                        header.css( 'background' , 'url(../assets/img/sort_asc.png) no-repeat center right' );
                    }
                    else{

                        header.css( 'background' , 'url(../assets/img/sort_desc.png) no-repeat center right' );
                    }
                }
            } );

        } );
    }

    function getComplementaryOrder( order ){

        var complementaryOrder = (order == 'asc') ? 'desc' : 'asc';
        return complementaryOrder;
    }
