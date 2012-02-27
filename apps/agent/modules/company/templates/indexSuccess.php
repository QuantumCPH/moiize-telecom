
<h1>Company List</h1>

<table class="list-view">
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Cvr number</th>
      <th>Ean number</th>
      <th>Address</th>
      <th>Post code</th>
      <th>Contact name</th>
      <th>Email</th>
      <th>Head phone number</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($company_list as $company): ?>
    <tr>
      <td><a href="<?php echo url_for('company/edit?id='.$company->getId()) ?>"><?php echo $company->getId() ?></a></td>
      <td><?php echo $company->getName() ?></td>
      <td><?php echo $company->getCvrNumber() ?></td>
      <td><?php echo $company->getEanNumber() ?></td>
      <td><?php echo $company->getAddress() ?></td>
      <td><?php echo $company->getPostCode() ?></td>
      <td><?php echo $company->getContactName() ?></td>
      <td><?php echo $company->getEmail() ?></td>
      <td><?php echo $company->getHeadPhoneNumber() ?></td>
      <td><?php echo $company->getStatus() ?></td>
      <td>
        <?php echo link_to('View', 'company/view?id='.$company->getId())?>
          &nbsp; 
        <?php echo link_to('Edit', 'company/edit?id='.$company->getId())?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('company/new') ?>">New</a>
