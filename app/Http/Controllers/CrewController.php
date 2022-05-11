<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use Illuminate\Http\Request;

class CrewController extends Controller
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
            'job' => 'required',
        ]);
        $loop1=$request->get('txt1');
        $loop2=$request->get('txt2');
        foreach (array_combine($loop1, $loop2) as $name => $job) {
            $genre = Crew::create([
                'name' => $name,
                'job' => $job,
                'movie_id' => $request->input('id'),
            ]);
        }
        return back()->with('status', 'Crews added successfully');
    }

    public function store2(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'job' => 'required',
        ]);
        $loop1=$request->get('txt1');
        $loop2=$request->get('txt2');
        foreach (array_combine($loop1, $loop2) as $name => $job) {
            $genre = Crew::create([
                'name' => $name,
                'job' => $job,
                'serie_id' => $request->input('id'),
            ]);
        }
        return back()->with('status', 'Crews added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crew  $crew
     * @return \Illuminate\Http\Response
     */
    public function show(Crew $crew)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crew  $crew
     * @return \Illuminate\Http\Response
     */
    public function edit(Crew $crew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crew  $crew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crew $crew)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crew  $crew
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crew $crew)
    {
        //
    }
}
