<?php

namespace App\Http\Controllers;

use App\Models\BodyType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BodyTypeController extends Controller
{
    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'admin', 403);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);
        $data = $request->validate(['name' => 'required|string|max:50|unique:body_types,name']);
        BodyType::create($data);

        return back()->with('success', 'Kategori tipe body berhasil ditambahkan.');
    }

    public function update(Request $request, BodyType $bodyType)
    {
        $this->authorizeAdmin($request);
        $data = $request->validate(['name' => ['required', 'string', 'max:50', Rule::unique('body_types', 'name')->ignore($bodyType->id)]]);
        $bodyType->update($data);

        return back()->with('success', 'Kategori tipe body berhasil diperbarui.');
    }

    public function destroy(Request $request, BodyType $bodyType)
    {
        $this->authorizeAdmin($request);
        $bodyType->delete();

        return back()->with('success', 'Kategori tipe body berhasil dihapus.');
    }
}
