<h1>Employee List</h1>

<table class="list-view">
  <thead>
    <tr>
      <th>Id</th>
      <th>Company</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Email</th>
      <th>Mobile model</th>
      <th>Mobile number</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($employee_list as $employee): ?>
    <tr>
      <td><a href="<?php echo url_for('employee/edit?id='.$employee->getId()) ?>"><?php echo $employee->getId() ?></a></td>
      <td><?php echo $employee->getCompany() ?></td>
      <td><?php echo $employee->getFirstName() ?></td>
      <td><?php echo $employee->getLastName() ?></td>
      <td><?php echo $employee->getEmail() ?></td>
      <td><?php echo $employee->getMobileModel() ?></td>
      <td><?php echo $employee->getMobileNumber() ?></td>
      <td><?php echo $employee->getCreatedAt() ?></td>
      <td><?php echo link_to('edit', 'employee/edit?id='.$employee->getId()); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('employee/new') ?>">New</a>
