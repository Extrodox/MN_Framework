<form action='section.php' method="POST"> 
	<input type="hidden" name="type" value="sections">
<table>
	<tbody>
		<tr>
			<td>Name</td>
			<td><input type="text" class="text" name="name" required></td>
			</tr>
		<tr>
			<td>Page</td>
			<td>
				<select name="parent">
					<option value="">NONE*</option>
					<?php echo getPages(); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>			
			<td><input type="submit" value="Create" name="submit"></td>
	</tbody>
</table> 

</form>