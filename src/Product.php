<?php

use Currencies\Currency;

class Product
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var integer
     */
    private $quantity;
    /**
     * @var float
     */
    private $price;
    /**
     * @var Currency
     */
    private $currency;

    /**
     * Product constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setId($data[0]);
        $this->setName($data[1]);
        $this->setQuantity($data[2]);

        // We don't need to set price and currency for negative quantities
        if ($data[2] > 0) {
            $this->setPrice($data[3]);

            $className = 'Currencies\\' . ucfirst(strtolower(trim($data[4])));
            $currency = $className::getInstance();
            $this->setCurrency($currency);
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }
}