<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\StoreRequest;
use App\Http\Requests\Unit\UpdateRequest;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UnitController extends Controller
{
    public function index(Request $request): Response
    {
        $units = Unit::filter($request->all())->when($request->paginate == 'no', function ($query) {
            return $query->get();
        }, function ($query) {
            return $query->paginate($this->pageSize);
        });

        return Inertia::render('Unit/Index', [
            'units' => $units
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Unit::create($request->validated());
        return Redirect::route('units.index');
    }

    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->validated());
        return Redirect::route('units.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return Redirect::route('units.index');
    }
}
