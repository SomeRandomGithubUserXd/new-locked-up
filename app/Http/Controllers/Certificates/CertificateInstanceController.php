<?php

namespace App\Http\Controllers\Certificates;

use App\Enums\Certificates\CertificateInstanceStatusEnum;
use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Certificates\CertificateInstanceRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\Certificates\CertificateInstanceResource;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;

class CertificateInstanceController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('CertificateInstances/Index', [
            'certificateInstances' => CertificateInstanceResource::collection(Certificate::paginate(15)),
            'certificateStatuses' => CertificateInstanceStatusEnum::getArray()
        ]);
    }

    public function show(Certificate $certificateInstance)
    {
        return inertia('CertificateInstances/Show', [
            'certificate' => CertificateInstanceResource::singleItem($certificateInstance),
            'certificateStatuses' => CertificateInstanceStatusEnum::getArray()
        ]);
    }

    public function create()
    {
        return inertia('CertificateInstances/Create', [
            'certificateStatuses' => CertificateInstanceStatusEnum::getArray()
        ]);
    }

    public function store(CertificateInstanceRequest $request)
    {
        Certificate::create($request->validated());
        return redirect()->route('certificate-instances.index');
    }

    public function update(CertificateInstanceRequest $request, Certificate $certificateInstance)
    {
        $certificateInstance->update($request->validated());
        return redirect()->route('certificate-instances.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Certificate::whereIn('id', $request->get('ids'))->delete();
        return redirect()->route('certificate-instances.index');
    }
}
