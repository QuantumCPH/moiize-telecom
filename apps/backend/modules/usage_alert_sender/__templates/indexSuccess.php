<h1>Usage alert sender List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Sender name</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($usage_alert_sender_list as $usage_alert_sender): ?>
    <tr>
      <td><a href="<?php echo url_for('usage_alert_sender/edit?id='.$usage_alert_sender->getId()) ?>"><?php echo $usage_alert_sender->getId() ?></a></td>
      <td><?php echo $usage_alert_sender->getSenderName() ?></td>
      <td><?php echo $usage_alert_sender->getStatus() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('usage_alert_sender/new') ?>">New</a>
