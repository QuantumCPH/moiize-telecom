<?php use_helper('I18N'); ?>

<form action="info" method="GET">
    Enter the Fonet Customer ID:  <input type="text" name="CustomID"/>
    
    <input type="submit" value="Get Info"/>
    
</form>

<?php echo $response_text ?>
