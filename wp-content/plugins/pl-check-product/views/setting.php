<?php
function PageSetting(){
	?>
	<div class="wrap validate">
		<h1>Setting Code Product</h1>
		<br/>
		<span id="resultSave"></span>
		<table >
			<tr style="margin-bottom: 10px">
				<th>
					<label> Number of Enter:</label>
				</th>
				<td>
					<input type="text" id="NumberEnter" style="margin-right: 10px"/>
					<button id="SaveNumber" class="button button-primary" style="margin-right: 10px">Save</button>
				</td>
			</tr>
		</table>
	</div>

	<script type="text/javascript">
		$(document).ready(function (){
			CreateTable();
		});

		function CreateTable(){
			$.ajax({
				type: "GET",
		        url: "<?php echo plugins_url("../function.php", __FILE__ )."?CreateTableStatic"  ?>",
		        success: function (output) {
		           console.log(output);
		        },
		        error: function(xhr){
			        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			    }
			});
		};

		$("#SaveNumber").click(function(){
			var NumberofEnter = $("#NumberEnter").val();
			$("#resultSave").html("");
			$.ajax({
				type: "POST",
		        url: "<?php echo plugins_url("../function.php", __FILE__ ).""  ?>",
		        data:{NumberofEnter:NumberofEnter},
		        success: function (output) {
		           $("#resultSave").html(output);
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



