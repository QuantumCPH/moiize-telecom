<?php use_helper('I18N'); ?>

<form action="activate" method="GET">
    <table>
<tr>
<td>
    Enter the Fonet Customer ID.</td>
	<td><input type="text" name="CustomID"/></td>
</tr>
<tr>
<td>Enter the Phone No. </td>
<td><input type="text" name="AniNo"/>
</td>
</tr>
</table>
  
  <br><input type="submit" value="Activate"/>
</form>
<?php echo $res;?>