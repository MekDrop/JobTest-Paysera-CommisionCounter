<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:28 PM
 */

namespace App\Exception;


class BadWriterClassException extends \Exception
{
    /**
     * BadWriterClassException constructor.
     *
     * @param string         $writer_class_name Bad Writer class name
     * @param Exception|null $previous          Previous error
     */
    public function __construct($writer_class_name, Exception $previous = null)
    {
        parent::__construct(sprintf('Bad writer %s was specified in config file.', $writer_class_name), 0, $previous);
    }
}