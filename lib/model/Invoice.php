<?php

class Invoice extends BaseInvoice
{
		public static function getPendingInvoices($company_id)
		{
			$c = new Criteria();
			
			$c->addJoin(InvoiceStatusPeer::ID, InvoicePeer::INVOICE_STATUS_ID);
			$c->add(InvoicePeer::COMPANY_ID, $company_id);
			$c->addAnd(InvoiceStatusPeer::NAME, 'pending');
			$c->setIgnoreCase(true);
			
			$invoices = InvoicePeer::doSelect($c);
			
			return $invoices;
		}

		public static function getDueInvoices()
		{
			$c = new Criteria();
			$c->addJoin(InvoiceStatusPeer::ID, InvoicePeer::INVOICE_STATUS_ID);
			$c->addAnd(InvoiceStatusPeer::NAME, 'pending');
			// TODO:
			$c->addAnd(InvoicePeer::DUE_DATE, 'pending');
			$c->setIgnoreCase(true);
			
			$invoices = InvoicePeer::doSelect($c);
			
			return $invoices;
		}
		
		public static function getLastPaidInvoice($company_id)
		{
			$c = new Criteria();
			
			$c->addJoin(InvoiceStatusPeer::ID, InvoicePeer::INVOICE_STATUS_ID);
			$c->add(InvoicePeer::COMPANY_ID, $company_id);
			$c->addAnd(InvoiceStatusPeer::NAME, 'paid');
			$c->setIgnoreCase(true);
			
			$invoice = InvoicePeer::doSelectOne($c);
			
			return $invoice;
		}

}
