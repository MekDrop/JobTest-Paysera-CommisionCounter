<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:58 PM
 */

namespace App\Writers;


interface WriterInterface
{

    /**
     * Line to write
     *
     * @param mixed $line data to write
     *
     * @return mixed
     */
    public function writeln($line);

}