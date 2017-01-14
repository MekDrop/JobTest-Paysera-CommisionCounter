<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:45 PM
 */

namespace App\Exception;


class FileNotReadableException extends \Exception
{

    /**
     * FileNotReadableException constructor.
     *
     * @param string         $file      Bad file
     * @param Exception|null $previous  Previous error
     */
    public function __construct($file, Exception $previous = null)
    {
        parent::__construct(sprintf('File "%s" is not readable', $file), 0, $previous);
    }

}