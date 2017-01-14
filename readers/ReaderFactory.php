<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:10 PM
 */

namespace App\Readers;


use App\Exception\BadReaderClassException;
use App\Exception\FileNotFoundException;
use App\Exception\FileNotReadableException;
use App\Exception\ReaderNotFoundException;

final class ReaderFactory
{

    /**
     * Make reader for filename
     *
     * @param string $filename File to load
     *
     * @return ReaderInterface
     *
     * @throws ReaderNotFoundException
     */
    public static function createForFile($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!file_exists($filename)) {
            throw new FileNotFoundException($filename);
        }

        if (!is_readable($filename)) {
            throw new FileNotReadableException($filename);
        }

        $class = '\\App\\Readers\\' . ucfirst(strtolower($ext)) . 'Reader';
        if (!class_exists($class)) {
            throw new ReaderNotFoundException($ext);
        }

        $instance = new $class();
        if (!($instance instanceof ReaderInterface)) {
            throw new BadReaderClassException($ext);
        }

        $instance->open($filename);

        return $instance;
    }

    /**
     * ReaderFactory constructor.
     *
     * Defined as private just to be hidden from outside
     */
    private function __construct() {

    }

}