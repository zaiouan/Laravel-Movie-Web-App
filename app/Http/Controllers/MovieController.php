<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\actor_movie;
use App\Models\Crew;
use App\Models\Genre;
use App\Models\genre_movie;
use App\Models\Image;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexapi()
    {
        $popularMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/popular')
            ->json()['results'];

        $nowPlayingMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/now_playing')
            ->json()['results'];

        $genreslist = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/movie/list')
            ->json()['genres'];
        $genres = collect($genreslist)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });
        return view('movie_api', compact('popularMovies', 'nowPlayingMovies', 'genres'));
    }

    public function index()
    {
        $movies = Movie::all();
        return view('movie.index', [
            'movies' => $movies,
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
      /*  $this->validate($request, [
            'title' => 'required',
            'vote' => 'required',
            'overview' => 'required',
            'poster' => 'required',
            'date' => 'required',
            'trailer_link' => 'required',
        ]); */
        $name = $request->input('title') . "." . $request->image->extension();
        $url = public_path('img');
        $request->file('image')->move($url, $name);
        $movie = Movie::create([
            'title' => $request->input('title'),
            'vote' => $request->input('vote'),
            'overview' => $request->input('content'),
            'poster' => $name,
            'date' => $request->input('date'),
            'trailer_link' => $request->input('trailer')
        ]);
        $loop = $request->get('genres');
        foreach ($loop as $value) {
            $gnr = Genre::where('name', $value)->first();
            if ($gnr) {
                genre_movie::create([
                    'movie_id' => $movie->id,
                    'genre_id' => $gnr->id,
                ]);
            }
            else {
                $genre = Genre::create([
                    'name' => $value,
                ]);
                genre_movie::create([
                    'movie_id' => $movie->id,
                    'genre_id' => $genre->id,
                ]);
            }

        }
        return back()->with('status', 'Movie added successfully');
    }

    public function storeapi(Request $request)
    {
        $mv = Movie::where('title', $request->input('title'))->first();
        if (!$mv){
            $movie = Movie::create([
                'title' => $request->input('title'),
                'vote' => $request->input('vote'),
                'overview' => $request->input('overview'),
                'poster' => $request->input('picture'),
                'date' => $request->input('date'),
                'trailer_link' => $request->input('link')
            ]);
        }else{
            return Redirect::route('movies')->with('erreur', 'Movie already exists');
        }

        $loop = $request->get('genres');
        foreach ($loop as $value) {
            $gnr = Genre::where('name', $value)->first();
            if ($gnr) {
                genre_movie::create([
                    'movie_id' => $movie->id,
                    'genre_id' => $gnr->id,
                ]);
            }
            else {
                $genre = Genre::create([
                    'name' => $value,
                ]);
                genre_movie::create([
                    'movie_id' => $movie->id,
                    'genre_id' => $genre->id,
                ]);
            }
        }
        $loop1 = $request->get('crew_name');
        $loop2 = $request->get('job');
        foreach (array_combine($loop1, $loop2) as $name => $job) {
                $genre = Crew::create([
                    'name' => $name,
                    'job' => $job,
                    'movie_id' => $movie->id,
                ]);
        }
        $loop1 = $request->get('images');
        foreach ($loop1 as $image) {
            $name = time();
            Image::create([
                'name' => $name,
                'link' => $image,
                'movie_id' => $movie->id,
            ]);
        }

        $loop1 = $request->get('actor_name');
        $loop2 = $request->get('actor_character');
        $loop3 = $request->get('actor_picture');
        foreach ($loop1 as $id => $name) {
            $act = Actor::where('name', $name)->first();
            if ($act) {
                actor_movie::create([
                    'movie_id' => $movie->id,
                    'character' => $loop2[$id],
                    'actor_id' => $act->id
                ]);
            }else{
                $actor = Actor::create([
                    'name' => $name,
                    'picture' => $loop3[$id]
                ]);
                actor_movie::create([
                    'movie_id' => $movie->id,
                    'character' => $loop2[$id],
                    'actor_id' => $actor->id
                ]);
            }

        }

        return Redirect::route('movies')->with('status', 'Movie added successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/' . $id . '?append_to_response=credits,videos,images')
            ->json();

        return view('user.show', [
            'movie' => $movie,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Movie::destroy($id);
        return back()->with('status', 'Movie deleted successfully');
    }
}
