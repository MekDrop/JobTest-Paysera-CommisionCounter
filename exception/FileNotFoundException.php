<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:45 PM
 */

namespace App\Exception;


class FileNotFoundException extends \Exception
{

    /**
     * FileNotFoundException constructor.
     *
     * @param string         $file      Bad file
     * @param Exception|null $previous  Previous error
     */
    public function __construct($file, Exception $previous = null)
    {
        parent::__construct(sprintf('File "%s" not found.', $file), 0, $previous);
    }

}