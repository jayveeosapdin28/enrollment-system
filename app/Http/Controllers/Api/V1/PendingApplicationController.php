<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentApplication;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Resources\PendingApplication as PendingApplicationResources;

class PendingApplicationController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        // return $request;
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $pending_applications = EnrollmentApplication::with(['user:id,name', 'program'])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                    if ($query_string != '' || $query_string != null) {
                        $query->where('idnumber', 'like', '%' . $query_string . '%');
                    }
                }

            })
            ->where(function ($query) use ($request) {
                $query->where('status', '=', 'PENDING');
                $query->where('step', '=', '1');
                $query->orWhere('step', '=', '2');
            })
            ->paginate($perPage);
        return new PendingApplicationResources($pending_applications);
    }

    public function update($id)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        $idnumber = IdGenerator::generate([
            'table' => 'enrollment_applications',
            'field' => 'idnumber',
            'length' => 12,
            'reset_on_prefix_change' => true,
            'prefix' => 'MMC2021-'
        ]);
        $pending_application = EnrollmentApplication::findOrFail($id);
        $pending_application->update(['idnumber' => $idnumber, 'step' => 2]);
        return (new PendingApplicationResources($pending_application))
            ->response()
            ->setStatusCode(202);
    }
    public function generateIDNumber($id)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        $idnumber = IdGenerator::generate([
            'table' => 'enrollment_applications',
            'field' => 'idnumber',
            'length' => 12,
            'reset_on_prefix_change' => true,
            'prefix' => 'MMC2021-'
        ]);
        $pending_application = EnrollmentApplication::findOrFail($id);
        $pending_application->update(['idnumber' => $idnumber, 'step' => 2]);
        return (new PendingApplicationResources($pending_application))
            ->response()
            ->setStatusCode(202);
    }
    public function show($id)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        $idnumber = IdGenerator::generate([
            'table' => 'enrollment_applications',
            'field' => 'idnumber',
            'length' => 12,
            'reset_on_prefix_change' => true,
            'prefix' => 'MMC2021-'
        ]);
        $pending_application = EnrollmentApplication::findOrFail($id);
        $pending_application->update(['idnumber' => $idnumber, 'step' => 2]);
        return (new PendingApplicationResources($pending_application))
            ->response()
            ->setStatusCode(202);
    }
}
