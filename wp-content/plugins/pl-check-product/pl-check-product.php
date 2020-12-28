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
}


add_action( 'wp_footer', 'GetCodeData', 100 );

function GetCodeData() { 
?>
<script>
    (function () {

        $ = jQuery.noConflict();
        $('body').on('submit', 'form.wpcf7-form', function( e ){
        //     e.preventDefault();
        //     var code = $(this).find('input[name ="code"]').val();
        //     var name = $(this).find('input[name ="hotenkh"]').val();
        //     var phoneNumber = $(this).find('input[name ="sdtkh"]').val();
        //     var email = $(this).find('input[name ="emailkh"]').val();
        //     var diachi = $(this).find('input[name ="diachikh"]').val();
        //     if(code != null && code != "" && name != null && name != ""
        //     	 && phoneNumber != null && phoneNumber != "" && email != null && email != ""
        //     	 && diachi != null && diachi != ""){
	       //      $.ajax({
	       //          method : 'POST',
	       //          url : '<?php echo plugins_url("function.php", __FILE__ )?>', 
	       //          data : {
	       //              Data : code,
	       //          },
	       //          success : function( response ) {
	       //              console.log( response );
	       //             $('input[name ="code"]').parent().parent().append("<span class='wpcf7-not-valid-tip'>" + response +"</span>")

	       //          },
	       //          error: function(xhr){
				    //     console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
				    // }
	       //      });
        // 	}
        });

        $(".wpcf7-submit").on('click',function(){
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
	                    if($("#resultCheckCode").html() == null ||$("#resultCheckCode").html() == ""){
	                   		codeinput.parent().parent().append("<span class='wpcf7-not-valid-tip' id='resultCheckCode'>" + response +"</span> <input hidden type='text' name='coderesult' value='"+response + "'/>");
	               		}
	               		else
	               		{
	               			$("#resultCheckCode").val(response);
	               		}

	                    if(response == "0")
	                    {
        					$(".wpcf7-submit").submit();
	                    }
	                    else
	                    {
	                    	$("#checkfail").show();
	                    }
	                   // else{
		                  // location.reload(true);
	               	   // }
        				$(".wpcf7-submit").prop("disabled",false);
	                },
	                error: function(xhr){
				        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
				    }
	            });
	    	}
        });
    })();
</script>

<?php

}
