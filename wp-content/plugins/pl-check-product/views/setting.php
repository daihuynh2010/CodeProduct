<?php
function PageSetting(){
	?>
	<div class="wrap validate">
		<h1>Setting Code Product</h1>
		<br/>
		<div class="notice notice-success settings-error is-dismissible"><p><strong id="resultSave"></strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<table >
			<tr style="margin-bottom: 10px">
				<th style="text-align: right;">
					<label> Number of Enter:</label>
				</th>
				<td>
					<input type="text" id="NumberEnter" style="margin-right: 10px"/>
					
				</td>
			</tr>
			<tr style="margin-bottom: 10px">
				<th style="text-align: right;">
					<label> Length Code:</label>
				</th>
				<td>
					<input type="text" id="LengthCode" style="margin-right: 10px"/>
				</td>
			</tr>

			<tr style="margin-bottom: 10px">
				<th style="text-align: right;">
				</th>
				<td style="text-align: left;">
					<button id="SaveNumber" class="button button-primary" >Save</button>
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
		           	if(output != ""){
		           		var NumberofEnter = output.split(";#")[0];
		           		var Length = output.split(";#")[1];
		           		$("#NumberEnter").val(NumberofEnter);
		           		$("#LengthCode").val(Length);
		       		}
		        },
		        error: function(xhr){
			        console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			    }
			});
		};

		$("#SaveNumber").click(function(){
			var NumberofEnter = $("#NumberEnter").val();
			var LengthCode = $("#LengthCode").val();
			$("#resultSave").html("");
			$.ajax({
				type: "POST",
		        url: "<?php echo plugins_url("../function.php", __FILE__ ).""  ?>",
		        data:{NumberofEnter:NumberofEnter, LengthCode:LengthCode },
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



