<?php

use Currencies\Currency;
use Currencies\Eur;
use Currencies\Gbp;
use Currencies\Usd;
use Exceptions\NoCartItemToRemove;

class Cart
{
    /**
     * @var Product[]
     */
    private $cart = [];

    /**
     * @var Currency
     */
    private $defaultCurrency;

    /**
     * @var Currency[]
     */
    private $currencies = [];

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->defaultCurrency = Eur::getInstance();

        $this->currencies = [
            Eur::getInstance()->setExchangeRate(1),
            Usd::getInstance()->setExchangeRate(1.14),
            Gbp::getInstance()->setExchangeRate(0.88)
        ];
    }

    /**
     * @param Product $product
     * @throws NoCartItemToRemove
     */
    public function process(Product $product)
    {
        if ($product->getQuantity() >= 1) {
            $this->add($product);
        } elseif ($product->getQuantity() <= -1) {
            $this->remove($product);
        }
    }

    /**
     * Adds a Product to cart array
     * @param Product $product
     */
    private function add(Product $product)
    {
        $this->cart[] = $product;
    }

    /**
     * Removes the last product from the cart array
     * @param Product $product
     * @throws NoCartItemToRemove
     */
    private function remove(Product $product)
    {
        for($i = 0; $i < abs($product->getQuantity()); $i++) {
            $itemToRemoveFound = false;
            $cart = $this->getCart();
            /**
             * @var integer $key
             * @var Product $item
             */
            foreach (array_reverse($cart, true) as $key => &$item)
            {
                if ($item->getId() === $product->getId()) {
                    $item->setQuantity($item->getQuantity() - 1);
                    if ($item->getQuantity() == 0) {
                        array_splice($cart, $key, $key);
                    }
                    $this->setCart($cart);
                    $itemToRemoveFound = true;
                    break;
                }
            }

            if (!$itemToRemoveFound) {
                throw (new NoCartItemToRemove())->setProduct($product);
            }
        }
    }

    /**
     * @return float|int
     */
    public function getTotal()
    {
        $total = 0;
        foreach($this->getCart() as $product)
        {
            $price = floor(($product->getPrice() * $product->getQuantity()) / $product->getCurrency()->getExchangeRate() * 100) / 100;

            $total += $price;
        }

        return $total;
    }

    /**
     * @param $cart
     */
    private function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return Product[]
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return Currency
     */
    public function getDefaultCurrency(): Currency
    {
        return $this->defaultCurrency;
    }

    /**
     * @return Currency[]
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

}