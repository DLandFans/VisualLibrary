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
        if (INFX::IsNullOrEmptyString($plant->genus_name)  && INFX::IsNullOrEmptyString($plant->specific_epithet))
        {
            return "<<NO BOTANICAL NAME>>";
        }

        $plantname = "";

        //Genus Name
        if (!INFX::IsNullOrEmptyString($plant->genus_name)) $plantname .= ucfirst(strtolower($plant->genus_name));

        // Specific Epithet
        if (!INFX::IsNullOrEmptyString($plant->specific_epithet))
        {
            if($plantname != "") $plantname .= " ";
            $plantname .= strtolower($plant->specific_epithet);
        }

        // Hybrids
        if (!INFX::IsNullOrEmptyString($plant->hybrid_genus))
        {
            // Genus
            $plantname .= " x " . ucfirst(strtolower($plant->hybrid_genus));

            // Epithet
            if (!INFX::IsNullOrEmptyString($plant->hybrid_epithet))
                $plantname .= " " . strtolower($plant->hybrid_epithet);
        }

        // Variety
        if (!INFX::IsNullOrEmptyString($plant->variety_name)) $plantname .= " var. " . strtolower($plant->variety_name);

        // Cultivar
        if (!INFX::IsNullOrEmptyString($plant->cultivar_name)) $plantname .= " '" . ucwords(strtolower($plant->cultivar_name)) . "'";

        // Trademark
        if ($plant->trademarked) $plantname .= " tm";

        return $plantname;
    }

    public static function leafDrop(Plant $plant)
    {
        $bw = $plant->leaf_drop_bw;
        $returnVal = null;

        if (INFX::IsNullOrEmptyString($bw) || $bw == 0) return $returnVal;

        if ($bw&1) $returnVal = "Evergreen";

        if ($bw&2 && $returnVal == null)
            $returnVal = "Semi-Deciduous";
        elseif ($bw&2 && !($bw&4))
            $returnVal .= " to Semi-Deciduous";

        if ($bw&4 && $returnVal == null)
            $returnVal = "Deciduous";
        elseif ($bw&4)
            $returnVal .= " to Deciduous";

        return $returnVal;
    }

}
