<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 5:20 PM
 */

namespace App\Exception;


class BadClassVariableException extends \Exception
{


    /**
     * BadClassVariableException constructor.
     *
     * @param string $variable
     * @param object|class $class
     *
     * @param Exception $previous
     */
    public function __construct($variable, $class, Exception $previous)
    {
        parent::__construct(sprintf('"%s" variable for "%s" class not set', $variable, is_object($class)?get_class($class):null), 0, $previous);
    }

}