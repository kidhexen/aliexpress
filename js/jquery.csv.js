jQuery(function($) {

    $.fn.CSVAction = function(options){

        var obj = $.extend( {
            btn				: 'button.btn',
            loaderBox       : '.action-loader',
            loaderCurrent   : '.action-loader-current',
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

                if( conf ) {

                    if (topLoaderRunning) {
                        return;
                    }

                    topLoaderRunning = true;

                    $('#download-file').hide();
                    create_file();
                }
            });
        };

        function create_file() {

            $.ajaxQueue({
                url: ajaxurl,
                type: "POST",
                async: true,
                data: { action : 'ae_csv_create' },
                success: function(data) {
                    var obj = _JSON(data);
                    if (obj) {
                        $('#download-file a').attr('href', obj.url);
                        export_products(obj.count, obj.path);
                    }
                }
            });
        }

        function _JSON(data){
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

        function export_products( count, filename ) {

            var len     = 20,
                pos     = Math.ceil(count/len),
                step 	= 1,
                st 		= 0;

            for( var p = 0; p <= pos; p++){
                $.ajaxQueue({
                    url: ajaxurl,
                    type: "POST",
                    async: true,
                    data: {
                        action 		: 'ae_csv_export_products',
                        step		: p,
                        count		: count,
                        len			: len,
                        file        : filename
                    },
                    beforeSend: function() {

                        var c = step*len;

                        th.find(obj.loaderCurrent).text(c.toString());
                        animateCircle(step, 'Products', pos);
                    },
                    success: function(data) {
                        console.log(data);
                        step = step + 1;
                    },
                    complete: function() {
                        st = st + len;
                        if( st > count ){
                            animateCircle(pos, 'Done', pos);
                            th.find(obj.loaderCurrent).text(count.toString());

                            count_reviews(filename);
                        }
                    }
                });
            }
        }

        function count_reviews( filename ) {

            $.ajaxQueue({
                url: ajaxurl,
                type: "POST",
                async: true,
                data: { action : 'ae_csv_count_review' },
                success: function(data) {
                    var count = parseInt(data);
                    if (count > 0) {
                        export_reviews(count, filename);
                    }
                }
            });
        }

        function export_reviews(count, filename ) {

            var len     = 50,
                pos     = Math.ceil(count/len),
                step 	= 1,
                st 		= 0;

            for( var p = 0; p <= pos; p++){
                $.ajaxQueue({
                    url: ajaxurl,
                    type: "POST",
                    async: true,
                    data: {
                        action 		: 'ae_csv_export_review',
                        step		: p,
                        count		: count,
                        len			: len,
                        file        : filename
                    },
                    beforeSend: function() {

                        var c = step*len;

                        th.find(obj.loaderCurrent).text(c.toString());
                        animateCircle(step, 'Review', pos);
                    },
                    success: function() { step = step + 1; },
                    complete: function() {
                        st = st + len;
                        if( st > count ){
                            animateCircle(pos, 'Done', pos);
                            th.find(obj.loaderCurrent).text(count.toString());

                            $('#download-file').show();
                        }
                    }
                });
            }
        }

        return this.each(setTotal);
    };



    $('.ae_csv_action').each(function(){
        $(this).CSVAction();
    });
});

jQuery(function($) {

            var uploader = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,html4',
                browse_button : 'pickfiles', // you can pass an id...
                container: document.getElementById('container'), // ... or DOM Element itself
                url : '../wp-content/plugins/aliplugin/libs/plupload/upload.php',
                flash_swf_url : '../wp-content/plugins/aliplugin/libs/plupload/Moxie.swf',
                silverlight_xap_url : '../wp-content/plugins/aliplugin/libs/plupload/Moxie.xap',
                multi_selection     : true,
                filters : {
                    max_file_size : '10000mb',
                    mime_types: [
                        {title : "File", extensions : "csv"}
                    ]
                },

                init: {
                    PostInit: function() {

                        document.getElementById('filelist').innerHTML = '';

                        document.getElementById('uploadfiles').onclick = function() {
                            uploader.start();
                            return false;
                        };
                    },
//                    QueueChanged: function() {
//
//                        document.getElementById('uploadfiles').click();
//                        },
//

                    FilesAdded: function(up, files) {
                        console.log('323');
                        plupload.each(files, function(file) {
                            document.getElementById('filelist').innerHTML += '<div class="col-md-24" style="margin-top: 10px;" id="' + file.id + '"><div class="col-md-9" style="margin-top: 5px;"> ' + file.name + ' (' + plupload.formatSize(file.size) + ')' +
                            ' </div><div class="progress col-md-15 pull-right" id="total-progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div></div></div>';
                        });
                    },

                    UploadProgress: function(up, file) {
                        //console.log(up, file);
                      //  var progress = document.getElementById(file.id).find('#total-progress .progress-bar')
                        var forid = file.id;
                        console.log(forid);
                       $('#' + forid).find('#total-progress .progress-bar').css({'width': file.percent + '%'}).attr('aria-valuenow', file.percent).text(file.percent + "%");
                        console.log(file.percent);
                      //  document.getElementById(file.id).getElementsByClassName('total-progress')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    },
                    UploadComplete: function() {
                        //console.log(up, file);
                        testing();
                    },

                    Error: function(up, err) {
                        document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
                    }
                }
            });

            uploader.init();
function testing(){
    console.log('файл загружен');
    show_file_list();
}
    function show_file_list(){
        $.ajaxQueue({
            url: ajaxurl,
            type: "POST",
            async: true,
            data: {
                action 		: 'ae_getFileList',
                dir		    : ''

            },

            success: function(data) {
                console.log(data);
            $('.files_result').append(data);
            },
            complete: function() {
      //          $('.second_tmpl_import').show();
            }
        });
    }

});
