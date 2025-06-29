<?php

namespace App\Http\Controllers;

use App\Http\Requests\HospitalSpecialistRequest;
use App\Services\HospitalService;
use App\Services\HospitalSpecialistService;
use Illuminate\Http\Request;

class HospitalSpecialistController extends Controller
{
    private HospitalService $hospitalService;

    public function __construct(HospitalService $hospitalService) {
        $this->hospitalService = $hospitalService;
    }

    public function attach(HospitalSpecialistRequest $request, int $hospitalId)
    {
        $validated = $request->validated();
        
        $this->hospitalService->attachSpecialist($hospitalId, $validated['specialist_id']);
        return response()->json([
            'message' => 'Specialist attached successfully'
        ]);
    }

    public function detach(int $hospitalId, int $specialistId)
    {
        $this->hospitalService->detachSpecialist($hospitalId, $specialistId);
        return response()->json([
            'message' => 'Specialist detached successfully'
        ]);
    }
}
