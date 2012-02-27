<?php use_helper('I18N'); ?>

<form action="recharge" method="GET">
<table>
<tr>
<td>
    Enter the Fonet Customer ID.</td>
	<td><input type="text" name="CustomID"/></td>
</tr>
<tr>
<td>
Enter the Recharge amount (multiplied by 100). </td>
<td>
<input type="text" name="ChargeValue"/>
</td>
</tr>
</table>

    <input type="submit" value="Recharge"/>
</form>

<?php echo $res;?>