<?php

namespace App\Http\Controllers\Certificates;

use App\Enums\Certificates\CertificateInstanceStatusEnum;
use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Certificates\CertificateInstanceRequest;
use App\Http\Requests\Certificates\CertificateUploadRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\Certificates\CertificateInstanceResource;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CertificateInstanceController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('CertificateInstances/Index', [
            'certificateInstances' => CertificateInstanceResource::collection(Certificate::orderByDesc('id')->paginate(15)),
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


    public function upload(CertificateUploadRequest $request)
    {
        $path = \Storage::disk('temp')->put('', $request->file);
        $storagePath = storage_path('app/temp' . '/' . $path);
        $spreadsheet = IOFactory::load($storagePath);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            if (is_numeric($cells[1])) {
                Certificate::updateOrCreate(
                    ['number' => $cells[0]],
                    ['price' => $cells[1], 'status' => CertificateInstanceStatusEnum::active]
                );
            }
        }
        \Storage::disk('temp')->delete($path);
        return redirect()->back();
    }
}
