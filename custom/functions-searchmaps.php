<?php
/******************************
This creates the form and holds the content sent back
******************************/
function searchmaps_callback(){ ?>
	
	<div class="wrap">
		<table class="widefat postbox">
			<tbody>
				<tr>
					<td>
						<h2>Search by Post Code</h2>
						<form>
							<label>Enter the first part of the post code</label>
							<input type="text" name="postcode" id="postcodeinput">
							<input type="button" id="postcodesearch" value="Search">
							<div id="map-canvas"></div>
						</form>									
					</td>
				</tr>
			</tbody>
		</table>
	</div>


<?php }



