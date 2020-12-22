<?php
function PageCreateCode(){
	?>
	<div class="wrap validate">
		<h1>Create Code Product</h1>
		<br/>
		<!-- <button id="create">CreateTable</button> -->
		<table >
			<tr style="margin-bottom: 10px">
				<th>
					<label>Enter number code:</label>
				</th>
				<td>
					<input type="text" id="ProductID" style="margin-right: 10px"/>
					<button id="genCode" class="button button-primary" style="margin-right: 10px">Create Code</button>
				</td>
				<td>
					<form action="<?php echo plugins_url("../export-data.php", __FILE__ )."" ?>" method="post">
						<input class="button button-primary" type="submit" name="export" value="Export" />
					</form>
				</td>
			</tr>
			<!-- <tr>
				<th></th>
				<td>
					<label id ="ProductCode"></label>
				</td>
			</tr> -->
		</table>
		<!-- show data to table -->
		<form id="events-filter" method="get">
    		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php
			include plugin_dir_path(__FILE__) . 'product-list-page.php';
		    echo '<div class="wrap"><h2>Danh sách dữ liệu đã tạo</h2>'; 
		    $table = new TableCodeProduct();
		    echo '</div>'; 
		    ?>
	    </form>
	</div>

	<script type="text/javascript">
		// $("#create").click(function(){
		// 	CreateTable();
		// })
		$(document).ready(function (){
			CreateTable();
			$("#ProductID").val(localStorage["inputProductID"]);
		});

		function CreateTable(){
			$.ajax({
				type: "GET",
		        url: "<?php echo plugins_url("../function.php", __FILE__ )."?CreateTable"  ?>",
		        success: function (output) {
		           console.log(output);
		        },
		        error: function(xhr){
			        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			    }
			});
		};

		$("#genCode").click(function(){
			var productID = $("#ProductID").val();
			$.ajax({
				type: "POST",
		        url: "<?php echo plugins_url("../function.php", __FILE__ ).""  ?>",
		        data:{Range:productID},
		        success: function (output) {
		           //$("#ProductCode").html("Product Code: "+output);
		           localStorage["inputProductID"] = productID;
		           window.location.reload();
		        },
		        error: function(xhr){
		        	$("#ProductCode").html("Error: "+xhr.responseText);
			        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			    }
			});
		});
	</script>
	<?php
}



