<?php
declare(strict_types=1);

/**
 * Created by Devendra Dadheech.
 * User: Dev D
 * Date: 21-Feb-2020
 * Time: 15:51
 */

namespace App\Service;

use App\util\Util;

class Payday
{

    private $startDate;

    public function __construct(int $startDate = null)
    {
        // TODO I have no idea how to autowire a construct param :: trick with null
        $this->startDate = $startDate ?? Util::strtotime('today');
    }

    public function getStartDate(){
        return $this->startDate;
    }

    /**
     * find the last date of month for salary pay
     * int month
     * str $day of pay 
     * output datetime 
     */
    public function getPaydayForMonth(int $month, String $dayOfPay, String $missedStrategy) : ?int
    {
        $today = $this->startDate;
        $firstOfMonth = Util::strtotime(date('Y',$today)."-$month-1");
       
        $payday = Util::strtotime(date("Y-$month-$dayOfPay", $firstOfMonth));

        if($payday < $today) return null;
        switch (date('N', $payday)) {
            case 6:
            case 7:
                // weekend
                $payday = Util::strtotime($missedStrategy, $payday);
                if($payday < $today) return null; //check that the date is in future 
                break;
        }
       
        if(date("Y",$payday) > date("Y",$today)) return null;
        return $payday;
    }
}
