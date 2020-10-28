<?php

namespace Exceptions;

use Exception;
use Product;

class NoCartItemToRemove extends Exception
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Error: There is no more of this item in Shopping Cart to remove. Tried to remove: ' . $this->product->getName();
    }
}