<?php

namespace InputReader\Exceptions;

use Exception;

class IncorrectDataProvided extends Exception
{
    /**
     * @var array
     */
    private $validationErrors = [];
    /**
     * @var int
     */
    private $inputLine;

    /**
     * @param int $inputLine
     * @return $this
     */
    public function setLine(int $inputLine)
    {
        $this->inputLine = $inputLine;

        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setValidationErrors(array $errors)
    {
        $this->validationErrors = $errors;

        return $this;
    }

    /**
     * @return string
     */

    public function __toString()
    {
        $return = 'Incorrect data provided on input Line #' . $this->inputLine .PHP_EOL;
        foreach ($this->validationErrors as $error) {
            $return.= '> ' . $error . PHP_EOL;
        }

        return $return;
    }



}