<h1>Customer List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Country</th>
      <th>City</th>
      <th>Po box number</th>
      <th>Mobile number</th>
      <th>Device</th>
      <th>Email</th>
      <th>Password</th>
      <th>Is newsletter subscriber</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Customer status</th>
      <th>Address</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($customer_list as $customer): ?>
    <tr>
      <td><a href="<?php echo url_for('customer/edit?id='.$customer->getId()) ?>"><?php echo $customer->getId() ?></a></td>
      <td><?php echo $customer->getFirstName() ?></td>
      <td><?php echo $customer->getLastName() ?></td>
      <td><?php echo $customer->getCountryId() ?></td>
      <td><?php echo $customer->getCity() ?></td>
      <td><?php echo $customer->getPoBoxNumber() ?></td>
      <td><?php echo $customer->getMobileNumber() ?></td>
      <td><?php echo $customer->getDeviceId() ?></td>
      <td><?php echo $customer->getEmail() ?></td>
      <td><?php echo $customer->getPassword() ?></td>
      <td><?php echo $customer->getIsNewsletterSubscriber() ?></td>
      <td><?php echo $customer->getCreatedAt() ?></td>
      <td><?php echo $customer->getUpdatedAt() ?></td>
      <td><?php echo $customer->getCustomerStatusId() ?></td>
      <td><?php echo $customer->getAddress() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('customer/new') ?>">New</a>
