<h1>Telecom operator List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Status</th>
      <th>Country</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($telecom_operator_list as $telecom_operator): ?>
    <tr>
      <td><a href="<?php echo url_for('telecom_operator/edit?id='.$telecom_operator->getId()) ?>"><?php echo $telecom_operator->getId() ?></a></td>
      <td><?php echo $telecom_operator->getName() ?></td>
      <td><?php echo $telecom_operator->getStatusId() ?></td>
      <td><?php echo $telecom_operator->getCountryId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('telecom_operator/new') ?>">New</a>
