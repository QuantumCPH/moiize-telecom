<h1>Usage alert List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Alert amount</th>
      <th>Sms alert message</th>
      <th>Sms active</th>
      <th>Email alert message</th>
      <th>Email active</th>
      <th>Country</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($usage_alert_list as $usage_alert): ?>
    <tr>
      <td><a href="<?php echo url_for('usage_alert/edit?id='.$usage_alert->getId()) ?>"><?php echo $usage_alert->getId() ?></a></td>
      <td><?php echo $usage_alert->getAlertAmount() ?></td>
      <td><?php echo $usage_alert->getSmsAlertMessage() ?></td>
      <td><?php echo $usage_alert->getSmsActive() ?></td>
      <td><?php echo $usage_alert->getEmailAlertMessage() ?></td>
      <td><?php echo $usage_alert->getEmailActive() ?></td>
      <td><?php echo $usage_alert->getCountry() ?></td>
      <td><?php echo $usage_alert->getStatus() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('usage_alert/new') ?>">New</a>
