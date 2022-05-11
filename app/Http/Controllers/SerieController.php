<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\actor_movie;
use App\Models\Crew;
use App\Models\Genre;
use App\Models\genre_movie;
use App\Models\Image;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexapi()
    {
        $popularTv = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/popular')
            ->json()['results'];

        $topRatedTv = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/top_rated')
            ->json()['results'];

        $genreslist = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/tv/list')
            ->json()['genres'];

        $genres = collect($genreslist)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });


        return view('serie_api', compact('popularTv', 'topRatedTv', 'genres'));
    }


    public function index()
    {
        $movies = Serie::all();
        return view('serie.index', [
            'series' => $movies,
        ]);
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
        /*$this->validate($request, [
            'title' => 'required',
            'vote' => 'required',
            'overview' => 'required',
            'poster' => 'required',
            'date' => 'required',
            'trailer_link' => 'required',
        ]);*/
        $name = $request->input('title') . "." . $request->image->extension();
        $url = public_path('img');
        $request->file('image')->move($url, $name);
        $mv = Serie::where('title', $request->input('title'))->first();
        if (!$mv) {
            $movie = Serie::create([
                'title' => $request->input('title'),
                'vote' => $request->input('vote'),
                'overview' => $request->input('content'),
                'poster' => $name,
                'date' => $request->input('date'),
                'trailer_link' => $request->input('trailer')
            ]);
        }else{
            return Redirect::route('series')->with('status', 'Serie already exists');
        }
        $loop = $request->get('genres');
        foreach ($loop as $value) {
            $gnr = Genre::where('name', $value)->first();
            if ($gnr) {
                genre_movie::create([
                    'serie_id' => $movie->id,
                    'genre_id' => $gnr->id,
                ]);
            } else {
                $genre = Genre::create([
                    'name' => $value,
                    'name' => $value,
                ]);
                genre_movie::create([
                    'serie_id' => $movie->id,
                    'genre_id' => $genre->id,
                ]);
            }

        }
        return back()->with('status', 'Serie added successfully');
    }


    public function storeapi(Request $request)
    {
        $mv = Serie::where('title', $request->input('title'))->first();
        if (!$mv){
            $serie = Serie::create([
                'title' => $request->input('title'),
                'vote' => $request->input('vote'),
                'overview' => $request->input('overview'),
                'poster' => $request->input('picture'),
                'date' => $request->input('date'),
                'trailer_link' => $request->input('link')
            ]);
        }else{
            return Redirect::route('series')->with('erreur', 'Serie already exists');
        }
        $loop = $request->get('genres');
        foreach ($loop as $value) {
            $genre = Genre::create([
                'name' => $value,
            ]);
            genre_movie::create([
                'serie_id' => $serie->id,
                'genre_id' => $genre->id,

            ]);
        }
        $loop1 = $request->get('crew_name');
        $loop2 = $request->get('job');
        if ($loop1) {
            foreach (array_combine($loop1, $loop2) as $name => $job) {
                $genre = Crew::create([
                    'name' => $name,
                    'job' => $job,
                    'serie_id' => $serie->id,
                ]);
            }
        }
        $loop1 = $request->get('images');
        foreach ($loop1 as $image) {
            $name = time();
            Image::create([
                'name' => $name,
                'link' => $image,
                'serie_id' => $serie->id,
            ]);
        }

        $loop1 = $request->get('actor_name');
        $loop2 = $request->get('actor_character');
        $loop3 = $request->get('actor_picture');
        foreach ($loop1 as $id => $name) {
            $actor = Actor::create([
                'name' => $name,
                'picture' => $loop3[$id]
            ]);
            actor_movie::create([
                'character' => $loop2[$id],
                'serie_id' => $serie->id,
                'actor_id' => $actor->id
            ]);
        }

        return Redirect::route('series')->with('status', 'Serie added successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */

    public function showapi($id)
    {
        $tvshow = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/' . $id . '?append_to_response=credits,videos,images')
            ->json();

        return view('serie.show_api', ['tvshow' => $tvshow]);
    }


    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/serie/' . $id . '?append_to_response=credits,videos,images')
            ->json();

        return view('serie.show', [
            'movie' => $movie,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Serie $serie
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Serie $serie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Serie $serie
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Serie $serie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Serie $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Serie::destroy($id);
        return back()->with('status', 'Serie deleted successfully');
    }
}
