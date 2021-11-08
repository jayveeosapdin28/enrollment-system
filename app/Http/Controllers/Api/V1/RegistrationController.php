<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\EnrolledNotificationMail;
use App\Models\EnrollmentApplication;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Resources\Registration as RegistrationResources;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
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
                    $query->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('query') . '%');
                    });
                }

            })
            ->where(function ($query) use ($request) {
                if (($request->has('step_from') && $request->step_from != '') && ($request->has('step_to') && $request->step_to != '')) {
                    $query->where('step', '>=', $request->input('step_from'));
                    $query->where('step', '<=', $request->input('step_to'));
                }
                if (($request->has('step_from') && $request->step_from != '') && ($request->has('step_to') && $request->step_to == '')) {
                    $query->where('step', '=', $request->input('step_from'));
                }
            })
            ->paginate($perPage);
        return new RegistrationResources($pending_applications);
    }

    public function onProcess(Request $request)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        // return $request;
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $on_processs = EnrollmentApplication::with(['user:id,name', 'program'])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                    if ($query_string != '' || $query_string != null) {
                        $query->where('idnumber', 'like', '%' . $query_string . '%');
                    }
                }

            })
            ->where(function ($query) use ($request) {
                $query->where('step', '>', '2');
                $query->where('step', '<', '5');
            })
            ->paginate($perPage);
        return new RegistrationResources($on_processs);
    }

    public function complete(Request $request)
    {
        if (!auth()->user()->can('view registration')) {
            return abort(401);
        }
        // return $request;
        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $on_processs = EnrollmentApplication::with(['user:id,name', 'program'])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                    if ($query_string != '' || $query_string != null) {
                        $query->where('idnumber', 'like', '%' . $query_string . '%');
                    }
                }

            })
            ->where(function ($query) use ($request) {
                $query->where('step', '=', '5');
            })
            ->paginate($perPage);
        return new RegistrationResources($on_processs);
    }

    public function confirmRegistration($id)
    {
        if (!auth()->user()->can('update registration')) {
            return abort(401);
        }
        $application = EnrollmentApplication::findOrFail($id);
        $application->update([
            'step' => 5,
            'status' => 'ENROLLED'
        ]);
//        Mail::to('jayvee.osapdin@gmail.com')
//            ->queue(new EnrolledNotificationMail());
        return (new RegistrationResources($application))
            ->response()
            ->setStatusCode(202);
    }

    public function cancelRegistration($id)
    {
        if (!auth()->user()->can('update registration')) {
            return abort(401);
        }
        $application = EnrollmentApplication::findOrFail($id);
        $application->update([
            'step' => 2,
            'status' => 'ON PROCESS'
        ]);
        return (new RegistrationResources($application))
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
        return (new RegistrationResources($pending_application))
            ->response()
            ->setStatusCode(202);
    }

}
