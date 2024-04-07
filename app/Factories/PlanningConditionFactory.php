<?php

namespace App\Factories;

use App\Models\Hard\Eye\EyeVariable;

class PlanningConditionFactory
{

    public static function build(string $condition,$patient_id)
    {
        $planning = "Planning" . str($condition)->title();
        if(class_exists($planning))
        {
            return new $planning($patient_id);
        }
        else {
            throw new Exception("Invalid product type given.");
        }
    }
}
