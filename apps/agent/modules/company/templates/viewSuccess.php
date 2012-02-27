<?php
/* 
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

?>

<div class="action-links">
      <?php echo link_to('edit company info', 'company/edit?id='.$company->getId()) ?>
        &nbsp; | &nbsp;
      <?php echo link_to('add users', 'employee/new?company_id='.$company->getId()) ?>
        &nbsp; | &nbsp;
      <?php echo link_to('send confirmation e-mail', 'company/sendActivationMail?id='.$company->getId()) ?>
</div>

<h1>Company info</h1>
    
  
  <div class="clear"></div>

  <label class="grid_2 required">Company Name:</label>
  <div class="grid_2 content">
        <?php echo $company->getName() ?>
  </div>

  <label class="grid_2 required">CVR Number:</label>
  <div class="grid_2 content">
        <?php echo $company->getCVRNumber() ?>
  </div>

  <div class="clear"></div>

  <label class="grid_2 required">Address:</label>
  <div class="grid_2 content">
        <?php echo $company->getAddress() ?>
  </div>

  <label class="grid_2 required">Post Code:</label>
  <div class="grid_2 content">
        <?php echo $company->getPostCode() ?>
  </div>

  <div class="clear"></div>

  <label class="grid_2 required">Country:</label>
  <div class="grid_2 content">
        <?php echo $company->getEnableCountryCountry()->getName() ?>
  </div>

  <label class="grid_2 required">City:</label>
  <div class="grid_2 content">
        <?php echo $company->getCity()->getName() ?>
  </div>

  <div class="clear"></div>

  <label class="grid_2 required">contact name:</label>
  <div class="grid_2 content">
        <?php echo $company->getContactName() ?>
  </div>

  <label class="grid_2 required">contact email:</label>
  <div class="grid_2 content">
        <?php echo $company->getEmail() ?>
  </div>

  <div class="clear"></div>

  <label class="grid_2 required">Head Phone Nr:</label>
  <div class="grid_2 content">
        <?php echo $company->getHeadPhoneNumber() ?>
  </div>

  <label class="grid_2 required">Fax Number:</label>
  <div class="grid_2 content">
        <?php echo $company->getFaxNumber() ?>
  </div>

  <div class="clear"></div>

  <label class="grid_2 required">company form:</label>
  <div class="grid_2 content">
        <?php echo ''.$company->getCompanyType() ?>
  </div>

  <label class="grid_2 required">Account Manager:</label>
  <div class="grid_2 content">
        <?php echo ''.$company->getAccountManager() ?>
  </div>

  <div class="clear"></div>

  <label class="grid_2 required">Registered at:</label>
  <div class="grid_2 content">
        <?php echo $company->getCreatedAt() ?>
  </div>

  <label class="grid_2 required">Confirmed at:</label>
  <div class="grid_2 content">
        <?php echo $company->getConfirmedAt() == '' ? 'no confirmation' : $company->getConfirmedAt() ?>
  </div>

  <div class="clear"></div>


  <label class="grid_2 required">Sim card dispatch date:</label>
  <div class="grid_2 content">
        <?php echo $company->getSimCardDispatchDate() == '' ? 'not dispatched' : $company->getSimCardDispatchDate() ?>
  </div>


  <label class="grid_2 required">Status:</label>
  <div class="grid_2 content">
        <?php echo $company->getStatus() ?>
  </div>
  <div class="clear"></div>

  <h2>Bank info</h2>

  <?php foreach($company->getCompanyBanks() as $bank): ?>

    <label class="grid_2 required">Reg. Nr.</label>
    <div class="grid_2 content"><?php echo $bank->getRegNr()?></div>
    
    <label class="grid_2 required">Account Number</label>
    <div class="grid_2 content"><?php echo $bank->getAccountNumber()?></div>
    
    <div class="clear"></div>

    <label class="grid_2 required">invoice method</label>
    <div class="grid_2 content">
        <?php echo $company->getInvoiceMethod() ?>
    </div>
    
    <div class="clear"></div>

  <?php endforeach; ?>

  <h2>Product info</h2>

  <?php foreach($company->getProductOrders() as $order): ?>

    <label class="grid_2 required">Sim card quantity</label>
    <div class="grid_2 content"><?php echo $order->getSimCardQuantity()?></div>

    <label class="grid_2 required">Price Per Sim</label>
    <div class="grid_2 content"><?php echo $order->getPricePerSim()?></div>

    <div class="clear"></div>

  <?php endforeach; ?>

  <h2>User list</h2>

  <table class="list-view">
      <thead>
      <th>
          Id
      </th>
      <th>
          Name
      </th>
      <th>
          Email
      </th>
      <th>
          Mobile Number
      </th>
      <th>
          Mobile Model
      </th>
      <th>
          Actions
      </th>
      </thead>
      <tbody>
          <?php foreach($company->getEmployees() as $employee): ?>
          <tr>
              <td>
                  <?php echo $employee->getId()?>
              </td>
              <td>
                  <?php echo $employee->getFirstName(). ' '.$employee->getLastName();?>
              </td>
              <td>
                  <?php echo $employee->getEmail()?>
              </td>
              <td>
                  <?php echo $employee->getMobileNumber() ?>
              </td>
              <td>
                  <?php echo $employee->getMobileModel()?>
              </td>
              <td>
                  <?php echo link_to('edit', 'employee/edit?id='.$employee->getId());?>
              </td>
          </tr>
          <?php endforeach; ?>
    </tbody>
  </table>