jQuery(function($) {

    $.fn.LoaderAction = function(options){

        var obj = $.extend( {
            action          : '[name="action"]',
            step_two        : '[name="step_two"]',
            len 			: '[name="len"]',
            btn				: '.btn',
            loaderBox       : '.action-loader',
            loaderCurrent   : '.action-loader-current',
            alertConfirm    : false,
            alertText       : '[name="infoText"]',
            loaderWidth     : 180,
            loaderHeight    : 180
        }, options);

        var th = $(this);

        var $topLoader = th.find(obj.loaderBox).percentageLoader({
            width           : 180,
            height          : 180,
            controllable    : false,
            value           : '',
            progress        : 0
        });

        var animateCircle = function(step, text, total) {

            var rev = parseInt(step),
                totalRev = parseInt(total);

            $topLoader.setProgress(rev / totalRev);
            $topLoader.setValue(text.toString());

            if ( step >= total ) {
                topLoaderRunning = false;
            }
        };

        var topLoaderRunning = false;

        var setTotal = function() {

            th.on('click', obj.btn, function(e) {

                e.preventDefault();

                var conf = true;

                if( obj.alertConfirm ) {

                    var isDelete = confirm( th(obj.alertText).val() );

                    if( !isDelete )
                        conf = false;
                }

                if( conf ) {
                    var action = th.find(obj.action).val(),
                        step_two = th.find(obj.step_two).val(),
                        len = parseInt(th.find(obj.len).val());

                    if (topLoaderRunning) {
                        return;
                    }

                    topLoaderRunning = true;

                    do_count(action, step_two, len);
                }
            });
        };

        function do_count(action, step_two, len) {

            $.ajaxQueue({
                url: ajaxurl,
                type: "POST",
                async: true,
                data: { action : action },
                success: function(data) {
                    var count = parseInt(data);
                    if (count > 0)
                        do_step_two(len, count, step_two);
                }
            });
        }

        function do_step_two( len, count, step_two ) {

            var pos     = Math.ceil(count/len),
                step 	= 1,
                st 		= 0;

            for( var p = 0; p <= pos; p++){
                $.ajaxQueue({
                    url: ajaxurl,
                    type: "POST",
                    async: true,
                    data: {
                        action 		: step_two,
                        step		: p,
                        count		: count,
                        len			: len
                    },
                    beforeSend: function() {

                        var c = step*len;

                        th.find(obj.loaderCurrent).text(c.toString());
                        animateCircle(step, 'Go', pos);
                    },
                    success: function() { step = step + 1;},
                    complete: function() {
                        st = st + len;
                        if( st > count ){
                            animateCircle(pos, 'Done', pos);
                            th.find(obj.loaderCurrent).text(count.toString());
                        }
                    }
                });
            }
        }

        return this.each(setTotal);
    };

    $('.ae_loader_action').LoaderAction();
    $('.ae_loader_action_alert').LoaderAction({alertConfirm:true});
});