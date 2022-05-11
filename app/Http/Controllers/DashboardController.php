<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Movie;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $movies=Movie::all();
        if(Auth::user()->hasRole('user')){
            return view('movies',compact('movies'));
        }
        elseif(Auth::user()->hasRole('admin')){
            return view('admin.dashboard');
        }
    }
    public function indexmovie()
        {
            $movies=Movie::all();
            if(Auth::user()->hasRole('user')){
                return view('movies',compact('movies'));
            }
            elseif(Auth::user()->hasRole('admin')){
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
        }
    public function indexserie()
        {
            if(Auth::user()->hasRole('user')){
                $series=Serie::all();
                return view('series',compact('series'));
            }
            elseif(Auth::user()->hasRole('admin')){
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
        }
    public function indexactor($page=1)
            {
                if(Auth::user()->hasRole('user')){
                    $actors=Actor::paginate(15);
                    return view('actors',compact('actors'));
                }
                elseif(Auth::user()->hasRole('admin')){
                    abort_if($page > 500, 204);

                    $popularActors = Http::withToken(config('services.tmdb.token'))
                        ->get('https://api.themoviedb.org/3/person/popular?page='.$page)
                        ->json()['results'];

                    return view('actor_api', compact('popularActors'));
                }
            }

    public function show1($id)
    {

        $movies=Movie::findOrFail($id);

        return view('movie.show',[
            'movie' => $movies,
        ]);
    }

    public function show2($id)
    {

        $movies=Serie::findOrFail($id);

        return view('serie.show',[
            'movie' => $movies,
        ]);
    }

    public function indexUser(){
        $users=User::all();
        return view('user.index',[
            'users' => $users,
        ]);
    }
    public function profil()
    {
        return view('user.profil');
    }
    public function show(){
        return view('user.show');
    }

    public function destroy($id)
    {
       User::destroy($id);
        return back();
    }
}
