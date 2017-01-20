<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = [
        'genus_name',
        'specific_epithet',
        'variety_name',
        'cultivar_name',
        'hybrid_genus',
        'hybrid_epithet'
    ];

    protected $primaryKey = "plant_id";

    public static function botanicalName(Plant $plant)
    {
        if (self::IsNullOrEmptyString($plant->genus_name)  && self::IsNullOrEmptyString($plant->specific_epithet))
        {
            return "<<NO BOTANICAL NAME>>";
        }


        $plantname = "";

        //Genus Name
        if (!self::IsNullOrEmptyString($plant->genus_name)) $plantname .= ucfirst(strtolower($plant->genus_name));

        // Specific Epithet
        if (!self::IsNullOrEmptyString($plant->specific_epithet))
        {
            if($plantname != "") $plantname .= " ";
            $plantname .= strtolower($plant->specific_epithet);
        }

        // Hybrids
        if (!self::IsNullOrEmptyString($plant->hybrid_genus))
        {
            // Genus
            $plantname .= " x " . ucfirst(strtolower($plant->hybrid_genus));

            // Epithet
            if (!self::IsNullOrEmptyString($plant->hybrid_epithet))
                $plantname .= " " . strtolower($plant->hybrid_epithet);
        }

        // Variety
        if (!self::IsNullOrEmptyString($plant->variety_name)) $plantname .= " var. " . strtolower($plant->variety_name);

        // Cultivar
        if (!self::IsNullOrEmptyString($plant->cultivar_name)) $plantname .= " '" . ucwords(strtolower($plant->cultivar_name)) . "'";

        // Trademark
        if ($plant->trademarked) $plantname .= " tm";

        return $plantname;
    }

    private static function IsNullOrEmptyString($test)
    {
        return (!isset($test) || trim($test)==='');
    }

}
