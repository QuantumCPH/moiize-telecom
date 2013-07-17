<?php

class PortaBillingSoapClient extends SoapClient {

    /**
     * Server URL
     * @var string
     */
    protected $serverUrl;
    /**
     * Interface Admin or Reseller
     * @var string
     */
    protected $interface;
    /**
     * Service, e.g. Account, Customer, etc
     * @var string
     */
    protected $service;
    /**
     * Session Id used for authentication when communicating with service
     * @var string
     */
    protected $sessionId;

    /**
     * Constructor
     * @param string $serverUrl Server URL
     * @param string $interface Interface Admin or Reseller
     * @param string $service Service, e.g. Account, Customer, etc
     * @param array $options SoapClient options, optional
     * @see SoapClient
     */
    public function __construct($serverUrl, $interface, $service, $options = array()) {

        $this->serverUrl = rtrim($serverUrl, '/');
        $this->_setSessionId();
        $this->interface = $interface;
        $this->service = $service;
        parent::__construct(
                        $this->_constructUri($this->serverUrl, $this->interface, $this->service),
                        $options
        );
    }

    /**
     * Login to the service
     * @param string $login login
     * @param string $password password
     * @return string Session Id
     */
    public function _login($login, $password) {

        $result = false;
        $max_retries = 5;
        $retry_count = 0;
        while (!$result && $retry_count < $max_retries) {
            try {
                $soap_client = new SoapClient($this->_constructUri($this->serverUrl, $this->interface, 'Session'));
                $result = $soap_client->login($login, $password);
            } catch (SoapFault $e) {
                if ($e->faultstring != 'Could not connect to host') {
                    emailLib::sendErrorInTelinta("Login Issue", "Could not Login with Billing Server. Error is " . $e->faultstring . "  <br/> Please Investigate.");
                    return false;
                }
            }sleep(0.5);
            $retry_count++;
        }
        if ($retry_count == $max_retries) {
            emailLib::sendErrorInTelinta("Login Issue", "Could not Login with Billing Server. Error is Even After Max Retries" . $max_retries . "  <br/> Please Investigate.");
            return false;
        }
        return $result;
    }

    /**
     * Logout from the service
     * @param string $sessionId Session Id to be loged out from, optional
     * @return mixed result from soap method call
     */
    public function _logout($sessionId = NULL) {
        $soap_client = new SoapClient(
                        $this->_constructUri($this->serverUrl, $this->interface, 'Session')
        );
        $sessionId = $sessionId ? $sessionId : $this->sessionId;
     //   return $soap_client->logout($sessionId);
    }

    /**
     * Get Session Id
     * @return string
     */
    public function _getSessionId() {
        $c = new Criteria();
        $tilentaConfigCount = TelintaConfigPeer::doSelectOne($c);
        return $tilentaConfigCount->getSession();
    }

    /**
     * Set Session Id used for authentication when communicating with service
     * @param string $sessionId Session Id
     * @return PortaBillingSoapClient $this
     */
    public function _setSessionId() {

        $this->sessionId = $this->_getSessionId();
        $soapSession[] = new SoapVar(
                        "<session_id>$this->sessionId</session_id>",
                        XSD_ANYXML,
                        'session_id',
                        $this->serverUrl . '/Porta/SOAP/Session')
        ;
        $authInfo = new SoapHeader(
                        $this->serverUrl . '/Porta/SOAP/Session',
                        'auth_info',
                        $soapSession
        );
        $this->__setSoapHeaders($authInfo);
        return $this;
    }

    /**
     * Construct wsdl service URI
     * @param string $serverUrl Server URL
     * @param string $interface Interface
     * @param string $service Service
     * @return string service URI
     */
    protected function _constructUri($serverUrl, $interface, $service) {
        return $serverUrl . '/wsdl/' . $service . $interface . 'Service.wsdl';
    }

}