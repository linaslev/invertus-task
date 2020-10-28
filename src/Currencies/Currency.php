<?php

namespace Currencies;

abstract class Currency
{
    private static $instances;

    /**
     * @var string
     */
    protected $code;

    /**
     * Exchange rate to default currency
     * @var float
     */
    protected $exchangeRate;

    /**
     * @return Currency
     */
    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }

    /**
     * @return float
     */
    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    /**
     * @param float $exchangeRate
     * @return $this
     */
    public function setExchangeRate(float $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

}