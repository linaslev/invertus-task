<?php

namespace Validator;

use Cart;
use InputReader\Exceptions\IncorrectDataProvided;

class InputValidator
{
    /**
     * @var array
     */
    private $validationErrors = [];

    /**
     * @var Cart
     */
    private $cart;

    /**
     * InputValidator constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @param array $data
     * @param int $line
     * @return bool
     */
    public function validate(array $data, int $line)
    {
        $this->isProductIdValid($data[0]);
        $this->isProductNameValid($data[1]);
        $this->isProductQuantityValid($data[2]);

        // We don't need to check price and currency for negative quantities
        if ($data[2] > 0) {
            $this->isProductPriceValid($data[3]);
            $this->isProductCurrencyValid($data[4]);
        }

        // Throw an Exception if Validation errors found
        if (!empty($this->validationErrors)) {
            throw (new IncorrectDataProvided())->setValidationErrors($this->validationErrors)->setLine($line);
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    private function isProductIdValid($id)
    {
        if (empty($id)) {
            $this->validationErrors[] = 'Unique product identifier is not set';
            return false;
        }

        return true;
    }

    /**
     * @param $name
     * @return bool
     */
    private function isProductNameValid($name)
    {
        if (empty($name)) {
            $this->validationErrors[] = 'Product name is not set';
            return false;
        }

        return true;
    }

    /**
     * @param $quantity
     * @return bool
     */
    private function isProductQuantityValid($quantity)
    {
        if (empty($quantity)) {
            $this->validationErrors[] = 'Product quantity is not set';
            return false;
        } else {
            if ($quantity != (integer) $quantity) {
                $this->validationErrors[] = 'Product quantity is not integer type. Provided value: ' . $quantity;
                return false;
            }
            if ($quantity === 0) {
                $this->validationErrors[] = 'Product quantity value is 0, which is not assigned an action';
                return false;
            }
        }

        return true;
    }

    /**
     * @param $price
     * @return bool
     */
    private function isProductPriceValid($price)
    {
        if (empty($price)) {
            $this->validationErrors[] = 'Product price is not set';
            return false;
        } else {
            if (!is_numeric($price)) {
                $validationErrors[] = 'Product price is not numeric. Provided value: ' . $price;
                return false;
            }
            if ($price < 0) {
                $validationErrors[] = 'Product price is negative. Provided value: ' . $price;
                return false;
            }
        }

        return true;
    }

    /**
     * @param $currency
     * @return bool
     */
    private function isProductCurrencyValid($currency)
    {
        if (empty($currency)) {
            $this->validationErrors[] = 'Product currency is not set';
            return false;
        } else {
            $currencyClassName = 'Currencies\\' . ucfirst(strtolower(trim($currency)));
            if (!class_exists($currencyClassName)) {
                $this->validationErrors[] = 'Unsupported currency provided. Provided value: ' . $currency;
                return false;
            } else {
                // Checks if currency is included in Cart currencies
                $currencyClass = $currencyClassName::getInstance();
                if (!(bool) array_filter($this->cart->getCurrencies(), function($currency) use ($currencyClass) {
                    return $currencyClass === $currency;
                })) {
                    $this->validationErrors[] = 'Unsupported currency provided. Provided value: ' . $currency;
                    return false;
                }
            }
        }

        return true;
    }
}