<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:28 PM
 */

namespace App\Exception;


class BadProcessorClassException extends \Exception
{
    /**
     * BadProcessorClassException constructor.
     *
     * @param string         $processor_class_name       Bad extension
     * @param Exception|null $previous                   Previous error
     */
    public function __construct($processor_class_name, Exception $previous = null)
    {
        parent::__construct(sprintf('Bad processor %s was specified in config file.', $processor_class_name), 0, $previous);
    }
}