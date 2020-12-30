<?php
/*
Plugin Name: Check Product
Description: Plugin hỗ trợ tạo, kiểm tra mã sản phẩm
Version: 1.2
Author: ZhangShang
*/

include plugin_dir_path(__FILE__) . 'views/create-code.php';

include plugin_dir_path(__FILE__) . 'views/setting.php';
add_action( 'admin_menu', 'SetupMenu' );

function SetupMenu(){
	add_menu_page(
	 'Code', // Title of the page
	 'Code Product', // Text to show on the menu link
	 'manage_options', // Capability requirement to see the link
	 'create-code-product', // The 'slug' - file to display when clicking the link
	 'PageCreateCode'
	 );

	add_submenu_page(
        'create-code-product',
        'Setting',
        'Setting',
        'manage_options',
        'setting-code-product',
        'PageSetting'
    );


}


add_action('admin_enqueue_scripts', 'wp_include_admin_js');

function wp_include_admin_js()
{
	wp_register_script( 'jquery-3.5.1.js', plugins_url("js/jquery-3.5.1.min.js",__FILE__) , array() );
	wp_enqueue_script( 'jquery-3.5.1.js' );

	wp_register_script( 'bootstrap.min.js', plugins_url("js/bootstrap.min.js",__FILE__) , array() );
	wp_enqueue_script( 'bootstrap.min.js' );

	wp_register_style('bootstrap.min.css', plugins_url("css/bootstrap.min.css",__FILE__) , array() );
	wp_enqueue_style('bootstrap.min.css');
}


add_action( 'wp_footer', 'GetCodeData', 100 );

function GetCodeData() { 
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script>
    (function () {

        $ = jQuery.noConflict();

        $(".wpcf7-submit").on('click',function(){
			waitingDialog.show();
        	var code = $(this).parent().parent().find('input[name ="code"]').val();
            var name = $(this).parent().parent().find('input[name ="hotenkh"]').val();
            var phoneNumber = $(this).parent().parent().find('input[name ="sdtkh"]').val();
            var email = $(this).parent().parent().find('input[name ="emailkh"]').val();
            var diachi = $(this).parent().parent().find('input[name ="diachikh"]').val();

            var codeinput = $(this).parent().parent().find('input[name ="code"]');
        	$(".wpcf7-submit").prop("disabled",true);
            if(code != null && code != "" && name != null && name != ""
            	&& phoneNumber != null && phoneNumber != "" && email != null && email != ""
            	&& diachi != null && diachi != ""){
	            
	            $.ajax({
	                method : 'POST',
	                url : '<?php echo plugins_url("function.php", __FILE__ )?>', 
	                data : {
	                    Data : code,
	                },
	                success : function( response ) {
	                    console.log( response );
	                    if(response == "0")
	                    {
        					$(".wpcf7-submit").submit();
	                    }
	                    else
	                    {
	                		waitingDialog.hide();
	                    	// $("#checkfail").show();
	                    	$(".wpcf7-not-valid-tip").hide();
		                    if( $("#resultCheckCode").html() == null || $("#resultCheckCode").html() == ""){
		                   		codeinput.parent().parent().append("<span class='wpcf7-not-valid-tip' id='resultCheckCode'>Mã sản phẩm không đúng </span> <input hidden type='text' name='coderesult' value='"+response + "'/> <a href='#checkfail'>click</a>");
		               		}	
		               		else
		               		{
		               			$("#resultCheckCode").val(response);
		               		}

		                   	$('#checkfail').trigger('click');
	                    }
        				$(".wpcf7-submit").prop("disabled",false);
	                },
	                error: function(xhr){
	                	waitingDialog.hide();
				        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
				    }
	            });
	    	}
	    	else{
	    		waitingDialog.hide();
	    		$(".wpcf7-submit").submit();
	    		$(".wpcf7-submit").prop("disabled",false);
	    	}
        });

        document.addEventListener( 'wpcf7mailsent', function( event ) {
		  	waitingDialog.hide();
		}, false );


        var waitingDialog = waitingDialog || (function ($) {'use strict';

		// Creating modal dialog's DOM
		var $dialog = $(
			'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
			'<div class="modal-dialog modal-m">' +
			'<div class="modal-content">' +
				'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
				'<div class="modal-body">' +
					'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
				'</div>' +
			'</div></div></div>');

		return {
			/**
			 * Opens our dialog
			 * @param message Custom message
			 * @param options Custom options:
			 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
			 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
			 */
			show: function (message, options) {
				// Assigning defaults
				if (typeof options === 'undefined') {
					options = {};
				}
				if (typeof message === 'undefined') {
					message = 'Đang kiểm tra';
				}
				var settings = $.extend({
					dialogSize: 'm',
					progressType: '',
					onHide: null // This callback runs after the dialog was hidden
				}, options);

				// Configuring dialog
				$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
				$dialog.find('.progress-bar').attr('class', 'progress-bar');
				if (settings.progressType) {
					$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
				}
				$dialog.find('h3').text(message);
				// Adding callbacks
				if (typeof settings.onHide === 'function') {
					$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
						settings.onHide.call($dialog);
					});
				}
				// Opening dialog
				$dialog.modal();
			},
			/**
			 * Closes dialog
			 */
			hide: function () {
				$dialog.modal('hide');
			}
		};

		})(jQuery);
	    })();
</script>

<?php

}
