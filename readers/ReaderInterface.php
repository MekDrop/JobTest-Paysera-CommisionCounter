<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:11 PM
 */

namespace App\Readers;


use App\Models\Transaction;

interface ReaderInterface
{
    /**
     * Open file
     *
     * @param string $filename File to load
     */
    public function open($filename);

    /**
     * Close opened file
     */
    public function close();

    /**
     * Is anything opened with this reader?
     *
     * @return boolean
     */
    public function isOpened();

    /**
     * Fetch next result
     *
     * @return null|Transaction
     */
    public function fetchRow();

    /**
     * Resets reading cursor
     */
    public function reset();
}