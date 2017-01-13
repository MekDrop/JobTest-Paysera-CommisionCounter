<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/13/2017
 * Time: 4:59 PM
 */

namespace App\Enum;

use Pulyaevskiy\Enum\Enum;

class CashFlowType extends Enum
{

    /**
     * Cash in
     */
    const IN = 'cash_in';

    /**
     * Cash out
     */
    const OUT = 'cash_out';

}