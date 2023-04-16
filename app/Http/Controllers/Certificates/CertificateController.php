<?php

namespace App\Http\Controllers\Certificates;

use App\Enums\Certificates\CertificateStatusEnum;
use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Certificates\FilterRequest;
use App\Http\Requests\Certificates\PersonCertificateRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\Certificates\CertificateResource;
use App\Http\Resources\Certificates\PersonCertificateResource;
use App\Models\Certificate;
use App\Models\Certificates\PersonCertificate;
use App\Traits\HasTimestamps;
use App\Traits\QueryTools;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\RedirectResponse;
use ReflectionException;

class CertificateController extends AbstractControllerWithMultipleDeletion
{
    use HasTimestamps, QueryTools;

    public function index(FilterRequest $request)
    {
        $certificateInstanceCondition = static function (Builder|BelongsTo $query) use ($request) {
            return $query->where(['id' => $request->get('certificate_id')]);
        };
        $certificates = PersonCertificate::query()
            ->when($request->get('search_string'), function (Builder $query) use ($request) {
                return $this
                    ->getWhereLikeManyQuery(
                        $query,
                        ['customer_name', 'customer_phone', 'customer_email'],
                        $request->get('search_string')
                    )->orWhereHas('certificate', function (Builder $query) use ($request) {
                        return $query->where('number', 'like', '%' . $request->get('search_string') . '%');
                    });
            })
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

    public function getCertificates()
    {
        return response()->json(['data' => Certificate::all()]);
    }
}
