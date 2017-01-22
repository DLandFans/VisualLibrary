<?php

namespace App;

class INFX
{
    private static $per_page = 10;
    private static $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    private static $sun = ['Reflected Sun', 'Full Sun', 'Partial Sun', 'Partial Shade', 'Full Shade'];

    public static function perPage() { return self::$per_page; }
    public static function months() { return self::$months; }
    public static function sun() { return self::$sun; }

    public static function IsNullOrEmptyString($test)
    {
        return (!isset($test) || trim($test)==='' || $test == null);
    }

    //Takes an array and makes them into a comma separated list
    public static function buildList($listItems, $clause = null)
    {
        $count = count($listItems);
        if($count <= 0) return "";
        if($count == 1) return $listItems[0];
        if($count == 2)
        {
            if($clause == null) return $listItems[0] . ", " . $listItems[1];
            return $listItems[0] . " " . $clause . " " . $listItems[1];
        }

        $counter = 0;
        $returnList = "";
        foreach($listItems as $item)
        {
            $counter++;
            $returnList .= $item;
            if ($counter != $count) $returnList .= ", ";
            if ($counter == $count-1) $returnList .= $clause . " ";
        }
        return $returnList;
    }

    //Takes and array and filters it based on a bitwise operator
    public static function makeList($listItems, $bitwise)
    {
        $base = 0;
        $returnMonths = [];
        while (pow(2,$base) < $bitwise)
        {
            if($bitwise&pow(2,$base)) array_push($returnMonths, $listItems[$base]);
            $base++;
        }
        return $returnMonths;
    }

    //Convert a double to feet and inches (i.e. 7'-6")
    public static function toFeetAndInches($num)
    {
        $returnNum = null;
        $num = round($num, 4);
        if(floor($num) > 0) $returnNum = floor($num) . "'";

        if(floor($num) <> $num ) {
            if (!$returnNum == null)
                $returnNum .= "-";
            else
                $returnNum = "";

            $partial = round(($num-floor($num)),4);

            switch($partial)
            {
                case 0.0833:
                    $returnNum .= "1\"";
                    break;
                case 0.1667:
                    $returnNum .= "2\"";
                    break;
                case 0.2500:
                    $returnNum .= "3\"";
                    break;
                case 0.3333:
                    $returnNum .= "4\"";
                    break;
                case 0.4167:
                    $returnNum .= "5\"";
                    break;
                case 0.5000:
                    $returnNum .= "6\"";
                    break;
                case 0.5833:
                    $returnNum .= "7\"";
                    break;
                case 0.6667:
                    $returnNum .= "8\"";
                    break;
                case 0.7500:
                    $returnNum .= "9\"";
                    break;
                case 0.8333:
                    $returnNum .= "10\"";
                    break;
                case 0.9167:
                    $returnNum .= "11\"";
                    break;
                default:
                    $returnNum = $num . "'";
            }
        }

        return $returnNum;
    }

}

