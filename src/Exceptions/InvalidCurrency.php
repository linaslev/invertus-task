<?php

namespace Exceptions;

use Exception;

class InvalidCurrency extends Exception
{
    protected $message = 'Unsupported currency provided';

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @param string $currencyCode
     * @return $this
     */
    public function setCurrencyCode(string $currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Error: ' . $this->getMessage();
    }
}