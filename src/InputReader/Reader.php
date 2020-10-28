<?php

namespace InputReader;

use Generator;

interface Reader
{
    /**
     * @return Generator|array
     */
    public function read();
}
