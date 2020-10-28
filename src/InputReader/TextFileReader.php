<?php

namespace InputReader;

use Generator;
use InputReader\Exceptions\IncorrectFileHandle;

class TextFileReader implements Reader
{
    /**
     * @var string
     */
    private $delimeter = ';';

    /**
     * @var string
     */
    private $filename;

    /**
     * TextFileReader constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;

    }

    /**
     * @return Generator|array
     * @throws IncorrectFileHandle
     */
    public function read()
    {
        $handle = fopen($this->filename, "r");
        $inputLine = 1;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = explode($this->delimeter, $line);
                yield $data;
                $inputLine++;
            }

            fclose($handle);
        } else {
            throw new IncorrectFileHandle('Incorrect file handle');
        }
    }

}