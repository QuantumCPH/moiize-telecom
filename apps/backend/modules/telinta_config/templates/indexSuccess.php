<div id="sf_admin_container"><h1><?php echo  __('Telinta config List') ?></h1></div>

<table width="75%" cellspacing="0" cellpadding="2" class="tblAlign">
  <thead>
    <tr class="headings">
      <th style="text-align: left" >Id</th>
      <th style="text-align: left" >Session</th>
      <th style="text-align: left" >Action</th>
    </tr>
  </thead>
  <tbody>
    <?php   $incrment=1;    ?>
    <?php foreach ($telinta_config_list as $telinta_config): 
        if($incrment%2==0){
         $class= 'class="even"';
        }else{
         $class= 'class="odd"';
        }
        ?>
    <tr <?php echo $class;   ?>>
      <td><a href="<?php echo url_for('telinta_config/edit?id='.$telinta_config->getId()) ?>"><?php echo $telinta_config->getId() ?></a></td>
      <td><?php echo $telinta_config->getSession() ?></td>
      <td><a href="<?php echo url_for('telinta_config/edit?id='.$telinta_config->getId()) ?>">Renew</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php if(count($telinta_config_list)==0){ ?>
<a href="<?php echo url_for('telinta_config/new') ?>">New</a>
<?php }  ?>