<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:15 PM
 */

namespace App\Exception;


class ReaderNotFoundException extends \Exception
{

    /**
     * ReaderNotFoundException constructor.
     *
     * @param string         $ext       Bad extension
     * @param Exception|null $previous  Previous error
     */
    public function __construct($ext, Exception $previous = null)
    {
        parent::__construct(sprintf('Reader for %s extensions not found', $ext), 0, $previous);
    }

}