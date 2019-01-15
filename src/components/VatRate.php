<?php

namespace RichweberTechnology\vatfyi\components;

use RichweberTechnology\vatfyi\Client;

/**
 * Class VatRate
 * @package RichweberTechnology\vatfyi\components
 */
class VatRate
{
    /**
     * @var Client
     */
    private $_client;

    /**
     * @var Amount|null
     */
    private $_amount;

    /**
     * @var bool
     */
    private $_isVatNumberConfirmed = false;

    /**
     * @var bool
     */
    private $_isVatNumberFailed = false;

    /**
     * @var string|null
     */
    private $_vatNumberFailDescription;

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
     * @param RateDto $dto
     *
     * @return bool
     */
    public function getVatRate(RateDto $dto)
    {
        try {
            $data = [
                'clientCountryCode' => $dto->getClientCountryCode(),
                'amount' => $dto->getAmount(),
            ];

            if ($dto->isBusinessClient()) {
                $data['isBusinessClient'] = $dto->isBusinessClient();
            }
            if ($dto->hasVatNumber()) {
                $data['hasVatNumber'] = $dto->hasVatNumber();
            }
            if ($dto->getVatNumber()) {
                $data['vatNumber'] = $dto->getVatNumber();
            }

            $response = $this->_client->getResponse('POST', 'vat/rate/calculate', $data);
            $vat = json_decode($response);

            if ((int)$vat->status === 201) {
                $this->_amount = new Amount(
                    $vat->data->calculatedAmount->VAT,
                    (float)$vat->data->calculatedAmount->amount,
                    (float)$vat->data->calculatedAmount->vatAmount,
                    (float)$vat->data->calculatedAmount->totalAmount
                );

                $this->_isVatNumberConfirmed = $vat->data->isVatNumberConfirmed;
                $this->_isVatNumberFailed = $vat->data->isVatNumberFailed;
                $this->_vatNumberFailDescription = $vat->data->vatNumberFailDescription;

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
     * @return Amount|null
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return bool
     */
    public function isVatNumberConfirmed()
    {
        return $this->_isVatNumberConfirmed;
    }

    /**
     * @return bool
     */
    public function isVatNumberFailed()
    {
        return $this->_isVatNumberFailed;
    }

    /**
     * @return string|null
     */
    public function getVatNumberFailDescription()
    {
        return $this->_vatNumberFailDescription;
    }

    /**
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->_errorDescription;
    }
}
