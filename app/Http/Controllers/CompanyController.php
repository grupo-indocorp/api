<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->paginate(20);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => true,
            'expires_at' => $request->expires_at
        ]);

        $token = $company->createToken('company-token')->plainTextToken;

        return redirect()->route('companies.index')
            ->with('success', 'Empresa creada')
            ->with('token', $token);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function toggle(Company $company)
    {
        $company->is_active = !$company->is_active;
        $company->save();

        return back()->with('success', 'Estado actualizado');
    }

    public function regenerateToken(Company $company)
    {
        // eliminar tokens anteriores
        $company->tokens()->delete();

        // crear nuevo
        $token = $company->createToken('company-token')->plainTextToken;

        return back()->with('token', $token);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Eliminado');
    }
}
