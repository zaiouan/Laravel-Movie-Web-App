<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
class ImageController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'link' => 'required',
        ]);
        $loop1=$request->file('images');
        foreach ($loop1 as $image) {
            $name=time().".".$image->extension();
            $url = public_path('img');
            $image->move($url, $name);
            Image::create([
                'name' => $name,
                'link' => $name,
                'movie_id' => $request->input('id'),
            ]);
        }
        return back()->with('status', 'Images added successfully');
    }
    public function store2(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'link' => 'required',
        ]);
        $loop1=$request->file('images');
        foreach ($loop1 as $image) {
            $name=time().".".$image->extension();
            $url = public_path('img');
            $image->move($url, $name);
            Image::create([
                'name' => $name,
                'link' => $name,
                'serie_id' => $request->input('id'),
            ]);
        }
        return back()->with('status', 'Images added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
