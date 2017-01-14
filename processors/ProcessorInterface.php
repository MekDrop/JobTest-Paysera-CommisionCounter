<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:54 PM
 */

namespace App\Processors;

use App\Writers\WriterInterface;

interface ProcessorInterface
{

    /**
     * Execute processor
     *
     * @param string $filename Source file
     */
    public function execute($filename);

    /**
     * Sets writer
     *
     * @param WriterInterface $writer Writer to use for this processor
     *
     * @return $this
     */
    public function setWriter(WriterInterface $writer);

    /**
     * Returns if writer is set
     *
     * @return boolean
     */
    public function hasWriter();

    /**
     * Sets config from array
     *
     * @param array $config Config to set
     *
     * @return $this
     */
    public function setConfig(array $config);

    /**
     * Set currencies data
     *
     * @param array $currencies Currencies data
     *
     * @return $this
     */
    public function setCurrenciesData(array $currencies);

}