<?php

namespace InputReader\Exceptions;

use Exception;

class IncorrectFileHandle extends Exception
{
    protected $message = 'Incorrect file handle';

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class() . ' Exception caught: ' . $this->getMessage();
    }
}