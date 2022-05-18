<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GalleryResource::collection(
            Gallery::paginate(5)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'nim' => 'required|unique:pgsql.public.galleries',
            'email' => 'required|unique:pgsql.public.galleries',
            'photo' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(),422);
        }
    
        $gallery = new Gallery;
        $gallery->nama = Str::title($request->nama);
        $gallery->nim = $request->nim;
        $gallery->email = $request->email;
        $gallery->photo = $request->photo;
        $gallery->save();
        return response()->json(['message'=>'Berhasil Ditambahkan!'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return GalleryResource::collection(
            Gallery::where('id', $gallery->id)->paginate(5)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'nim' => 'required|unique:pgsql.public.galleries,nim,' .$gallery->id,
            'email' => 'required|unique:pgsql.public.galleries,email,' .$gallery->id,
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(),422);
        }
    
        $gallery->nama = Str::title($request->nama);
        $gallery->nim = $request->nim;
        $gallery->email = $request->email;
        if($request->photo) {
            $gallery->photo = $request->photo;
        }
        $gallery->update();
        return response()->json(['message'=>'Berhasil Diubah!'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json(['message'=>'Berhasil Dihapus!'],201);
    }
}
