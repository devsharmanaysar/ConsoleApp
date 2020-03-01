<?php
declare(strict_types=1);

/**
 * Created by Devendra Dadheech.
 * User: Dev D
 * Date: 21-Feb-2020
 * Time: 15:51
 */
namespace App\Util;
class Util
{
    static function unFalsify( string $errorMsg, Callable $callback, array $args) {
        $val = call_user_func_array($callback, $args);
        if($val === false) throw  $errorMsg ;
        return $val;
    }
    static function strtotime( string $time, ?int $now = null) : int {
        return self::unFalsify("not a valid date. received: $time",'strtotime', [$time, $now ?? time()]); // if now is null then time
    }
}