<?php
/*
Plugin Name: Check Product
Description: Plugin hỗ trợ tạo, kiểm tra mã sản phẩm
Version: 1.2.3
Author: Quốc Đại
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

add_action('admin_enqueue_scripts', 'wp_include_admin_js' );

function wp_include_admin_js()
{
	wp_register_script( 'jquery-3.5.1.js', plugins_url("js/jquery-3.5.1.min.js",__FILE__) , array() );
	wp_enqueue_script( 'jquery-3.5.1.js' );
}

add_action('wp_enqueue_scripts', 'wp_include_pl_check_code', 10, 0 );

function wp_include_pl_check_code(){
	wp_register_script( 'jquery-3.5.1.js', plugins_url("js/jquery-3.5.1.min.js",__FILE__) , array() );
	wp_enqueue_script( 'jquery-3.5.1.js' );
	wp_register_script( 'pl-check-code-custom.js', plugins_url("js/pl-custom.js",__FILE__) , array() );
	wp_enqueue_script( 'pl-check-code-custom.js' );

	wp_register_style( 'pl-check-code-custom.css', plugins_url("css/pl-custom.css",__FILE__) , array() );
	wp_enqueue_style( 'pl-check-code-custom.css' );
}

add_action( 'wp_footer', 'GetCodeData', 100 );

function GetCodeData() { 
?>
<script>
    (function () {

        $ = jQuery.noConflict();

        $(".wpcf7-submit").on('click',function(){
        	$("body").addClass("pl-check-product-loading");
        	var code = $(this).parent().parent().find('input[name ="code"]').val();
            var name = $(this).parent().parent().find('input[name ="hotenkh"]').val();
            var phoneNumber = $(this).parent().parent().find('input[name ="sdtkh"]').val();
            var email = $(this).parent().parent().find('input[name ="emailkh"]').val();
            var diachi = $(this).parent().parent().find('input[name ="diachikh"]').val();

            var codeinput = $(this).parent().parent().find('input[name ="code"]');
        	$(".wpcf7-submit").prop("disabled",true);
		    $(".wpcf7-not-valid-tip").hide();
            if(code != null && code != "" && name != null && name != ""
            	&& phoneNumber != null && phoneNumber != "" && diachi != null && diachi != ""){
	            
	            $.ajax({
	                method : 'POST',
	                url : '<?php echo plugins_url("function.php", __FILE__ )?>', 
	                data : {
	                    Data : code,
	                },
	                success : function( response ) {
	                    console.log( response );
	                    switch(response) 
	                    {
	                    	case "0":
        						$(".wpcf7-submit").submit();
        						break;

	                    	case "1":
	                    		$("body").removeClass("pl-check-product-loading");
		                    	$("#resultCheckCode").show();
			                    if( $("#resultCheckCode").html() == null || $("#resultCheckCode").html() == ""){
			                   		codeinput.parent().parent().append("<span class='wpcf7-not-valid-tip' id='resultCheckCode'>Mã sản phẩm không đúng</span> <input hidden type='text' name='coderesult' value='"+response + "'/>");
			               		}	
			               		else
			               		{
			               			$("#resultCheckCode").html("Mã sản phẩm không đúng");
			               		}
			               		$('a[href^="#checkfail"]').trigger('click');
			                   	// window.location.href = $('a[href^="#checkfail"]').attr('href');
			                   	break;
			                case "2":
		                		
	                    		$("body").removeClass("pl-check-product-loading");
		                    	$("#resultCheckCode").show();
			                    if( $("#resultCheckCode").html() == null || $("#resultCheckCode").html() == ""){
			                   		codeinput.parent().parent().append("<span class='wpcf7-not-valid-tip' id='resultCheckCode'>Sản phẩm đã được xác minh</span> <input hidden type='text' name='coderesult' value='"+response + "'/>");
			               		}	
			               		else
			               		{
			               			$("#resultCheckCode").html("Sản phẩm đã được xác minh");
			               		}
			               		$('a[href^="#checkfail"]').trigger('click');
			                   	// window.location.href = $('a[href^="#checkfail"]').attr('href');
			                   	break;
			                case "3":

	                    		$("body").removeClass("pl-check-product-loading");
		                    	$("#resultCheckCode").show();
			                    if( $("#resultCheckCode").html() == null || $("#resultCheckCode").html() == ""){
			                   		codeinput.parent().parent().append("<span class='wpcf7-not-valid-tip' id='resultCheckCode'>Xảy ra lỗi trong quá trình kiểm tra, vui lòng thử lại</span> <input hidden type='text' name='coderesult' value='"+response + "'/>");
			               		}	
			               		else
			               		{
			               			$("#resultCheckCode").html("Xảy ra lỗi trong quá trình kiểm tra, vui lòng thử lại");
			               		}
			                	break;
	                    }
        				$(".wpcf7-submit").prop("disabled",false);
	                },
	                error: function(xhr){
	                    $("body").removeClass("pl-check-product-loading");
				        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
				    }
	            });
	    	}
	    	else{
	            $("body").removeClass("pl-check-product-loading");
	    		$(".wpcf7-submit").submit();
	    		$(".wpcf7-submit").prop("disabled",false);
	    	}
        });

        document.addEventListener( 'wpcf7mailsent', function( event ) {
	        $("body").removeClass("pl-check-product-loading");
		}, false );


	})();
</script>

<?php

}
