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
//        'created_at', 'updated_at'
    ];

    protected $primaryKey = "plant_id";

    public function classifications() {
        return $this->belongsToMany('App\Classification', 'plant_classification', 'plant_id', 'class_id' )
            ->withTimestamps();
    }

    public function flowerColors() {
        return $this->belongsToMany('App\FlowerColor', 'plant_flower_color', 'plant_id', 'flower_color_id' )
            ->withTimestamps();
    }

    public function specifications() {
        return $this->belongsToMany('App\Specification', 'plant_specification', 'plant_id', 'specification_id' )
            ->withPivot("specification_note")
            ->withTimestamps();
    }

    public function plantImages() {
        return $this->hasMany('App\PlantImage', 'plant_id');
    }

    public function plantNotes() {
        return $this->hasMany('App\PlantNote', 'plant_id');
    }

    public function botanicalNames() {
        return $this->hasMany('App\BotanicalName', 'plant_id');
    }

    public function commonNames() {
        return $this->hasMany('App\CommonName', 'plant_id');
    }

    // Functions

    public static function botanicalName($plant)
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

    public static function leafDrop($plant)
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

    public static function sunExposure($plant)
    {
        $bw = $plant->sun_exposure;
        $returnVal = "";

        if (INFX::IsNullOrEmptyString($bw) || $bw == 0) return $returnVal;

        $base = 0;
        $spos = null;
        $epos = null;

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

    public static function height($plant)
    {
        return self::spreadSize($plant->height_min, $plant->height_max) . " Height";
    }

    public static function width($plant)
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

    public static function zone($plant)
    {
        $low = $plant->zone_low;
        $high = $plant->zone_high;

        if((INFX::IsNullOrEmptyString($low) || $low == 0) && (INFX::IsNullOrEmptyString($high) || $high == 0)) return "Unknown";
        if(INFX::IsNullOrEmptyString($low) || $low == 0) return (string)$high;
        if(INFX::IsNullOrEmptyString($high) || $high == 0) return (string)$low;
        if ($low >= $high) return (string)$low;
        return $low . " through " . $high;
    }

    public static function hardiness($plant)
    {
        $low = $plant->hardiness_low;
        $high = $plant->hardiness_high;
        if((INFX::IsNullOrEmptyString($low) || $low == -999) && (INFX::IsNullOrEmptyString($high) || $high == -999)) return "Unknown";
        if(INFX::IsNullOrEmptyString($low) || $low == -999) return $high . "°";
        if(INFX::IsNullOrEmptyString($high) || $high == -999) return $low . "°";
        if ($low >= $high) return $low . "°";
        return $low . "° to " . $high . "°";
    }

    public static function bloomMonths($plant)
    {
        return INFX::makeList(INFX::months(), $plant->bloom_months_bw);
    }

    public static function bloomMonthsList($plant)
    {
        return INFX::buildList(self::bloomMonths($plant), "and");
    }

    public static function altBotanicalNames($plants)
    {
        $returnPlants = [];
        foreach ($plants as $plant)
        {
            array_push($returnPlants, self::botanicalName($plant));
        }
        return $returnPlants;
    }

    public static function altBotanicalNamesList($plant)
    {
        $list = INFX::buildList(self::altBotanicalNames($plant), "and");
        if(INFX::IsNullOrEmptyString($list)) return null;
        return $list;
    }

    public static function altCommonNames($plants)
    {
        $returnPlants = [];
        foreach ($plants as $plant)
        {
            array_push($returnPlants, $plant->common_name);
        }
        return $returnPlants;
    }

    public static function altCommonNamesList($plant)
    {
        $list = INFX::buildList(self::altCommonNames($plant), "and");
        if(INFX::IsNullOrEmptyString($list)) return null;
        return $list;
    }

    public static function specificationsList($plants)
    {
        $specs = [];
        foreach($plants as $plant)
        {
            $singleSpec = [];
            $singleSpec['id'] = $plant->specification_id;
            $singleSpec['specification'] = $plant->specification;
            $singleSpec['icon'] = INFX::imagesDir() ."/resources/" . $plant->icon_file_name . "." . $plant->icon_file_type;

            if (!INFX::IsNullOrEmptyString($plant->pivot->specification_note))
            {
                $singleSpec['note'] = $plant->pivot->specification_note;
            }

            array_push($specs, $singleSpec);
        }
        return $specs;
    }

    public static function images($plants)
    {
        $images = [];
        foreach($plants as $plant)
        {
            $singleImg = [];
            $singleImg['image'] = INFX::imagesDir() ."/plants/" . $plant->file_name . "." . $plant->file_type;
            if (!INFX::IsNullOrEmptyString($plant->image_desc))
            {
                $singleImg['description'] = $plant->image_desc;
            }
            array_push($images, $singleImg);
        }
        return $images;
    }

    public static function notes($plants)
    {
        $notes = [];

        foreach ($plants as $plant)
        {
            array_push($notes, $plant->note);
        }
        return $notes;
    }

}
