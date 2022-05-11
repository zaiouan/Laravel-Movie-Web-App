<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\actor_movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $actors = Actor::all();
        return view('actor.index', compact('actors'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'picture' => 'required',
            'character' => 'required',
        ]);
        $loop1 = $request->get('txt1');
        $loop2 = $request->get('txt2');
        $loop3 = $request->file('images');
        foreach ($loop1 as $id => $name) {
            $nom = $name . "." . $loop3[$id]->extension();
            $url = public_path('img');
            $loop3[$id]->move($url, $nom);
            $act = Actor::where('name', $name)->first();
            if ($act) {
                actor_movie::create([
                    'character' => $loop2[$id],
                    'movie_id' => $request->input('id'),
                    'actor_id' => $actor->id
                ]);
            } else {
                $actor = Actor::create([
                    'name' => $name,
                    'picture' => $nom
                ]);
                actor_movie::create([
                    'character' => $loop2[$id],
                    'movie_id' => $request->input('id'),
                    'actor_id' => $actor->id
                ]);
            }
        }
        return back()->with('status', 'Actors added successfully');
    }

    public function store2(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'picture' => 'required',
            'character' => 'required',
        ]);
        $loop1 = $request->get('txt1');
        $loop2 = $request->get('txt2');
        $loop3 = $request->file('images');
        foreach ($loop1 as $id => $name) {
            $nom = $name . "." . $loop3[$id]->extension();
            $url = public_path('img');
            $loop3[$id]->move($url, $nom);
            $act = Actor::where('name', $name)->first();
            if ($act) {
                actor_movie::create([
                    'character' => $loop2[$id],
                    'serie_id' => $request->input('id'),
                    'actor_id' => $act->id
                ]);
            } else {
                $actor = Actor::create([
                    'name' => $name,
                    'picture' => $nom
                ]);
                actor_movie::create([
                    'character' => $loop2[$id],
                    'serie_id' => $request->input('id'),
                    'actor_id' => $actor->id
                ]);
            }
        }
        return back()->with('status', 'Actors added successfully');
    }

    public function storeapi(Request $request)
    {
        $mv = Actor::where('name', $request->input('name'))->first();
        if (!$mv) {
            $actor = Actor::create([
                'name' => $request->input('name'),
                'picture' => $request->input('picture')
            ]);
        } else {
            return Redirect::route('actors.index')->with('status', 'Movie already exists');
        }
        return Redirect::route('actors.index');
    }

    public function showapi($id)
    {
        $actor = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id)
            ->json();

        $social = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id . '/external_ids')
            ->json();

        $credits = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id . '/combined_credits')
            ->json();

        return view('actor.showapi', [
            'actor' => $actor,
            'social' => $social,
            'credits' => $credits,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Actor $actor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Actor::find($id);
        return view('actor.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Actor $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Actor $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actor $actor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Actor $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Actor::destroy($id);
        return back();
    }
}
