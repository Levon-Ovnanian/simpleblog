<?php 
namespace MyProject\Services;

use DateTime;

class DateCounter
{
    /**
     * 
     * 
     *
     * @param array $targets
     * @return void
     */
    public static function getDifference(array $targets, $properties): ?array 
    {
        $origin = new DateTime('now');
        $array = [];   
        foreach($targets as $target) {
            $targetTime = new DateTime($target->$properties());
            $interval = $origin->diff($targetTime);
            $array[] = explode(':', $interval->format('%y:%m:%d:%h:%i:%a'));   
        }
        return $array;
    }
}