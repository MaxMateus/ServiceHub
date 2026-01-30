<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['nullable', 'string', 'max:20'],
        ]);

        Company::create($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Empresa criada com sucesso.');
    }
}
