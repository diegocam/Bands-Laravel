<?php

namespace App\Http\Controllers;

use App\Album;
use App\Band;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class albumsController extends Controller
{
    /**
     * This page will show a table listing all the albums in the system. Those albums will not be fetched
     * at this point as those will be fetched via AJAX. This method will also retrieve all the bands in
     * the system and pass them to the view as an array. The Bands array will be used for filtering down
     * the albums results ("filter by band").
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * This method will render a page that allows the user to create an album via an an HTML form.
     * It will also send an array of Bands in the system so that the user links the Album to a band.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * This method will render a page that allows the user to edit a current album (fetched by its ID)
     * via an HTML form. It will also send an array of Bands in the system so that the user links the Album
     * to a band. Lastly, it will make sure to convert any dates properly for the view
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * This method will process an "album edit" form submission. It will make sure to validate the 'name' as
     * required, and the 'band_id' as required and existing in the database. If validation passes, it updates the
     * changes to the corresponding album in the database, making sure any dates are properly formatted for the DB,
     * and redirects them to the current album's edit page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * This method will process an "album create" form submission. It will make sure to validate
     * the 'name' as required, and the 'band_id' as required and existing in the database. If validation passes,
     * it inserts the new album to the database, making sure any dates are properly formatted for the DB,
     * and redirects the user to the new album's edit page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * This method will delete an album from the database via its ID
     *
     * @param int $id
     */
    public function delete($id)
    {
        Album::destroy($id);
    }

    /**
     * This method will be called via AJAX using the DataTables library. Its purpose is to return an array
     * of the Albums(with their corresponding band) in the system in JSON format, specifically for DataTables,
     * making sure all columns are properly formatted for the view.
     *
     * @return mixed
     */
    public function dataTables()
    {
        $albums = Album::with('band')->select('albums.*');
        return Datatables::of($albums)
            ->editColumn('recorded_date', function ($album) {
                return $album->recorded_date ? with(new Carbon($album->recorded_date))->format('m-d-Y') : '';
            })
            ->editColumn('release_date', function ($album) {
                return $album->release_date ? with(new Carbon($album->release_date))->format('m-d-Y') : '';
            })
            ->addColumn('action', function ($album) {
                return "<a href='" . route('albums.edit', ['id' => $album->id]) . "' class='editor_edit'>Edit</a> | <a href=':javascript' data-id='$album->id' class='deleteRow'>Delete</a>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
