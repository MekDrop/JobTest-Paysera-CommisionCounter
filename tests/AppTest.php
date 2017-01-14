<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/14/2017
 * Time: 10:01 PM
 */

namespace Tests;


use App\Enum\CashFlowType;
use App\Enum\UserType;

class AppTest extends \PHPUnit_Framework_TestCase
{

    public function testApp() {
        // Here should be a test to verify but i'm too lazy to write
    }

    /**
     * Generates users list
     *
     * @param int $users_count Users count
     *
     * @return array
     */
    protected function generateUsersList($users_count) {
        $users = [];
        $types = UserType::getValues();
        $ctype = count($types) - 1;
        for($i = 0; $i < $users_count; $i++) {
            $users[$i + 1] = $types[mt_rand(0, $ctype)];
        }
        return $users;
    }

    /**
     * Generates CSV
     *
     * @param int $lines_count Transaction count in file
     * @param int $users_count Users count in file
     *
     * @return string
     */
    protected function generateCSV($lines_count, $users_count) {
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sha1(microtime(true)) . '.csv';
        $fp = fopen($file, 'w');
        $users = $this->generateUsersList($users_count);
        $cash_flows = CashFlowType::getValues();
        $ccash_flows = count($cash_flows) - 1;
        $config = require(dirname( __DIR__) . DIRECTORY_SEPARATOR . 'config.php');
        $currencies = array_keys($config['currencies']);
        $ccurrencies = count($currencies) - 1;
        for($i = 0; $i < $lines_count; $i++) {
            $uid =mt_rand(1, $users_count);
            fputcsv($fp, [
                date('Y-m-d', mt_rand(0, strtotime("+3 months"))),
                $uid,
                $users[$uid],
                $cash_flows[mt_rand(0, $ccash_flows)],
                number_format(mt_rand(1, PHP_INT_MAX), 2),
                $currencies[mt_rand(0, $ccurrencies)]
            ]);
        }
        fclose($fp);
        return $file;
    }

}
