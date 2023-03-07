<?php

namespace App\Http\Controllers;

use App\Enums\StorageLocationStatus;
use App\Http\Requests\StorageLocation\StoreRequest;
use App\Http\Requests\StorageLocation\UpdateRequest;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class StorageLocationController extends Controller
{
    public function index(Request $request): Response
    {
        $storageLocations = StorageLocation::filter($request->all())->when($request->paginate == 'no', function ($query) {
            return $query->get();
        }, function ($query) {
            return $query->paginate($this->pageSize);
        });

        return Inertia::render('StorageLocation/Index', [
            'storageLocations' => $storageLocations,
            'status' => StorageLocationStatus::getCollection(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        StorageLocation::create($request->validated());
        return Redirect::route('storage-locations.index');
    }

    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        dd($request);
        $storageLocation = StorageLocation::findOrFail($id);
        $storageLocation->update($request->validated());
        return Redirect::route('storage-locations.index');
    }

    public function destroy($id): RedirectResponse
    {
        $storageLocation = StorageLocation::findOrFail($id);
        $storageLocation->delete();
        return Redirect::route('storage-locations.index');
    }
}
