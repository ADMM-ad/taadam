<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;

class JaringanController extends Controller
{
    public function index()
    {
        $jaringan = Jaringan::all();
        return view('jaringan.index', compact('jaringan'));
    }

    public function create()
    {
        return view('jaringan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jaringan' => 'required|string',
            'allowedRangeStart' => 'required|ip',
            'allowedRangeEnd' => 'required|ip',
        ], [
            'nama_jaringan.required' => 'Nama jaringan wajib diisi.',
            'nama_jaringan.string' => 'Nama jaringan harus berupa teks.',
            'allowedRangeStart.required' => 'IP Start wajib diisi.',
            'allowedRangeStart.ip' => 'IP Start harus berupa alamat IP yang valid.',
            'allowedRangeEnd.required' => 'IP End wajib diisi.',
            'allowedRangeEnd.ip' => 'IP End harus berupa alamat IP yang valid.',
        ]);

        Jaringan::create($request->all());
        return redirect()->route('jaringan.index')->with('success', 'Data jaringan berhasil ditambahkan.');
    }

    public function edit(Jaringan $jaringan)
    {
        return view('jaringan.edit', compact('jaringan'));
    }

    public function update(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'nama_jaringan' => 'required|string',
            'allowedRangeStart' => 'required|ip',
            'allowedRangeEnd' => 'required|ip',
        ], [
            'nama_jaringan.required' => 'Nama jaringan wajib diisi.',
            'nama_jaringan.string' => 'Nama jaringan harus berupa teks.',
            'allowedRangeStart.required' => 'IP Start wajib diisi.',
            'allowedRangeStart.ip' => 'IP Start harus berupa alamat IP yang valid.',
            'allowedRangeEnd.required' => 'IP End wajib diisi.',
            'allowedRangeEnd.ip' => 'IP End harus berupa alamat IP yang valid.',
        ]);

        $jaringan->update($request->all());
        return redirect()->route('jaringan.index')->with('success', 'Data jaringan berhasil diperbarui.');
    }

    public function destroy(Jaringan $jaringan)
    {
        $jaringan->delete();
        return redirect()->route('jaringan.index')->with('success', 'Data jaringan berhasil dihapus.');
    }
}
