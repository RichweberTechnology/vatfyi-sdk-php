<?php

namespace RichweberTechnology\vatfyi;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Client
 * @package RichweberTechnology\vatfyi
 */
class Client
{
    /**
     * @var string
     */
    private $_serviceURL = 'https://api.vat.fyi';

    /**
     * @var string
     */
    private $_apiVersion = '1';

    /**
     * @var string
     */
    private $_apiKey;

    /**
     * @var GuzzleClient
     */
    private $_guzzle;

    /**
     * @var bool
     */
    private $_isTest = false;

    /**
     * @var bool
     */
    private $_returnRawResponse = true;

    /**
     * Client constructor.
     *
     * @param string $apiKey
     * @param array $params
     */
    public function __construct(string $apiKey = '', array $params = [])
    {
        $this->_apiKey = $apiKey;
        $this->_guzzle = new GuzzleClient();

        if (isset($params['returnRawResponse']) && is_bool($params['returnRawResponse'])) {
            $this->_returnRawResponse = $params['returnRawResponse'];
        }
        if (isset($params['isTest']) && is_bool($params['isTest'])) {
            $this->_isTest = $params['isTest'];
        }
        if (isset($params['serviceURL'])) {
            $this->_serviceURL = $params['serviceURL'];
        }
        if (isset($params['apiVersion'])) {
            $this->_apiVersion = $params['apiVersion'];
        }
    }

    /**
     * @param string $serviceURL
     *
     * @return Client
     */
    public function setServiceURL(string $serviceURL)
    {
        $this->_serviceURL = $serviceURL;
        return $this;
    }

    /**
     * @param string $apiVersion
     *
     * @return Client
     */
    public function setApiVersion(string $apiVersion)
    {
        $this->_apiVersion = $apiVersion;
        return $this;
    }

    /**
     * @param bool $isTest
     *
     * @return Client
     */
    public function setIsTest(bool $isTest)
    {
        $this->_isTest = $isTest;
        return $this;
    }

    /**
     * @param bool $returnRawResponse
     *
     * @return Client
     */
    public function setReturnRawResponse(bool $returnRawResponse)
    {
        $this->_returnRawResponse = $returnRawResponse;
        return $this;
    }

    /**
     * @param string $requestType
     * @param string $method
     * @param array $data
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getResponse(string $requestType, string $method, array $data = [])
    {
        $response = $this->_guzzle->request($requestType, $this->getURL($method), [
            'http_errors' => !$this->_returnRawResponse,
            'verify' => !$this->_isTest,
            'query' => ['access-token' => $this->_apiKey],
            'json' => $data,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        return (string)$response->getBody();
    }

    /**
     * @param string $method
     *
     * @return string
     */
    private function getURL(string $method)
    {
        return $this->_serviceURL . '/v' . $this->_apiVersion . '/' . $method;
    }
}
