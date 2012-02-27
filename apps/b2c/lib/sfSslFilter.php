<?php
class sslFilter extends sfFilter
{
	/**
	* Execute filter
	*
	* @param FilterChain $filterChain The symfony filter chain
	*/
	public function execute ($filterChain)
	{
		$context = $this->getContext();
		$request = $context->getRequest();
		$ssl_actions = sfConfig::get('app_ssl_secure_actions');
		$allow_ssl = sfConfig::get('app_ssl_ignore_non_secure');
		/*
		 * Uncomment For Debugging
		 *
		 * echo '<pre>';
		 * print_r($ssl_actions);
		 * echo '</pre>';
		 * exit();
		 *
		 */
		if (!$request->isSecure())
		{
			//Redirect to the Secure Url
			//If the module and/or action match $ssl_actions set in app.yml
			foreach($ssl_actions as $action)
			{
			   if($action['module'] == $context->getModuleName() && !$action['action']){
					//The entire module needs to be secure
					//Redired no matter what the action is.
					$secure_url = str_replace('http', 'https', $request->getUri());
					return $context->getController()->redirect($secure_url, 0 , 301);
				} else if($action['module'] == $context->getModuleName() && $action['action'] == $context->getActionName())
				{
					//Redirect if the module and action need to be secure
					$secure_url = str_replace('http', 'https', $request->getUri());
					return $context->getController()->redirect($secure_url, 0 , 301);
				}
			 }
		} else if($request->isSecure() && !$allow_ssl)
		{
			$redirect = true;
			//Redirect to the Non-Secure Url
			//If the module and/or action are not in $ssl_actions set in app.yml
			foreach($ssl_actions as $action)
			{
				if(($action['module'] == $context->getModuleName() && !$action['action']) || ($action['module'] == $context->getModuleName() && $action['action'] == $context->getActionName()))
				{
					$redirect = false;
				}
			}
			if($redirect)
			{
				 $non_secure_url = str_replace('https', 'http', $request->getUri());
				 return $context->getController()->redirect($non_secure_url, 0 , 301);
			}
		}
		$filterChain->execute();
	}
}