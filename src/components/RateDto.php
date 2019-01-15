<?php

namespace RichweberTechnology\vatfyi\components;

use RichweberTechnology\vatfyi\VatException;

/**
 * Class RateDto
 * @package RichweberTechnology\vatfyi\components
 */
class RateDto
{
    /**
     * @var string
     */
    private $_clientCountryCode;

    /**
     * @var float
     */
    private $_amount;

    /**
     * @var boolean
     */
    private $_isBusinessClient = false;

    /**
     * @var boolean
     */
    private $_hasVatNumber = false;

    /**
     * @var string|null
     */
    private $_vatNumber;

    /**
     * RateDto constructor.
     *
     * @param string $clientCountryCode
     * @param float $amount
     * @param bool $isBusinessClient
     * @param bool $hasVatNumber
     * @param string|null $vatNumber
     *
     * @throws VatException
     */
    public function __construct(
        string $clientCountryCode,
        float $amount,
        bool $isBusinessClient = false,
        bool $hasVatNumber = false,
        $vatNumber = null
    ) {
        $this->_clientCountryCode = $clientCountryCode;
        $this->_amount = $amount;

        if ($isBusinessClient && $hasVatNumber && (empty($vatNumber) || $vatNumber === '')) {
            throw new VatException('VAT number can\'t be empty.');
        }
        if ($amount < 0.01) {
            throw new VatException('Amount should be more then 0.');
        }

        $this->_isBusinessClient = $isBusinessClient;
        $this->_hasVatNumber = $hasVatNumber;
        $this->_vatNumber = $vatNumber;
    }

    /**
     * @return string
     */
    public function getClientCountryCode()
    {
        return $this->_clientCountryCode;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return bool
     */
    public function isBusinessClient()
    {
        return $this->_isBusinessClient;
    }

    /**
     * @return bool
     */
    public function hasVatNumber()
    {
        return $this->_hasVatNumber;
    }

    /**
     * @return string|null
     */
    public function getVatNumber()
    {
        return $this->_vatNumber;
    }
}
