<?php

/**
 * agent_bank actions.
 *
 * @package    zapnacrm
 * @subpackage agent_bank
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class agent_bankActions extends autoagent_bankActions {
    public function executeView($request) {
        $this->agent_bank = AgentBankPeer::retrieveByPk($request->getParameter('id'));
    }
}
