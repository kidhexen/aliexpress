/**
 * Created by Vitaly Kukin on 14.08.2015.
 */

jQuery(function($) {

    var $topLoader = $("#loader-one").percentageLoader({
        width: 180,
        height: 180,
        controllable : false,
        progress : 0
    });

    var animateFunc = function(p, t, total) {

        var rev = parseInt(p),
            totalRev = parseInt(total);

        $topLoader.setProgress(rev / totalRev);
        $topLoader.setValue('Step ' + t.toString());

        if (p >= total) {
            topLoaderRunning = false;
        }
    };

    var topLoaderRunning = false;
    $("#load").click(function() {

        if (topLoaderRunning){return;}

        topLoaderRunning = true;

        revTotalProduct(1);
    });

    function revTotalProduct(rev) {
        $.ajaxQueue({
            url:  ajaxurl,
            data: {
                action: 'ae_count_products'
            },
            type: "POST",
            success: function(data) {
                $('#current').text(0);
                var star = $('[name="rating"]').val();
                revImport( data, rev, star );
            }
        }).done(function(){});
    }

    function revImport( total, rev, star ) {

        var pos = parseInt(total),
            step 	= 1,
            st 		= 1,
            len 	= 100/pos;

        for( var p = 0; p <= pos; p++){

            $.ajaxQueue({
                url:  ajaxurl,
                data: {
                    action:	'ae_import_review',
                    pos: 	p,
                    page:   rev,
                    star:   star
                },
                type: "POST",
                beforeSend: function(){
                    $('#current').text(step.toString());
                    animateFunc(step, rev, pos);
                },
                success: function(data) {

                    if(data != 'end') {
                        data = aerJSON(data);

                        if (data)
                            revShowProduct(data);
                    }

                    step = step + 1;
                },
                complete: function(){

                    st = st + 1;

                    if( st > pos ){
                        console.log("end");

                        animateFunc(pos, rev, pos);
                        $('#current').text(pos.toString());
                        if(rev < 4){
                            revTotalReview();
                            revTotalProduct(rev + 1);
                        }
                    }
                }
            });
        }
    }

    function revShowProduct(data) {

        if(data['status'] == 'end') return;

        if(data['title'] == '')
            console.log(data['productId']);

        var th = $('#listing'),
            items = th.find('.item');

        if(items.length > 4) {
            items.first().remove();
        }

        var img = '';
        if( data['thumb'] != '' )
            img = '<img src="'+data['thumb']+'" class="img-responsive">';

        var rating = parseFloat(data['rating']).toFixed(2);

        var layout = '<div class="row item width-full height-full">' +
            '<div class="col-sm-3"><div class="thumb">'+img+'</div></div>' +
            '<div class="col-sm-15"><span class="title">'+data['title']+'</span></div>' +
            '<div class="col-sm-3 text-center stat height-full">'+data['count']+'</div>' +
            '<div class="col-sm-3 text-center stat height-full">'+rating.toString()+'</div>' +
            '</div>';

        th.append(layout);
    }

    function revTotalReview(){

        $.ajaxQueue({
            url:  ajaxurl,
            data: {
                action:	'ae_count_review'
            },
            type: "POST",
            success: function(data) {
                $('#review').text(data);
            }
        });
    }

    function aerJSON(data){
        try {
            var response = $.parseJSON(data);
        }
        catch(e) {
			console.log(data);
            console.log(e);
            return false;
        }

        return response;
    }
});