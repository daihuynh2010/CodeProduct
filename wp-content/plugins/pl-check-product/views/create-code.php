<?php
function PageCreateCode(){
	?>
	<div class="wrap validate">
		<h1>Create Code Product</h1>
		<br/>
		<button id="create">CreateTable</button>
		<table class="form-table">
			<tr style="width: 10%">
				<th>
					<label> Enter Product ID:</label>
				</th>
				<th>
					<input type="text" id="ProductID"/>
					<button id="genCode">Gen Code</button>
				</th>
			</tr>
			<tr>
				<td>
					<label id ="ProductCode"></label>
				</td>
			</tr>
		</table>
	</div>

	<script type="text/javascript">
		$("#create").click(function(){
			CreateTable();
		})
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
		           console.log(output);
		           $("#ProductCode").html("Product Code: "+output);
		        },
		        error: function(xhr){
			        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			    }
			});
		});
	</script>
	<?php
}
