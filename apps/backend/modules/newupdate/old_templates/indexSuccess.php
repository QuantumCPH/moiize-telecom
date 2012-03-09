<h1>Newupdate List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Created at</th>
      <th>Message</th>
      <th>Heading</th>
      <th>Starting date</th>
      <th>Expire date</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($newupdate_list as $newupdate): ?>
    <tr>
      <td><a href="<?php echo url_for('newupdate/edit?id='.$newupdate->getId()) ?>"><?php echo $newupdate->getId() ?></a></td>
      <td><?php echo $newupdate->getCreatedAt() ?></td>
      <td><?php echo $newupdate->getMessage() ?></td>
      <td><?php echo $newupdate->getHeading() ?></td>
      <td><?php echo $newupdate->getStartingDate() ?></td>
      <td><?php echo $newupdate->getExpireDate() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('newupdate/new') ?>">New</a>
