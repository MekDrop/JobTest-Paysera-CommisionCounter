<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 11:53 PM
 */

namespace App\Processors;


use App\Enum\CashFlowType;
use App\Enum\UserType;
use App\Readers\ReaderFactory;
use App\Writers\WriterInterface;

class DefaultProcessor implements ProcessorInterface
{
    /**
     * Linked writer
     *
     * @var null|WriterInterface
     */
    protected $writer = null;

    /**
     * Configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * Currencies data
     *
     * @var array
     */
    protected $currencies = [];

    /**
     * @inheritDoc
     */
    public function execute($filename)
    {
        $reader = ReaderFactory::createForFile($filename);
        $tmp_data = [];
        while($transaction = $reader->fetchRow()) {
            $week_no = $transaction->getWeekNo();
            $real_value = $this->convertToDefaultCurrency($transaction->sum, $transaction->currency);
            $user_hash = $transaction->getUserHash() . ';' . $transaction->operation_type->getValue();
            $tmp_data[$user_hash][$week_no][] = $real_value;
            $free_week_value = $this->calcFreeWeekValue(
                $transaction->operation_type,
                $transaction->user_type,
                $tmp_data[$user_hash][$week_no]
            );
            $commission = $this->calcDefaultCommision(
                $transaction->operation_type,
                $transaction->user_type,
                $free_week_value
            );
            $commission = $this->calcMinCommission(
                $transaction->operation_type,
                $transaction->user_type,
                $commission
            );
            $commission = $this->calcMaxCommission(
                $transaction->operation_type,
                $transaction->user_type,
                $commission
            );
            if ($this->hasWriter()) {
                $this->writer->writeln( number_format($commission, 2));
            }
        }
    }

    /**
     * Calculate max commission
     *
     * @param CashFlowType  $cash_flow  Cash flow type
     * @param UserType $user_type   User type
     * @param float $value          Value
     *
     * @return float
     */
    protected function calcMaxCommission(CashFlowType $cash_flow, UserType $user_type, $value) {
        $calculated = $this->calcByConfigValue($value, $cash_flow, $user_type, 'max_commision', true);
        if ($calculated != 0 && $value > $calculated) {
            return $calculated;
        }
        return $value;
    }

    /**
     * Calculate min commission
     *
     * @param CashFlowType  $cash_flow  Cash flow type
     * @param UserType $user_type   User type
     * @param float $value          Value
     *
     * @return float
     */
    protected function calcMinCommission(CashFlowType $cash_flow, UserType $user_type, $value) {
        $calculated = $this->calcByConfigValue($value, $cash_flow, $user_type, 'min_commision', true);
        if ($calculated != 0 && $value < $calculated) {
            return $calculated;
        }
        return $value;
    }

    /**
     * Calculate default commission
     *
     * @param CashFlowType  $cash_flow  Cash flow type
     * @param UserType $user_type   User type
     * @param float $value          Value
     *
     * @return float
     */
    protected function calcDefaultCommision(CashFlowType $cash_flow, UserType $user_type, $value) {
        if ($value > 0) {
            return $this->calcByConfigValue($value, $cash_flow, $user_type, 'default_commission');
        }
        return 0.0;
    }

    /**
     * Calculate free week value
     *
     * @param CashFlowType  $cash_flow  Cash flow type
     * @param UserType $user_type       User type
     * @param array $user_transactions  User transactions list
     *
     * @return float
     */
    protected function calcFreeWeekValue(CashFlowType $cash_flow, UserType $user_type, array &$user_transactions) {
        $utype = $user_type->getValue();
        $cflash = $cash_flow->getValue();
        $count = count($user_transactions);
        $max = $this->config[$utype][$cflash]['free_per_week']['op_count'];
        if ($max >= $count) {
            $all_sum = array_sum($user_transactions);
            $val = $this->calcByConfigValue($all_sum, $cash_flow, $user_type, 'free_per_week');
            if ($val > 0) {
                return 0.0;
            } else {
                for($i=$count; $i < $max; $i++) {
                    $user_transactions[] = 0;
                }
                return -$val;
            }
        }
        return $user_transactions[count($user_transactions) - 1];
    }

    /**
     * Calculate by config value
     *
     * @param float         $value      Value to use in calculations
     * @param CashFlowType  $cash_flow  Cash flow type
     * @param UserType      $user_type  User type
     * @param string        $cfg_cat    Config category
     * @param bool          $reto       Return only value
     *
     * @return float
     */
    protected function calcByConfigValue($value, CashFlowType $cash_flow, UserType $user_type, $cfg_cat, $reto = false) {
        $utype = $user_type->getValue();
        $cflash = $cash_flow->getValue();
        return $this->calcRealValue(
            $value,
            $this->config[$utype][$cflash][$cfg_cat]['value'],
            $this->config[$utype][$cflash][$cfg_cat]['percent'],
            $reto
        );
    }

    /**
     * Calculates real value
     *
     * @param float $value      Current value
     * @param float $teo_value  Teorectic value
     * @param bool $is_percent  Is teoretic value a percent
     * @param bool $retOnlyValue Return only value
     *
     * @return float
     */
    protected function calcRealValue($value, $teo_value, $is_percent, $retOnlyValue = false) {
        if ($is_percent) {
            return $value / (100 / $teo_value);
        } elseif ($retOnlyValue) {
            return $teo_value;
        } else {
            return $teo_value - $value;
        }
    }

    /**
     * Converts to default currency value
     *
     * @param float  $value     Value
     * @param string $currency  Currency to convert from
     *
     * @return mixed
     */
    protected function convertToDefaultCurrency($value, $currency) {
        return ceil($value / $this->currencies[$currency] * 100) / 100;
    }

    /**
     * @inheritDoc
     */
    public function setWriter(WriterInterface $writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCurrenciesData(array $currencies)
    {
        $this->currencies = [];
        foreach ($currencies as $name => $conversion_vs_eur) {
            $this->currencies[substr(strtoupper($name), 0, 3)] = $conversion_vs_eur;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasWriter()
    {
        return $this->writer !== null && $this->writer instanceof WriterInterface;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $config)
    {
        foreach (UserType::getValues() as $user_type) {
            $part = isset($config[$user_type])?$config[$user_type]:[];
            foreach (CashFlowType::getValues() as $cash_flow) {
                if (!isset($part[$cash_flow]) || !is_array($part[$cash_flow])) {
                    $part[$cash_flow] = [];
                }
                foreach (['default_commission', 'free_per_week', 'min_commision', 'max_commision'] as $group_name) {
                    if (!isset($part[$cash_flow][$group_name]) || !is_array($part[$cash_flow][$group_name])) {
                        $part[$cash_flow][$group_name] = [];
                    }
                    $part[$cash_flow][$group_name]['value'] = (!isset($part[$cash_flow][$group_name]['value'])) ? 0.00 : (float)$part[$cash_flow][$group_name]['value'];
                    $part[$cash_flow][$group_name]['percent'] = (!isset($part[$cash_flow][$group_name]['percent'])) ? false : (bool)$part[$cash_flow][$group_name]['percent'];
                    $part[$cash_flow][$group_name]['op_count'] = (!isset($part[$cash_flow][$group_name]['op_count'])) ? 0 : (int)$part[$cash_flow][$group_name]['op_count'];
                }
            }
            $this->config[$user_type] = $part;
        }

        return $this;
    }
}