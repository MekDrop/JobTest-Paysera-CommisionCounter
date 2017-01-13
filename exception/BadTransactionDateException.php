<?php

namespace App\Exception;

/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 5:15 PM
 */
class BadTransactionDateException extends \Exception
{

    /**
     * BadTransactionDateException constructor.
     *
     * @param string $date
     * @param Exception $previous
     */
    public function __construct($date, Exception $previous)
    {
        parent::__construct(sprintf('Bad date "%s"', addslashes(var_export($date, true))), 0, $previous);
    }

}