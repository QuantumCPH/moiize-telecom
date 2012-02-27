<h1>City List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Country</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($city_list as $city): ?>
    <tr>
      <td><a href="<?php echo url_for('city/edit?id='.$city->getId()) ?>"><?php echo $city->getId() ?></a></td>
      <td><?php echo $city->getCountryId() ?></td>
      <td><?php echo $city->getName() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('city/new') ?>">New</a>
