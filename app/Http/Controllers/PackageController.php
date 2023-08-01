<?php

namespace App\Http\Controllers;

use App\Enums\PackageStatus;
use App\Http\Requests\Package\StoreRequest;
use App\Http\Requests\Package\UpdateRequest;
use App\Models\Collector;
use App\Models\DeliveryCompany;
use App\Models\Package;
use App\Models\StorageLocation;
use App\Models\Unit;
use App\Support\Facades\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PackageController extends Controller
{
    public function index(Request $request): Response
    {
        $packages = Package::with([
            'deliveryCompany',
            'recipientUnit',
            'storageLocation',
            'collector',
        ])->filter($request->all())->when($request->paginate == 'no', function ($query) {
            return $query->get();
        }, function ($query) {
            return $query->paginate($this->pageSize);
        });

        $companies = DeliveryCompany::all();
        $units = Unit::all();
        $locations = StorageLocation::all();
        // $collectors = Collector::all();

        return Inertia::render('Package/Index', [
            'packages' => $packages,
            'companies' => $companies,
            'units' => $units,
            'locations' => $locations,
            // 'collectors' => $collectors,
            'statusOptions' => PackageStatus::getCollection(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (isset($validated['recipient_phone_no'])) {
            $validated['recipient_phone_no'] = Helper::replacePhoneNoLeadingZero($validated['recipient_phone_no']);
        }

        $validated['arrived_at'] = Carbon::now();
        $package = Package::create($validated);

        if ($package) {
            $this->processImage($validated['image_path']);
        } else {
            $this->deleteImage($validated['image_path']);
        }

        return Redirect::route('packages.index');
    }

    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        $package = Package::findOrFail($id);

        $validated = $request->validated();

        if (isset($validated['recipient_phone_no'])) {
            $validated['recipient_phone_no'] = Helper::replacePhoneNoLeadingZero($validated['recipient_phone_no']);
        }

        $package->update($validated);

        return Redirect::route('packages.index');
    }

    private function processImage(string $imagePath = null, Package $package = null): void
    {
        if ($imagePath) {
            $path  = storage_path("app/public/{$imagePath}");

            if (file_exists($path)) {
                copy($path, public_path($imagePath));
                unlink($path);
            }
        }

        if ($package) {
            if (!$imagePath) {
                if ($package->image_path) {
                    if (file_exists(public_path($package->image_path))) {
                        unlink(public_path($package->image_path));
                    }
                }
            }

            $package->update([
                'image_path' => $imagePath
            ]);
        }
    }

    private function deleteImage(string $imagePath = null): void
    {
        if ($imagePath) {
            $path  = storage_path("app/public/{$imagePath}");

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
