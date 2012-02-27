<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<ul>
            <li>
                <div id="sf_admin_content">
		<table width="100%" border="2" cellspacing="0" cellpadding="2" align="center">
                  <thead >
                    <th id="sf_admin_list_th_id" >Id</th>
                    <th id="sf_admin_list_th_first_name">First Name</th>
                    <th id="sf_admin_list_th_last_name" >Last Name</th>
		    <th id="sf_admin_list_th_mobile_number" >Mobile Number</th>
		     <th id="sf_admin_list_th_mobile_number" >Password</th>
		    <th id="sf_admin_list_th_fonet_customer">Fonet Customer ID</th>
		    <th id="sf_admin_list_th_agent">Agent</th>
		    <th id="sf_admin_list_th_address">Address</th>
                    <th id="sf_admin_list_th_city" >City</th>
                    <th id="sf_admin_list_th_po_box_number" >PO-BOX Number</th>
                    <th id="sf_admin_list_th_email" >Email</th>
                    <th id="sf_admin_list_th_created_at" >Created At</th>


                    <th id="sf_admin_list_th_date_of_birth">Date Of Birth</th>
                    <th id="sf_admin_list_th_auto_refill">Auto Refill</th>
                  </thead>
                  <tfoot>
                    <tr><th colspan="16">
                    <div class="float:right">
                    </div>
                    <?php echo count($customers)." - Results" ?></th></tr>
                  </tfoot>
                  <tbody>
                <?php foreach($customers as $customer): ?>
                
                 <tr>
                  <td><?php  echo $customer->getId() ?></td>
                  <td><?php echo  $customer->getFirstName() ?></td>
                  <td><?php echo  $customer->getLastName() ?></td>
		  <td><?php echo  $customer->getMobileNumber() ?></td>
		    <td><?php echo  $customer->getPlainText() ?></td>
		  <td><?php echo  $customer->getFonetCustomerId() ?></td>
		<?php $agent = AgentCompanyPeer::retrieveByPK( $customer->getReferrerId()) ?>
                  <td><?php echo  $agent->getName() ?></td>
		  <td><?php echo  $customer->getAddress() ?></td>
                  <td><?php echo  $customer->getCity() ?></td>
                  <td><?php echo  $customer->getPoBoxNumber() ?></td>
                  <td><?php echo  $customer->getEmail() ?></td>
                  <td><?php echo  $customer->getCreatedAt() ?></td>
                  <td><?php echo  $customer->getDateOfBirth() ?></td>
                  <?php if ($customer->getAutoRefillAmount()!=NULL && $customer->getAutoRefillAmount()>1){ ?>
                  <td>Yes</td>
                  <?php } else
                      { ?>
                  <td>No</td>
                  <?php } ?>
                </tr>

                <?php endforeach; ?>
                  </tbody>
              </table>
                </div>
            </li>

          </ul>




