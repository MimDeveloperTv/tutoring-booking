<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchedulingCollection;
use App\Models\OperatorWeeklyAvailability;
use App\Models\Service;
use App\Models\ServiceApplication;
use App\Models\ServiceApplicationPlace;
use DB;
use Illuminate\Http\Request;

class WeeklySchedulingController extends Controller
{
    public function store(Request $request)
    {
        $operator_id = $request->operator_id;
        $days = $request->days;
        OperatorWeeklyAvailability::whereHas('serviceApplication', function ($query) use ($operator_id) {
            return $query->where('operator_id', $operator_id);
        })->delete();

        foreach ($days as $weekday => $day) {
            if ($day) {
                $shifts = $day['times'];
                foreach ($shifts as $shif) {
                    $service_application_id = Service::find($shif['service'])->serviceApplications()
                        ->where('operator_id', $operator_id)->first()->id;
                    $from = explode(':',$shif['from']);
                    $to = explode(':',$shif['to']);
                    $place = ServiceApplicationPlace::where('address_id',$shif['place'])->where('service_application_id',$service_application_id)->first();
                      if(!$place)
                         $place = ServiceApplicationPlace::create([
                              'address_id' =>  $shif['place'],
                              'service_application_id' => $service_application_id
                          ]);
                    OperatorWeeklyAvailability::create([
                        'service_application_id' => $service_application_id,
                        'place_id' => $place->id,
                        'weekday' => '' . $weekday,
                        'from' => intval($from[0]) * 60 + intval($from[1]),
                        'to' => intval($to[0]) * 60 + intval($to[1]),
                        'online' => $shif['online'] ?? false,
                        'onAnotherSite' => $shif['onAnotherSite'] ?? false
                    ]);
                }
            }
        }

        $schedule = OperatorWeeklyAvailability::whereHas('serviceApplication', function ($query) use ($operator_id) {
            return $query->where('operator_id', $operator_id);
        })->get()->groupBy('weekday');
        return response()->json(new SchedulingCollection($schedule));
    }

    public function index(Request $request)
    {
        $operator_id = $request->operator_id;
        $schedule = OperatorWeeklyAvailability::whereHas('serviceApplication', function ($query) use ($operator_id) {
            return $query->where('operator_id', $operator_id);
        })->get()->groupBy('weekday');

        return response()->json(new SchedulingCollection($schedule));
    }
}
