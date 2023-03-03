<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryCompany\StoreRequest;
use App\Http\Requests\DeliveryCompany\UpdateRequest;
use App\Models\DeliveryCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DeliveryCompanyController extends Controller
{
    public function index(Request $request): Response
    {
        $deliveryCompanies = DeliveryCompany::filter($request->all())->when($request->paginate == 'no', function ($query) {
            return $query->get();
        }, function ($query) {
            return $query->paginate($this->pageSize);
        });

        return Inertia::render('DeliveryCompany/Index', [
            'companies' => $deliveryCompanies
        ]);
    }

    public function store(StoreRequest $request)
    {
        DeliveryCompany::create($request->validated());

        return Redirect::route('delivery-companies.index');
    }

    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        $company = DeliveryCompany::findOrFail($id);
        $company->fill($request->validated());
        $company->save();

        return Redirect::route('delivery-companies.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $company = DeliveryCompany::findOrFail($id);
        $company->delete();

        return Redirect::route('delivery-companies.index');
    }
}
