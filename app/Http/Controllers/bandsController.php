<?php

namespace App\Http\Controllers;

use App\Band;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class bandsController extends Controller
{
    /**
     * This page will show a table listing all the bands in the system. Those bands will not be fetched
     * at this point as those will be fetched via AJAX at page load.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            "page_title" => "Bands",
            "page_description" => "List of bands"
        ];
        return view('pages.bands.list', $data);
    }

    /**
     * This method will render a page that allows the user to create a band via an HTML form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = [
            "page_title" => "Band",
            "page_description" => "Create Band",
            "form_action" => route('bands.store'),
        ];
        return view('pages.bands.edit', $data);
    }

    /**
     * This method will render a page that allows the user to edit a current band (fetched by its ID)
     * via an HTML form. It will also send an array of its corresponding albums so that the user can easily
     * edit them. Lastly, it will make sure to convert any dates properly for the view
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * This method will process a "band edit" form submission. It will make sure to validate the 'name' as
     * required. If validation passes, it updates the changes to the corresponding band in the database,
     * making sure any dates are properly formatted for the DB, and redirects them to the current bands's edit page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * This method will process a "band create" form submission. It will make sure to validate the 'name'
     * as required. If validation passes, it inserts the new band to the database, making sure any dates are
     * properly formatted for the DB, and redirects the user to the new band's edit page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * This method will be called via AJAX using the DataTables library. Its purpose is to return an array
     * of the Bands in the system in JSON format, specifically for DataTables, making sure all columns are
     * properly formatted for the view.
     *
     * @return mixed
     */
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

    /**
     * This method will delete a band from the database via its ID
     *
     * @param int $id
     */
    public function delete($id)
    {
        Band::destroy($id);
    }
}
