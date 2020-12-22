<?php
/*
Plugin Name: Check Product
Description: Plugin hỗ trợ tạo, kiểm tra mã sản phẩm
Version: 1.0
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
        var form_data;
        $('body').on('submit', 'form.wpcf7-form', function( e ){
            e.preventDefault();

            form_data = $('input[name ="ProductCode"]').val();
            if(form_data != null && form_data != ""){
	            $.ajax({
	                method : 'POST',
	                url : '<?php echo plugins_url("function.php", __FILE__ )?>', 
	                data : {
	                    Data : form_data,
	                },
	                success : function( response ) {
	                    console.log( response );

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
