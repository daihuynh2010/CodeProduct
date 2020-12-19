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
					<label> Enter Product ID:</label>
				</th>
				<td>
					<input type="text" id="ProductID" style="margin-right: 10px"/>
					<button id="genCode" class="button button-primary" style="margin-right: 10px">Creare Code</button>
				</td>
				<td>
					<form action="<?php echo plugins_url("../export-data.php", __FILE__ )."" ?>" method="post">
						<input class="button button-primary" type="submit" name="export" value="Export" />
					</form>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<label id ="ProductCode"></label>
				</td>
			</tr>
		</table>
	</div>

	<script type="text/javascript">
		// $("#create").click(function(){
		// 	CreateTable();
		// })
		$(document).ready(function (){
			CreateTable();
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
		        data:{ID:productID},
		        success: function (output) {
		           $("#ProductCode").html("Product Code: "+output);
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
