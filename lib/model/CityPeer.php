<?php

class CityPeer extends BaseCityPeer
{


    static public function getSortedSweedishCities() {
        $c = new Criteria();
        $c->add(CityPeer::COUNTRY_ID,73);
        $c->addAscendingOrderByColumn(CityPeer::NAME);
        $rs = CityPeer::doSelect($c);
        return $rs;
    }
}
