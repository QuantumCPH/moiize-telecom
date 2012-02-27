<?php
	class util extends BaseUtil
	{
		public static function saveTotalPayment($invoice_id, $amount)
		{
			$invoice = InvoicePeer::retrieveByPK($invoice_id);

			$invoice->setTotalpayment($amount);
			$invoice->save();				
		}
		
		
		public static function saveHtmlToInvoice($invoice_id, $html_content)
		{
			$invoice = InvoicePeer::retrieveByPK($invoice_id);

			$invoice->setInvoiceHtml($html_content);
			$invoice->save();
		}
		
		public static function getSumForAGroupField($group, $field_to_sum, $is_decimal = true)
		{
			$sum = 0;
		
			if (count($group)>0)
				foreach ($group as $key=>$call_row)
				{
						$sum += $call_row[$field_to_sum];
				}
			if ($is_decimal)
				return number_format($sum, 2);
			else
				return $sum;
		}
		
		public static function getCallSummaryUsageTotal($groups)
		{
			$total = 0;
			if (count($groups)>0)
				foreach ($groups as $group)
				{
					$total += self::getSumForAGroupField($group, 'total_sale_price');
				}
				
			return $total;
		}
		
		
	}
	
?>