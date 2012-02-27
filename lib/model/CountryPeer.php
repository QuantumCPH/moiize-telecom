<?php

class CountryPeer extends BaseCountryPeer
{
     static public function getSortedCountries() {
        $c = new Criteria();
         $c->addAnd(CountryPeer::ID,73);
        $c->addAscendingOrderByColumn(CountryPeer::NAME);
        $rs = CountryPeer::doSelect($c);
        return $rs;
    }
}
