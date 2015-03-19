<form action='group.php' method="POST"> 
	<input type="hidden" name="type" value="group">
<table>
	<tbody>
		<tr>
			<td>Name</td>
			
			<td><input type="text" name="name" required></td>
			</tr>
		<tr>
			<td>Page</td>
			
			<td>
				<select name="parent" required>
					<option value="">select page</option>
					<?php echo getPages() ?>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			
			<td><input type="submit" value="Create" name="submit"></td>
	</tbody>
</table> 

</form>