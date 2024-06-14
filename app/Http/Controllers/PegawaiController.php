<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $pegawais = Pegawai::query();

        if ($request->has('search')) {
            $pegawais->where(function ($query) use ($request) {
                $query->where('nama', 'like', '%'. $request->search. '%')
                    ->orWhere('posisi', 'like', '%'. $request->search. '%')
                    ->orWhere('tanggal_lahir', 'like', '%'. $request->search. '%');
            });
        }

        if ($request->has('sort_by') && $request->has('sort_order')) {
            $pegawais->orderBy($request->sort_by, $request->sort_order);
        } else {
            $pegawais->orderBy('nama', 'asc');
        }

        $pegawais = $pegawais->paginate(10);

        return view('pegawai.index', compact('pegawais', 'request'));
        
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pegawai = new Pegawai();
        $pegawai->nama = $request->nama;
        $pegawai->posisi = $request->posisi;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('images'), $nama_foto);
            $pegawai->foto = $nama_foto;
        }

        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->delete();
        return redirect()->route('pegawai.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'posisi' => 'required',
            'tanggal_lahir' => 'required|date',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $pegawai = Pegawai::find($id);
        $pegawai->nama = $request->get('nama');
        $pegawai->posisi = $request->get('posisi');
        $pegawai->tanggal_lahir = $request->get('tanggal_lahir');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $pegawai->foto = $name;
        }

        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai updated successfully');
    }
}

