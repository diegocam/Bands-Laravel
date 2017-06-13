<?php

namespace App\Http\Controllers;

use App\Band;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class bandsController extends Controller
{
    public function index()
    {
        $data = [
            "page_title" => "Bands",
            "page_description" => "List of bands"
        ];
        return view('pages.bands.list', $data);
    }

    public function create()
    {
        $data = [
            "page_title" => "Band",
            "page_description" => "Create Band",
            "form_action" => route('bands.store'),
        ];
        return view('pages.bands.edit', $data);
    }

    public function edit($id)
    {
        $band = Band::query()->find($id);
        $band->start_date = (new Carbon($band->start_date))->format('m/d/Y');
        $data = [
            "page_title" => "Band",
            "page_description" => "Edit Band",
            "form_action" => route('bands.update'),
            "band" => $band,
            "albums" => $band->albums
        ];
        return view('pages.bands.edit', $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $band = Band::query()->find($request->id);
        $band->name = $request->name;
        $band->start_date = (new Carbon($request->start_date))->format('Y-m-d');
        $band->website = $request->website;
        $band->still_active = $request->still_active;
        $band->save();
        return redirect(route('bands.edit', ["id" => $band->id]))->with('message', 'Band updated!');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $band = new Band();
        $band->name = $request->name;
        $band->start_date = (new Carbon($request->start_date))->format('Y-m-d');
        $band->website = $request->website;
        $band->still_active = $request->still_active;
        $band->save();
        return redirect(route('bands.edit', ["id" => $band->id]))->with('message', 'Band saved!');
    }

    public function dataTables()
    {
        $bands = Band::query();
        return Datatables::of($bands)
            ->editColumn('start_date', function ($band) {
                return $band->start_date ? with(new Carbon($band->start_date))->format('m-d-Y') : '';
            })
            ->editColumn('still_active', function ($band) {
                return $band->still_active ? "Yes" : "No";
            })
            ->editColumn('website', function ($band) {
                return "<a target='_blank' href='$band->website'>$band->website</a>";
            })
            ->addColumn('action', function ($band) {
                return "<a href='" . route('bands.edit', ['id' => $band->id]) . "' class='editor_edit'>Edit</a> | <a href=':javascript' data-id='$band->id'  class='deleteRow'>Delete</a>";
            })
            ->rawColumns(['website', 'action'])
            ->make(true);
    }

    public function delete($id)
    {
        Band::destroy($id);
    }
}
