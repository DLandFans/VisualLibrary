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

    protected $hidden = [
        'created_at', 'updated_at', 'pivot'
    ];

    protected $primaryKey = "plant_id";

    public function classifications() {
        return $this->belongsToMany('App\Classification', 'plant_classification', 'plant_id', 'class_id' )
            ->withTimestamps();
    }

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

    public static function sunExposure(Plant $plant)
    {
        $bw = $plant->sun_exposure;
        $returnVal = "";

        if (INFX::IsNullOrEmptyString($bw) || $bw == 0) return $returnVal;

        $base = 0;
        while ($base < 5)
        {
            if ($bw&pow(2,$base))
            {
                $spos = $base;
                $base = 5; //Kill loop since found
                $returnVal .= INFX::sun()[$spos];
            }
            $base++;
        }

        $base = 5;
        while ($base >= 0)
        {
            if ($bw&pow(2,$base))
            {
                $epos = $base;
                $base = 0; //Kill loop since found
                if ($epos != $spos)
                    $returnVal .= " to " . INFX::sun()[$epos];
            }
            $base--;
        }
        return $returnVal;
    }

    public static function plantClass($classes)
    {
        $items = [];
        foreach ($classes as $item) {
            array_push($items, $item->classification);
        }
        $returnList = INFX::buildList($items, "or");

        return $returnList;
    }

    public static function height(Plant $plant)
    {
        return self::spreadSize($plant->height_min, $plant->height_max) . " Height";
    }

    public static function width(Plant $plant)
    {
        return self::spreadSize($plant->width_min, $plant->width_max) . " Width";
    }

    private static function spreadSize($min = 0.0, $max = 0.0)
    {
        if(INFX::IsNullOrEmptyString($min)) $min = 0.0;
        if(INFX::IsNullOrEmptyString($max)) $max = 0.0;

        if($min >= $max)
            return INFX::toFeetAndInches($min);
        else
            return INFX::toFeetAndInches($min) . " to " . INFX::toFeetAndInches($max);
    }

    public static function zone(Plant $plant)
    {
        $low = $plant->zone_low;
        $high = $plant->zone_high;

        if((INFX::IsNullOrEmptyString($low) || $low == 0) && (INFX::IsNullOrEmptyString($high) || $high == 0)) return "Unknown";
        if(INFX::IsNullOrEmptyString($low) || $low == 0) return (string)$high;
        if(INFX::IsNullOrEmptyString($high) || $high == 0) return (string)$low;
        if ($low >= $high) return (string)$low;
        return $low . " through " . $high;
    }

    public static function hardiness(Plant $plant)
    {
        $low = $plant->hardiness_low;
        $high = $plant->hardiness_high;
        if((INFX::IsNullOrEmptyString($low) || $low == -999) && (INFX::IsNullOrEmptyString($high) || $high == -999)) return "Unknown";
        if(INFX::IsNullOrEmptyString($low) || $low == -999) return $high . "°";
        if(INFX::IsNullOrEmptyString($high) || $high == -999) return $low . "°";
        if ($low >= $high) return $low . "°";
        return $low . "° to " . $high . "°";
    }

    public static function bloomMonths(Plant $plant)
    {
        return INFX::makeList(INFX::months(), $plant->bloom_months_bw);
    }

    public static function bloomMonthsList(Plant $plant)
    {
        return INFX::buildList(self::bloomMonths($plant), "and");
    }

}
