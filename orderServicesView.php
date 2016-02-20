List of Files

<table width="720" align="center" bordercolor="#FF9900" height="150" style="margin-top:10px">
	<!-- <tr>
		<td width="566">
			<table width="698" align="center"  cellpadding="2" cellspacing="2"> -->
				<tr bgcolor="#FF9900">
					<th>No.</th>
					<th>File Name</th>		
					<th>Size of File</th>
					<th>Download</th>
					<th>No copy</th>
					<th>Page</th>
					<th>Price</th>
					<th>Action</th>
				</tr>
			<?php 	
			require_once('Conn/dbconn.php');
			$ii = 1;

			$sql   = "SELECT * FROM `service_files` where service_id ='".$_REQUEST['service_id']."'";
			$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
			$row   = mysql_num_rows($query);

			while( $data = mysql_fetch_array( $query ) ) { 
			?> 
				<tr style="overflow:scroll;"><td><?php echo $ii++; ?></td>		
					<td><?php echo $data['service_file_name']; ?></td>        
					<td><?php echo $data['service_file_size']; ?> kb</td>
					<td>
					<a href="myServiceDownload.php?service_file_id=<?php echo $data['service_file_id']; ?>">Download</a></td>
					<td><?php echo $data['service_file_copy']; ?></td>        
					<td><?php echo $data['service_file_page']; ?></td>
					<td>RM <?php echo $data['service_file_price']; ?></td>
			        <td> 
			        	
			        	<a href="orderServicesDelete.php?service_file_id=<?php echo $data['service_file_id']; ?>&btnId=<?php echo $_REQUEST['btnId']; ?>" onclick="return confirm('Are you sure to delete this ???' );">
			        		<input type="button" name="delOrder" value="Delete"/>
			        	</a>
			        	<!-- <a href="orderServiceSiap.php?service_id=<?php echo $data['service_id']; ?>&service_file_id=<?php echo $data['service_file_id']; ?>">
        					<input type="button" name="delOrder" value="Siap"/></a>
			        	</td>  -->
				</tr>
			<?php }?>
			<!-- </table>

		</td>
	</tr> -->
</table>
