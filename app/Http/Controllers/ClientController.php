<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;
use function PHPUnit\Framework\returnArgument;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::select("*")->where('user_id',auth()->user()->id)->orderBy('id', 'Desc');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =  '<a class="btn btn-sm btn-secondary" href="'.route('clients.edit', $row->id) .'">Edit</a>';
                if(count($row->notices) == 0){
                    $btn .= 
                    '<form action="'. route('clients.destroy', $row->id) .'" method="POST" style="display:inline;">
                      <input type="hidden" name="_token" value="'. csrf_token() .'">
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                      </form>';
                }

                return $btn;
            })
             ->rawColumns(['action'])
            ->make(true);
        }
        $data = Client::all();
        return view('clients.index', compact('data'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name'=> 'required',
            'category'=> 'required',
        ]);
        $client = Client::create([
            'name' => ucfirst($request->name),
            'category' => $request->category,
            'location' => auth()->user()->location,
            'user_id' => auth()->user()->id,
            ]
        );
        Storage::disk('public')->makeDirectory(auth()->user()->id . '/' . ucfirst($client->name));
        
        return Redirect::route('clients')->with('success', 'Client created Successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request,Client $client)
    {
         $request->validate([
            'name'=> 'required',
            'category'=> 'required',
        ]);

        if (Storage::disk('public')->exists(auth()->user()->id . '/' . $client->name)) {
            Storage::disk('public')->move(auth()->user()->id . '/' . $client->name, auth()->user()->id . '/' . ucfirst($request->name));
        }
        $client->update([
            'name' => ucfirst($request->name),
            'category' => $request->category,
            ]
        );

        return Redirect::route('clients')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        if (Storage::disk('public')->exists(auth()->user()->id . '/' . $client->name)) {
            Storage::disk('public')->deleteDirectory(auth()->user()->id . '/' . $client->name);
        }
        $client->delete();

        return Redirect::back()->with('success', 'Client deleted.');
    }
}
