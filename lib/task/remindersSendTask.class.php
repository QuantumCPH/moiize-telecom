<?php

class remindersSendTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

  	
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));
    

    $this->namespace        = 'reminders';
    $this->name             = 'send';
    $this->briefDescription = 'Sends reminders to pending invoice holders';
    $this->detailedDescription = <<<EOF
The [reminders:send|INFO] task does things.
Call it with:

  [php symfony reminders:send|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // my code here
    /*
	check if R1 cost is already been incluced
		no: add other_cost with R1 with current date()
		yes:check if R2 cost is already been included
			no: add other_cost with R2 with current date()
			yes:check if activation cost is already been added
				no: 
					change company status to -suspended-
					notify the company and zapna admins
				yes:
					exit;
	*/
    //pi: get all [pending invoices] for the companies that are [active]
    $c = new Criteria();
    
    $c->add(InvoicePeer::INVOICE_STATUS_ID, 1); //pending
    $c->addJoin(CompanyPeer::ID, InvoicePeer::COMPANY_ID); //active
 	$c->addAnd(CompanyPeer::STATUS_ID, 1);
 	
    $invoices = InvoicePeer::doSelect($c);
    
    //end pi:
    
    
    //echo count($invoices);
    //loop through each of pending invoice
    
$newline = '
';
   
    foreach ($invoices as $invoice)
    {
    	echo $newline.$invoice->getCompany()->getName();
    	echo $newline.$invoice->getInvoiceStatus()->getName(); 
    }
  }
}
