<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerService $customerService)
    {
    }

    public function index(): ResourceCollection
    {
        return CustomerResource::collection(Customer::all());
    }

    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer->load('books'));
    }

    public function store(CustomerCreateRequest $request): CustomerResource
    {
        $customer = $this->customerService->create($request->validated());

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer): Response
    {
        $this->customerService->delete($customer->id);

        return response()->noContent();
    }
}
