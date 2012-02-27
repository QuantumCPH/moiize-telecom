<?php
class sfCultureFilter extends sfFilter
{
	/**
	* Execute filter
	*
	* @param FilterChain $filterChain The symfony filter chain
	*/
	public function execute ($filterChain)
	{
		return $filterChain->execute();
	}
}