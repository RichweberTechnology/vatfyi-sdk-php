<?php

namespace RichweberTechnology\vatfyi\components;

use RichweberTechnology\vatfyi\Client;

/**
 * Class VatNumber
 * @package RichweberTechnology\vatfyi\components
 */
class VatNumber
{
    /**
     * @var Client
     */
    private $_client;

    /**
     * @var Company|null
     */
    private $_company;

    /**
     * @var bool
     */
    private $_isValidNumber = false;

    /**
     * @var string
     */
    private $_errorDescription = '';

    /**
     * VatNumber constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->_errorDescription === '';
    }

    /**
     * @param string $number
     *
     * @return bool
     */
    public function checkVatNumber(string $number)
    {
        try {
            $response = $this->_client->getResponse('GET', 'vat/number/' . $number . '/check');
            $vat = json_decode($response);

            if ((int)$vat->status === 200) {
                if ($vat->data->isValidNumber) {
                    $this->_isValidNumber = true;
                    $this->_company = new Company(
                        $vat->data->company->name,
                        substr($number, 0, 2),
                        $vat->data->company->address,
                        substr($number, 2)
                    );
                }

                return true;
            }
            if ((int)$vat->status === 422) {
                foreach ($vat->data as $error) {
                    $this->_errorDescription .= $error->message . PHP_EOL;
                }
            }
            if ((int)$vat->status === 401) {
                $this->_errorDescription = $vat->data->message;
            }
        } catch (\GuzzleHttp\Exception\GuzzleException | \Exception $exception) {
            $this->_errorDescription = $exception->getMessage();
        }

        return false;
    }

    /**
     * @return Company|null
     */
    public function getCompany()
    {
        return $this->_company;
    }

    /**
     * @return bool
     */
    public function isValidNumber()
    {
        return $this->_isValidNumber;
    }

    /**
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->_errorDescription;
    }
}
