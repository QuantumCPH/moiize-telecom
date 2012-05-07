<h1>Telinta config List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Session</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($telinta_config_list as $telinta_config): ?>
    <tr>
      <td><a href="<?php echo url_for('telinta_config/edit?id='.$telinta_config->getId()) ?>"><?php echo $telinta_config->getId() ?></a></td>
      <td><?php echo $telinta_config->getSession() ?></td>
      <td><a href="<?php echo url_for('telinta_config/edit?id='.$telinta_config->getId()) ?>">edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php if(count($telinta_config_list)==0){ ?>
<a href="<?php echo url_for('telinta_config/new') ?>">New</a>
<?php }  ?>