<?php

namespace App\Http\Controllers;

use App\Album;
use App\Band;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class albumsController extends Controller
{
    public function index()
    {
        $bands = Band::query()->get();
        $data = [
            "page_title" => "Albums",
            "page_description" => "List of albums",
            "bands" => $bands
        ];
        return view('pages.albums.list', $data);
    }

    public function create()
    {
        $bands = Band::query()->get();
        $data = [
            "page_title" => "Album",
            "page_description" => "Create Album",
            "form_action" => route('albums.store'),
            "bands" => $bands
        ];
        return view('pages.albums.edit', $data);
    }

    public function edit($id)
    {
        $bands = Band::query()->get();
        $album = Album::query()->find($id);
        $album->recorded_date = (new Carbon($album->recorded_date))->format('m/d/Y');
        $album->release_date = (new Carbon($album->release_date))->format('m/d/Y');
        $data = [
            "page_title" => "Album",
            "page_description" => "Edit Album",
            "form_action" => route('albums.update'),
            "album" => $album,
            "bands" => $bands
        ];
        return view('pages.albums.edit', $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'band_id' => 'required|exists:bands,id'
        ]);

        $album = Album::query()->find( $request->id);
        $album->band_id = $request->band_id;
        $album->name = $request->name;
        $album->recorded_date = (new Carbon($request->recorded_date))->format('Y-m-d');
        $album->release_date = (new Carbon($request->release_date))->format('Y-m-d');
        $album->numberoftracks = $request->numberoftracks;
        $album->label = $request->label;
        $album->producer = $request->producer;
        $album->genre = $request->genre;
        $album->save();
        return redirect(route('albums.edit', ["id" =>$album->id]))->with('message', 'Album updated!');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'band_id' => 'required|exists:bands,id'
        ]);

        $album = new Album();
        $album->band_id = $request->band_id;
        $album->name = $request->name;
        $album->recorded_date = (new Carbon($request->recorded_date))->format('Y-m-d');
        $album->release_date = (new Carbon($request->release_date))->format('Y-m-d');
        $album->numberoftracks = $request->numberoftracks;
        $album->label = $request->label;
        $album->producer = $request->producer;
        $album->genre = $request->genre;
        $album->save();
        return redirect(route('albums.edit', ["id" =>$album->id]))->with('message', 'Album saved!');
    }

    public function delete($id)
    {
        Album::destroy($id);
    }

    public function dataTables()
    {
        $albums = Album::with('band')->select('albums.*');
        return Datatables::of($albums)
            ->addColumn('action', function ($album) {
                return "<a href='" . route('albums.edit', ['id' => $album->id]) . "' class='editor_edit'>Edit</a> | <a href=':javascript' data-id='$album->id' class='deleteRow'>Delete</a>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
