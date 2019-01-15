<?php

namespace RichweberTechnology\vatfyi\components;

/**
 * Class Amount
 * @package RichweberTechnology\vatfyi\components
 */
class Amount
{
    /**
     * @var string
     */
    private $_VAT;

    /**
     * @var float
     */
    private $_amount;

    /**
     * @var float
     */
    private $_vatAmount;

    /**
     * @var float
     */
    private $_totalAmount;

    /**
     * Amount constructor.
     *
     * @param string $VAT
     * @param float $amount
     * @param float $vatAmount
     * @param float $totalAmount
     */
    public function __construct(string $VAT, float $amount, float $vatAmount, float $totalAmount)
    {
        $this->_VAT = $VAT;
        $this->_amount = $amount;
        $this->_vatAmount = $vatAmount;
        $this->_totalAmount = $totalAmount;
    }

    /**
     * @return string
     */
    public function getVAT(): string
    {
        return $this->_VAT;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->_amount;
    }

    /**
     * @return float
     */
    public function getVatAmount(): float
    {
        return $this->_vatAmount;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->_totalAmount;
    }
}
