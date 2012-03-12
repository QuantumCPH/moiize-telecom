<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  
?>
<div id="sf_admin_container">
    <div id="sf_admin_header">
      <a style="text-decoration:none;" href="<?php echo url_for(sfConfig::get('app_backend_url').'rates') ?>" class="external_link" target="_self">View All Rates</a>
    </div>
</div>
<div id="sf_admin_container">
    <h1><?php echo __('Upload Rates') ?></h1>
</div>

<div id="sf_admin_container">
    <?php if ($sf_user->hasFlash('file_error')): ?>
	<p style="color: red; margin:6px auto;text-align: left;border:0px !important;"><?php echo $sf_user->getFlash('file_error') ?></p>
    <?php endif;?>
    <?php if ($sf_user->hasFlash('file_done')): ?>
	<p style="color: green; margin:6px auto;text-align: left;border:0px !important;"><?php echo $sf_user->getFlash('file_done') ?></p>
    <?php endif;?>    
    <br/>
    <form action="<?php echo url_for(sfConfig::get('app_backend_url').'rates/uploadRates') ?>" method="post" enctype="multipart/form-data" name="frmCSV">
       <div style="color:red;font-size:11px;">Upload comma separated file.</div> 
       <table width="38%" cellspacing="0" cellpadding="5" class="tblRates">
          <tr><th width="41%" align="left">Upload CSV File</th>
          <td width="59%"><input type="file" name="csv_upload" /></td><td><input type="submit" name="btnSubmit" value="Upload File" /></td></tr>
        </table>
    </form>
    
</div>
<br />
<?php if(isset ($updatedRec) && count($updatedRec)>1){?>
<div id="sf_admin_container">
     <p style="color: green; margin:6px auto;text-align: left;border:0px !important;"><?php echo __('Following rates are updated.'); ?></p>
</div>     
<table width="75%" cellspacing="0" cellpadding="2" class="tblAlign">
<tr class="headings">
    <th><?php echo __('Title') ?></th>
</tr>
<?php
//foreach ($updatedRec as $R){
    print_r($updatedRec);
for($i=0; $i<count($updatedRec)-1;$i++){
?>
<tr><td><?php echo $updatedRec[$i];?></td></tr>
<?php    
}
?>

</table>
<?php    
}
?>