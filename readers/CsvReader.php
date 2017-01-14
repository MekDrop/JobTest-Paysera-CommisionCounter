<?php

namespace App\Readers;

use App\Models\Transaction;
use League\Csv\AbstractCsv;
use League\Csv\Reader;

/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:09 PM
 */
class CsvReader implements ReaderInterface
{
    /**
     * Csv reader instance
     *
     * @var null|Reader
     */
    protected $reader = null;

    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @inheritDoc
     */
    public function open($filename)
    {
        $this->reader = Reader::createFromPath($filename);
        $this->reset();
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $this->reader = null;
    }

    /**
     * @inheritDoc
     */
    public function isOpened()
    {
        return is_object($this->reader) && ($this->reader instanceof AbstractCsv);
    }

    /**
     * @inheritDoc
     */
    public function fetchRow()
    {
        $row = $this->reader->fetchOne($this->index++);
        if (empty($row)) {
            return null;
        }
        return new Transaction(array_combine([
            'date',
            'user_id',
            'user_type',
            'operation_type',
            'sum',
            'currency'
        ],$row));
    }

    /**
     * @inheritDoc
     */
    public function reset()
    {
        $this->index = 0;
    }
}