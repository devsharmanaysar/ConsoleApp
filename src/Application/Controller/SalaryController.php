<?php

/**
 * Created by Devendra Dadheech.
 * User: Dev D
 * Date: 21-Feb-2020
 * Time: 15:51
 */
namespace ConsoleApp; 
use App\util\MissedStrategy;
use App\Service\Payday;
    class SalaryController
    {
        public function runCommand(array $argv)
        {
            $dayOfSalary = 't'; // t is last day of month
            $dayOfBonus = '15'; // default bonus date of every month 
            $paydaySalaryMissedStrategy = MissedStrategy::LastFriday;
            $paydayBonusMissedStrategy = MissedStrategy::NextWednesday;
            $dateFormat = 'd-m-Y';
            // get current month
            $thisMonth  = date('n');
            $filename = 'FinalResult/paydates.csv';
            $filepath = __DIR__ . '/../../'.$filename ;
            // create/open the file from given location
            $file =  fopen($filepath, 'w+');
            $header = ['month','salary payday','bonus payday'];
             // insert default header in csv file
             fputcsv($file,  $header ); // headers for csv
             $payDayObj = new Payday();
        try {
            // run the loop for remaining months
            for ($month = $thisMonth; $month <= 12; $month++) {
                // get the pay day of  salary 
                $paydaySalary =$payDayObj->getPaydayForMonth($month, $dayOfSalary, $paydaySalaryMissedStrategy);
               // get the pay day of bonus 
                $paydayBonus = $payDayObj->getPaydayForMonth($month, $dayOfBonus, $paydayBonusMissedStrategy);
                $monthName = date("F", mktime(0, 0, 0, $month)); 
                $paydaySalaryFormatted = $paydaySalary == null ? $paydaySalary : date($dateFormat, $paydaySalary);
                $paydayBonusFormatted = $paydayBonus == null ? $paydayBonus : date($dateFormat, $paydayBonus);
                $csvData = [$monthName, $paydaySalaryFormatted, $paydayBonusFormatted];
                fputcsv($file, $csvData);
            }
            fclose($file);
            }catch (Throwable $t) {
                return  $t->getMessage();
            }
        }
    }



?>