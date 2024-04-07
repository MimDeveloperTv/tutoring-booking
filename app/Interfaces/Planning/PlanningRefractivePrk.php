<?php

namespace App\Interfaces\Planning;

use App\Factories\PlanningConditionFactory;

class PlanningRefractivePrk extends PlanningCondition implements HasCondition
{
    public function __construct($patient_id)
    {
        parent::__construct($patient_id);
    }

    public function condition()
    {
        foreach (['od', 'os'] as $eyeType) {
            if (!is_null($this->planningData[$eyeType]['K1_D']) && $this->planningData[$eyeType]['K1_D'] < 38 || $this->planningData[$eyeType]['K1_D'] > 50) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_K1');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && $this->planningData[$eyeType]['K2_D'] < 38 || $this->planningData[$eyeType]['K2_D'] > 50) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_K2');
            }

            if (!is_null($this->planningData[$eyeType]['k1_postup']) && $this->planningData[$eyeType]['k1_postup'] < 34 || $this->planningData[$eyeType]['k1_postup'] > 48) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_K1_postup');
            }

            if (!is_null($this->planningData[$eyeType]['k2_postup']) && $this->planningData[$eyeType]['k2_postup'] < 34 || $this->planningData[$eyeType]['k2_postup'] > 48) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_K2_postup');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph']) && $this->planningData[$eyeType]['subjective_ref_sph'] < -8 || $this->planningData[$eyeType]['subjective_ref_sph'] > 1) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_Sphere');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && $this->planningData[$eyeType]['subjective_ref_cyl'] < -6 || $this->planningData[$eyeType]['subjective_ref_cyl'] > 0) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 480) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['maxAbl']) && $this->planningData[$eyeType]['maxAbl'] > 125) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_maxAbl');
            }

            if (!is_null($this->planningData[$eyeType]['rsb']) && $this->planningData[$eyeType]['rsb'] < 400) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_rsb');
            }

            if ($this->planningData['age'] < 18) {
                $this->data[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['history'][1]['items'][4]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['history'][1]['items'][11]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['history'][1]['items'][10]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['history'][1]['items'][6]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['history'][1]['items'][7]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['history'][1]['items'][8]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['history'][1]['items'][9]['value'] == true) {
                $this->data['global']['messages'][] = __('messages.or_sumatriptan');
            }
        }

        return $this->data;
    }
}
