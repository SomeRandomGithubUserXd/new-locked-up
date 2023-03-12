<?php

namespace App\Http\Controllers;

use App\Enums\CertificateStatusEnum;
use App\Http\Requests\Certificates\FilterRequest;
use App\Http\Requests\Certificates\PersonCertificateRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\PersonCertificateResource;
use App\Models\Appeal;
use App\Models\Certificate;
use App\Models\Certificates\PersonCertificate;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\RedirectResponse;
use ReflectionException;

class CertificateController extends AbstractControllerWithMultipleDeletion
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

    /**
     * @throws ReflectionException
     */
    public function create()
    {
        return inertia('Certificates/Create', [
            'certificateInstances' => Certificate::where('number', '!=', '')->get(),
            'certificateStatuses' => CertificateStatusEnum::getArray()
        ]);
    }

    public function store(PersonCertificateRequest $request)
    {
        PersonCertificate::create($request->getUnRefactoredValidatedData());
        return redirect()->route('certificates.index');
    }

    public function show(PersonCertificate $certificate)
    {
        return inertia('Certificates/Show', [
            'certificate' => CertificateResource::singleItem($certificate),
            'certificateInstances' => Certificate::where('number', '!=', '')->get(),
            'certificateStatuses' => CertificateStatusEnum::getArray()
        ]);
    }

    public function update(PersonCertificateRequest $request, PersonCertificate $certificate)
    {
        $certificate->update($request->getUnRefactoredValidatedData());
        return redirect()->route('certificates.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        PersonCertificate::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
