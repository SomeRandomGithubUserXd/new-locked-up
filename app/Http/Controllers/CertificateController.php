<?php

namespace App\Http\Controllers;

use App\Http\Requests\Certificates\FilterRequest;
use App\Http\Resources\PersonCertificateResource;
use App\Models\Certificate;
use App\Models\Certificates\PersonCertificate;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateController extends Controller
{
    use HasTimestamps;

    public function index(FilterRequest $request)
    {
        $certificateInstanceCondition = static function (Builder|BelongsTo $query) use ($request) {
            return $query->where(['id' => $request->get('certificate_id')]);
        };
        $certificates = PersonCertificate::query()
            ->when($request->get('certificate_id'), function (Builder $query) use ($certificateInstanceCondition) {
                return $query
                    ->whereHas('certificate', $certificateInstanceCondition)
                    ->with('certificate', $certificateInstanceCondition);
            })
            ->paginate(15);
        return inertia('Certificates/Index', [
            'certificates' => PersonCertificateResource::collection($certificates),
            'certificateInstances' => Certificate::where('number', '!=', '')->get()
        ]);
    }
}
