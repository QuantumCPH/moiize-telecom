<h1>CompanyTransaction List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Product</th>
      <th>Company</th>
      <th>Amount</th>
      <th>Extra refill</th>
      <th>Quantity</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Status</th>
      <th>Description</th>
      <th>Transaction status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($company_transaction_list as $company_transaction): ?>
    <tr>
      <td><a href="<?php echo url_for('companyTransaction/edit?id='.$company_transaction->getId()) ?>"><?php echo $company_transaction->getId() ?></a></td>
      <td><?php echo $company_transaction->getProductId() ?></td>
      <td><?php echo $company_transaction->getCompanyId() ?></td>
      <td><?php echo $company_transaction->getAmount() ?></td>
      <td><?php echo $company_transaction->getExtraRefill() ?></td>
      <td><?php echo $company_transaction->getQuantity() ?></td>
      <td><?php echo $company_transaction->getCreatedAt() ?></td>
      <td><?php echo $company_transaction->getUpdatedAt() ?></td>
      <td><?php echo $company_transaction->getStatus() ?></td>
      <td><?php echo $company_transaction->getDescription() ?></td>
      <td><?php echo $company_transaction->getTransactionStatusId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('companyTransaction/new') ?>">New</a>
