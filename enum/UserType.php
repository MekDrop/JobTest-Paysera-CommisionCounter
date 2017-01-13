<?php

namespace App\Enum;

use Pulyaevskiy\Enum\Enum;

/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 4:51 PM
 */
class UserType extends Enum
{
    /**
     * Individual
     */
    const INDIVIDUAL = 'natural';

    /**
     * Juridic user type
     */
    const JURIDICAL = 'juridical';
}