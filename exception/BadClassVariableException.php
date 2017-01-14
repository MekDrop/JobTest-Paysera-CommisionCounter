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
     * @param string         $variable  Bad variable
     * @param object|string  $class     Class or object
     * @param Exception|null $previous  Previous error
     */
    public function __construct($variable, $class, \Exception $previous = null)
    {
        parent::__construct(sprintf('"%s" variable for "%s" class not set', $variable, is_object($class)?get_class($class):null), 0, $previous);
    }

}