<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
                <div id="sf_admin_container"><h1><?php echo  __('All Registered Customer') ?></h1></div>
		<table width="75%" cellspacing="0" cellpadding="2" class="tblAlign">
                    <thead>
                      <tr class="headings">
                        <th width="10%" style="text-align: left" ><?php echo  __('Id') ?></th>
                        <th  width="20%" style="text-align: left"  ><?php echo  __('Customer Number') ?></th>
                        <th  width="20%" style="text-align: left" ><?php echo  __('Mobile Number') ?></th>
                        <th width="20%" style="text-align: left" ><?php echo  __('First Name') ?></th>
                        <th  width="20%"  style="text-align: left" ><?php echo  __('Last Name') ?></th>
                        <th  width="20%"  style="text-align: left" ><?php echo  __('Unique ID') ?></th>
                        <th width="10%" style="text-align: left"> <?php echo  __('Action') ?></th>
                      </tr>
		  </thead>
                  <tfoot>
                    <tr><td colspan="7" style="text-align:center;font-weight: bold;">
                    <?php echo count($customers)." - Results" ?></td></tr>
                  </tfoot>
                  <tbody>
                         <?php   $incrment=1;    ?>
                <?php foreach($customers as $customer): ?>

                 <?php
                  if($incrment%2==0){
                  $colorvalue="#FFFFFF";
                  $class= 'class="even"';
                  }else{
                    $class= 'class="odd"';
                      $colorvalue="#FCD9C9";
                      }
//                  
                  ?>

                      <tr <?php echo $class;   ?>>
                      <td><?php echo $incrment;  ?></td>
                  <td><?php  echo $customer->getId() ?></td>
                   <td><?php echo  $customer->getMobileNumber() ?></td>
                  <td><?php echo  $customer->getFirstName() ?></td>
                    <td><?php echo  $customer->getLastName() ?></td>
                       <td><?php echo  $customer->getUniqueid() ?></td>
                 <td ><a href="customerDetail?id=<?php  echo $customer->getId() ?>"><img alt="view Detail" title="view Detail" src="http://admin.zerocall.com/sf/sf_admin/images/default_icon.png" ></a>
                      </td>
             
                </tr>
<?php   $incrment++;    ?>
                <?php endforeach; ?>
                  </tbody>
              </table>
                </div>
            </li>

          </ul>




