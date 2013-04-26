<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  
?>

<div id="sf_admin_container">
    <h1><?php echo __('Upload Countries Master File') ?></h1>
</div>

<div id="sf_admin_container">
    <?php if ($sf_user->hasFlash('file_error')): ?>
	<p style="color: red; margin:6px auto;text-align: left;border:0px !important;"><?php echo $sf_user->getFlash('file_error') ?></p>
    <?php endif;?>
    <?php if ($sf_user->hasFlash('file_done')): ?>
	<p style="color: green; margin:6px auto;text-align: left;border:0px !important;"><?php echo $sf_user->getFlash('file_done') ?></p>
    <?php endif;?>    
    <br/>
    <form action="<?php echo url_for(sfConfig::get('app_backend_url').'rt_countries/uploadCSV') ?>" method="post" enctype="multipart/form-data" name="frmCSV">
       <div style="color:red;font-size:11px;">Upload comma separated file.</div> 
       <table width="44%" cellspacing="0" cellpadding="5" class="tblRates">
          <tr><th width="41%" align="left">Upload CSV File</th>
          <td width="59%"><input type="file" name="csv_upload" /></td><td><input type="submit" name="btnSubmit" value="Upload File" /></td></tr>
        </table>
    </form>
    
</div>