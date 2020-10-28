<?php
require_once __DIR__ . '/vendor/autoload.php';

use InputReader\TextFileReader;
use Validator\InputValidator;

class App
{
    public function run()
    {
        try {
            $reader = new TextFileReader("input.txt");
            $cart = new Cart();
            $inputValidator = new InputValidator($cart);

            foreach($reader->read() as $line => $data) {
                $inputValidator->validate($data, $line);
                $product = new Product($data);
                $cart->process($product);
                echo 'Total: ' . $cart->getTotal() . $cart->getDefaultCurrency()->getCode() . PHP_EOL;

            }
        } catch (Exception $e) {
            print $e.PHP_EOL;
        }

    }
}

(new App())->run();