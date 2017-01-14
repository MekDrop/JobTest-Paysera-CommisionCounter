<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:57 PM
 */

namespace App\Writers;


class StdoutWriter implements WriterInterface
{

    /**
     * @inheritDoc
     */
    public function writeln($line)
    {
        fwrite(STDOUT, $line . PHP_EOL);
    }
}