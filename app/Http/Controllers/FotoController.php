<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Koleksi;
use App\Http\Requests\StoreFotoRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateFotoRequest;
use ImageOptimizer;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $data = Koleksi::where('slug', $slug)->get()[0];
        return view('foto.create',[
            'koleksi_id' => $data->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFotoRequest $request)
    {
        $validatedData = $request->validate([
            'koleksi_id' => 'required',
            'nama' => 'required',
            'nama.*' => 'mimes:jpg,jpeg,png|file|max:5120'
        ]);

        $koleksi = Koleksi::where('id', $request->koleksi_id)->get()[0];

        if($request->hasfile('nama')){ // mengecek lagi bener bener ada gak isinya
            $files = [];
            foreach($request->nama as $file){
                $nama = $file->store('imgUploads');
                ImageOptimizer::optimize('storage/' . $nama);
                Foto::create([
                    'koleksi_id' => $validatedData['koleksi_id'],
                    'filename' => $nama
                ]);
            }
        }

        return redirect('/koleksi/' . $koleksi->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function show(Foto $foto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function edit(Foto $foto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFotoRequest  $request
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFotoRequest $request, Foto $foto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foto $foto)
    {
        Storage::delete($foto->filename);
        Foto::destroy($foto->id);

        return redirect()->back();
    }
}