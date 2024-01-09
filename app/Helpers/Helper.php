<?php 

namespace App\Helpers;

class Helper {
    public static function generateID($prevID, $length)
    {;
        preg_match('/([A-Z]+)-(\d+)/', $prevID, $matches);
        $prefix = $matches[1];
        $number = intval($matches[2]);
        $number++;

        $value = "%0".$length."d";
        $newNumber = sprintf($value, $number);
        $newID = $prefix . '-' . $newNumber;
        
        return $newID;
    }
}