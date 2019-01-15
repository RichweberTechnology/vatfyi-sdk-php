<?php

namespace RichweberTechnology\vatfyi\components;

/**
 * Class Company
 * @package RichweberTechnology\vatfyi\components
 */
class Company
{
    /**
     * @var string
     */
    private $_companyName;

    /**
     * @var string
     */
    private $_countryCode;

    /**
     * @var string|null
     */
    private $_companyAddress;

    /**
     * @var string|null
     */
    private $_vatNumber;

    /**
     * Company constructor.
     *
     * @param string $companyName
     * @param string $countryCode
     * @param string|null $companyAddress
     * @param string|null $vatNumber
     */
    public function __construct(
        string $companyName,
        string $countryCode,
        ?string $companyAddress = null,
        ?string $vatNumber = null
    ) {
        $this->_companyName = $companyName;
        $this->_countryCode = $countryCode;
        $this->_companyAddress = $companyAddress;
        $this->_vatNumber = $vatNumber;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->_companyName;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->_countryCode;
    }

    /**
     * @return string|null
     */
    public function getCompanyAddress(): ?string
    {
        return $this->_companyAddress;
    }

    /**
     * @return string|null
     */
    public function getVatNumber(): ?string
    {
        return $this->_vatNumber;
    }
}
