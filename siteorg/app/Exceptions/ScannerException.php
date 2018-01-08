<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 08.06.2017
 * Time: 14:09
 */

namespace App\Exceptions;


class ScannerException extends \Exception
{
    private $error;

    public function __construct($error)
    {
        $this->error = $error;
        parent::__construct($error);
    }

    public function getError()
    {
        $this->error;
    }
}