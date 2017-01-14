<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:28 PM
 */

namespace App\Exception;


class BadReaderClassException extends \Exception
{
    /**
     * BadReaderClassException constructor.
     *
     * @param string         $ext       Bad extension
     * @param Exception|null $previous  Previous error
     */
    public function __construct($ext, Exception $previous = null)
    {
        parent::__construct(sprintf('Bad reader for %s extension was found. Aborting.', $ext), 0, $previous);
    }
}