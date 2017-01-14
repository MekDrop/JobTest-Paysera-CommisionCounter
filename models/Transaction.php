<?php

namespace App\Models;

use App\Enum\CashFlowType;
use App\Enum\UserType;
use App\Exception\BadClassVariableException;
use App\Exception\BadCurrencyNameValueLengthException;
use App\Exception\BadTransactionDateException;

/**
 * Class Transaction
 *
 * @package App\Objects
 *
 * @property-read string        $date           Transaction date
 * @property-read int           $user_id        User ID
 * @property-read UserType      $user_type      User type
 * @property-read CashFlowType  $operation_type Operation type
 * @property-read float         $sum            How much?
 * @property-read string        $currency       Currency name
 */
class Transaction {

    /**
     * Transaction date
     *
     * @var string
     */
    private $date;

    /**
     * User ID
     *
     * @var int
     */
    private $user_id;

    /**
     * User type
     *
     * @var UserType
     */
    private $user_type;

    /**
     * Operation type
     *
     * @var CashFlowType
     */
    private $operation_type;

    /**
     * How much?
     *
     * @var float
     */
    private $sum;

    /**
     * Currency name
     *
     * @var string
     */
    private $currency;

    /**
     * Makes class variables read-only
     *
     * @param string $name Variable name
     *
     * @return mixed
     *
     * @throws BadClassVariableException
     */
    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            throw new BadClassVariableException($name, $this);
        }
    }

    /**
     * Transaction constructor.
     *
     * @param array $data Input data
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $name = 'clean' . implode('', array_map('ucfirst', explode('_', $key)));
            $this->$key = $this->$name($value);
        }
    }

    /**
     * Clean date
     *
     * @param string $date Date to clean
     *
     * @return string
     *
     * @throws BadTransactionDateException
     */
    protected function cleanDate($date) {
        if ($date instanceof \DateTime) {
            return $date->format('Y-m-d');
        } elseif (is_string($date)) {
            return date('Y-m-d', strtotime($date));
        }
        throw new BadTransactionDateException($date);
    }

    /**
     * Clean user id
     *
     * @param mixed $user_id User id
     *
     * @return int
     */
    protected function cleanUserId($user_id) {
        return (int)$user_id;
    }

    /**
     * Clean user type
     *
     * @param mixed $user_type User type to filter
     *
     * @return UserType
     */
    protected function cleanUserType($user_type) {
        if ($user_type instanceof UserType) {
            return $user_type;
        }
        return UserType::fromValue($user_type);
    }

    /**
     * Cleans operation type
     *
     * @param mixed $operation_type Operation type to filter
     *
     * @return CashFlowType
     */
    protected function cleanOperationType($operation_type) {
        if ($operation_type instanceof CashFlowType) {
            return $operation_type;
        }
        return CashFlowType::fromValue($operation_type);
    }

    /**
     * Clean sum value
     *
     * @param mixed $sum Sum to clean
     *
     * @return float
     */
    protected function cleanSum($sum) {
        return (float)$sum;
    }

    /**
     * Clean currency name
     *
     * @param mixed $currency Currency to clean
     *
     * @return string
     *
     * @throws BadCurrencyNameValueLengthException
     */
    protected function cleanCurrency($currency) {
        if (strlen($currency) != 3) {
            throw new BadCurrencyNameValueLengthException();
        }
        return strtoupper($currency);
    }

    /**
     * Gets user hash for transaction
     *
     * @return string
     */
    public function getUserHash() {
        return $this->user_type . ';' . $this->user_id;
    }

    /**
     * Gets week no for transaction
     *
     * @return string
     */
    public function getWeekNo() {
        return date("W", strtotime($this->date));
    }

}