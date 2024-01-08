<?php 

namespace App\Helpers;

class Helper {
    public static function generateID($prevID)
    {;
        preg_match('/([A-Z]+)-(\d+)/', $prevID, $matches);
        $prefix = $matches[1];
        $number = intval($matches[2]);
        $number++;

        $newNumber = sprintf('%02d', $number);
        $newID = $prefix . '-' . $newNumber;
        
        return $newID;
    }
}