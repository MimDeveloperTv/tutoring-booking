<?php

namespace App\Interfaces\Planning;

use App\Models\Hard\Eye\EyeVariable;

class PlanningCondition
{
    protected array $planningData;
    public function __construct($patient_id)
    {
        $this->planningData['od'] = EyeVariable::where('$patient_id',$patient_id)->eye_variables()->where('eye_type','od')->first();
        $this->planningData['os'] = EyeVariable::where('$patient_id',$patient_id)->eye_variables()->where('eye_type','os')->first();
    }
}
