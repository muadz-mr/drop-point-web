<?php

namespace App\Http\Controllers;

use App\Http\Requests\Collector\StoreRequest;
use App\Http\Requests\Collector\UpdateRequest;
use App\Models\Collector;
use App\Support\Facades\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CollectorController extends Controller
{
    public function index(Request $request): Response
    {
        $collectors = Collector::filter($request->all())->when($request->paginate == 'no', function ($query) {
            return $query->get();
        }, function ($query) {
            return $query->paginate($this->pageSize);
        });

        return Inertia::render('Collector/Index', [
            'collectors' => $collectors
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['phone_no'] = $validated['phone_no'] ? Helper::replacePhoneNoLeadingZero($validated['phone_no']) : null;
        Collector::create($validated);

        return Redirect::route('collectors.index');
    }

    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();
        $collector = Collector::findOrFail($id);

        if (isset($validated['phone_no'])) {
            $validated['phone_no'] = Helper::replacePhoneNoLeadingZero($validated['phone_no']);
        }

        $collector->update($validated);
        return Redirect::route('collectors.index');
    }

    public function destroy($id): RedirectResponse
    {
        $collector = Collector::findOrFail($id);
        $collector->delete();
        return Redirect::route('collectors.index');
    }
}
