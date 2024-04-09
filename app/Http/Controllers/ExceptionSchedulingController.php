<?php

namespace App\Http\Controllers;

use App\Models\OperatorExceptionAvailability;
use App\Traits\ResponseTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExceptionSchedulingController extends Controller
{
    use ResponseTemplate;
    public function store(Request $request,$applicationId)
    {
        $exceptionScheduling = OperatorExceptionAvailability::create([
            'service_application_id' => $applicationId,
            'place_id' => $request->place_id,
            'from' => Carbon::createFromTimestamp($request->from),
            'to' => Carbon::createFromTimestamp($request->to),
            'online' => $request->online ?? 0,
            'onAnotherSite' => $request->onAnotherSite ?? 0,
            'isAvailable' => $request->isAvailable,
        ]);

        $this->setData($exceptionScheduling);
        return $this->response();
    }

    public function index(Request $request,$applicationId)
    {
        $exceptionSchedulings = OperatorExceptionAvailability::query()
            ->where('service_application_id',$applicationId)
            ->paginate($request->per_page ?? 5);

        $this->setData($exceptionSchedulings);
        return $this->response();
    }
}
