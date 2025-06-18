<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Notice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\NoticeDocument;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class NoticeController extends Controller
{

    public function index(Request $request)
    {

        $years = Notice::where('user_id', auth()->user()->id)->distinct()->get(['tax_year']);
        $clients = Client::where('user_id', auth()->user()->id)->get();

        $notices = Notice::query()->where('user_id', auth()->user()->id);

        if ($request->ajax()) {
            if ($request->client_id) {
                $notices->where('client_id', $request->client_id);
            }

            if ($request->year) {
                $notices->where('tax_year', $request->year);
            }

            if ($request->office) {
                $notices->where('tax_office', $request->office);
            }
            if ($request->status != null) {
                $notices->where('status', $request->status);
            }

            return DataTables::of($notices)
                ->addIndexColumn()
                ->addColumn('client', function ($row) {
                    return $row->client ? $row->client->name : 'None';
                })
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == '1') {
                        $st = '<a class="btn btn-sm btn-success" onclick="return confirm(\'Are you sure you want to change the status?\')" href="' . route('notices.change', [$row->id]) . '">Complete</a>';
                    } else {
                        $st = '<a class="btn btn-sm btn-warning" onclick="return confirm(\'Are you sure you want to change the status?\')" href="' . route('notices.change', [$row->id]) . '">Pending</a>';
                    }
                    return $st;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-sm btn-secondary m-1" href="' . route('notices.show', $row->id) . '">View</a>';
                    $btn .= '<a class="btn btn-sm btn-primary m-1" href="' . route('notices.edit', $row->id) . '">Edit</a>';
                    $btn .=
                        '<form action="' . route('notices.destroy', $row->id) . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>';

                    return $btn;
                })
                ->rawColumns(['status', 'action', 'client'])
                ->make(true);

        }

        return view('notices.index', compact('notices', 'clients', 'years'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => ['required'],
            'tax_authority' => ['required'],
            'tax_office' => ['required'],
            'notice_heading' => ['required'],
            'commissioner' => [], // Optional field
            'tax_year' => ['required'],
            'receiving_date' => ['required'],
            'due_date' => [],     // Optional field
            'hearing_date' => [], // Optional field
            'notice' => ['required', 'file', 'max:1024', 'mimes:pdf,jpg'],
        ], [
            'client_id.required' => 'The Client field is required.',
            'tax_authority.required' => 'The Tax Authority field is required.',
            'tax_office.required' => 'The Tax Office field is required.',
            'notice_heading.required' => 'The Notice Heading field is required.',
            'tax_year.required' => 'The Tax Year field is required.',
            'receiving_date.required' => 'The Receiving Date field is required.',
            'notice.required' => 'The Notice file is required.',
            'notice.file' => 'The Notice must be a valid file.',
            'notice.max' => 'The Notice file may not be greater than 1MB.',
            'notice.mimes' => 'The Notice must be a file of type: pdf or jpg.',
        ]);

        $notice = Notice::create(
            [
                'client_id' => $request->client_id,
                'tax_authority' => $request->tax_authority,
                'tax_office' => $request->tax_office,
                'notice_heading' => $request->notice_heading,
                'commissioner' => $request->commissioner ?? null,
                'tax_year' => $request->tax_year,
                'receiving_date' => $request->receiving_date,
                'due_date' => $request->due_date ?? null,
                'hearing_date' => $request->hearing_date ?? null,
                'user_id' => auth()->user()->id,
            ]
        );


        $client = Client::where('id', $notice->client_id)->first();

        if ($client && $request->file('notice')) {
            $folder = auth()->user()->id . '/' . ucfirst($client->name);
            $name = rand('0000', '9999') . '_' . $request->file('notice')->getClientOriginalName();
            if (Storage::disk('public')->exists($folder . '/' . ucfirst($request->tax_year))) {
                $folder = $folder . '/' . ucfirst($request->tax_year);
            } else {
                Storage::disk('public')->makeDirectory($folder . '/' . ucfirst($request->tax_year));
                $folder = $folder . '/' . ucfirst($request->tax_year);
            }
            $path = $request->file('notice')->storeAs($folder, $name, 'public');

            $notice->update([
                'notice_name' => $name,
                'notice_path' => $path,
            ]);
        }
        return Redirect::route('notices')->with('success', 'Notice created.');
    }

    public function show($id)
    {
        $notice = Notice::find($id);
        if (!$notice) {
            abort(404);
        }
        $clients = Client::where('user_id', auth()->user()->id)->get();
        return view('notices.show', compact('notice', 'clients'));
    }
    public function edit(Notice $notice)
    {
        $clients = Client::where('user_id', auth()->user()->id)->get();
        $baseQuery = NoticeDocument::where('notice_id', $notice->id)
            ->where('user_id', auth()->id());

        $replyCount = (clone $baseQuery)->where('type', 'reply')->count();
        $orderCount = (clone $baseQuery)->where('type', 'order')->count();
        $receivedCount = (clone $baseQuery)->where('type', 'received')->count();
        $documents = NoticeDocument::where('notice_id', $notice->id)
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy('type');
        return view('notices.edit', compact('notice', 'documents', 'replyCount', 'orderCount', 'receivedCount', 'clients'));

    }

    // public function update(Request $request, Notice $notice)
    // {
    //     $request->validate([
    //         'client_id' => ['required'],
    //         'tax_authority' => ['required'],
    //         'tax_office' => ['required'],
    //         'notice_heading' => ['required'],
    //         'commissioner' => [],
    //         'tax_year' => ['required'],
    //         'receiving_date' => ['required'],
    //         'due_date' => [],
    //         'hearing_date' => [],
    //         'reply' => ['nullable', 'file', 'max:1024', 'mimes:pdf,jpg'],
    //         'order' => ['nullable', 'file', 'max:1024', 'mimes:pdf,jpg'],
    //         'received' => ['nullable', 'file', 'max:1024', 'mimes:pdf,jpg'],
    //     ], [
    //         'client_id.required' => 'The Client field is required.',
    //         'tax_authority.required' => 'The Tax Authority field is required.',
    //         'tax_office.required' => 'The Tax Office field is required.',
    //         'notice_heading.required' => 'The Notice Heading field is required.',
    //         'tax_year.required' => 'The Tax Year field is required.',
    //         'receiving_date.required' => 'The Receiving Date field is required.',
    //         'reply.max' => 'The Reply file may not be greater than 1MB.',
    //         'order.max' => 'The Order file may not be greater than 1MB.',
    //         'reply.mimes' => 'The Reply must be a file of type: pdf, jpg.',
    //         'order.mimes' => 'The Order must be a file of type: pdf, jpg.',
    //     ]);


    //     $oldClient = Client::find($notice->client_id);
    //     $newClient = Client::find($request->client_id);
    //     $oldYear = $notice->tax_year;
    //     $newYear = $request->tax_year;

    //     $oldFolder = auth()->id() . '/' . ucfirst($oldClient->name) . '/' . ucfirst($oldYear);
    //     $newFolder = auth()->id() . '/' . ucfirst($newClient->name) . '/' . ucfirst($newYear);

    //     // Move files if year or client changed
    //     if ($oldClient->id !== $newClient->id || $oldYear !== $newYear) {
    //         Storage::disk('public')->makeDirectory($newFolder);

    //         foreach (['reply', 'order', 'notice'] as $type) {
    //             $nameField = $type . '_name';
    //             $pathField = $type . '_path';

    //             if ($notice->$pathField && Storage::disk('public')->exists($notice->$pathField)) {
    //                 $oldPath = $notice->$pathField;
    //                 $fileName = basename($oldPath);
    //                 $newPath = $newFolder . '/' . $fileName;

    //                 Storage::disk('public')->move($oldPath, $newPath);

    //                 $notice->$nameField = $fileName;
    //                 $notice->$pathField = $newPath;
    //             }
    //         }

    //         $notice->save();

    //         // If only year changed (same client)
    //         if ($oldClient->id === $newClient->id && $oldYear !== $newYear) {
    //             if (empty(Storage::disk('public')->allFiles($oldFolder))) {
    //                 Storage::disk('public')->deleteDirectory($oldFolder);
    //             }
    //         }

    //         // If client changed
    //         if ($oldClient->id !== $newClient->id) {
    //             $oldClientYearFolder = auth()->id() . '/' . ucfirst($oldClient->name) . '/' . ucfirst($oldYear);
    //             if (empty(Storage::disk('public')->allFiles($oldClientYearFolder))) {
    //                 Storage::disk('public')->deleteDirectory($oldClientYearFolder);
    //             }
    //         }
    //     }

    //     // Handle uploaded files (reply/order)
    //     foreach (['reply', 'order'] as $type) {
    //         if ($request->hasFile($type)) {
    //             $name = rand(1000, 9999) . '_' . $request->file($type)->getClientOriginalName();
    //             $path = $request->file($type)->storeAs($newFolder, $name, 'public');

    //             $notice->update([
    //                 $type . '_name' => $name,
    //                 $type . '_path' => $path,
    //             ]);
    //         }
    //     }

    //     // Final update of notice fields
    //     $notice->update([
    //         'client_id' => $request->client_id,
    //         'tax_authority' => $request->tax_authority,
    //         'tax_office' => $request->tax_office,
    //         'notice_heading' => $request->notice_heading,
    //         'commissioner' => $request->commissioner,
    //         'tax_year' => $request->tax_year,
    //         'receiving_date' => $request->receiving_date,
    //         'due_date' => $request->due_date ?? null,
    //         'hearing_date' => $request->hearing_date ?? null,
    //     ]);

    //     return redirect()->route('notices')->with('success', 'Notice updated successfully.');
    // }





    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'client_id' => ['required'],
            'tax_authority' => ['required'],
            'tax_office' => ['required'],
            'notice_heading' => ['required'],
            'commissioner' => [],
            'tax_year' => ['required'],
            'receiving_date' => ['required'],
            'due_date' => [],
            'hearing_date' => [],
            'reply' => ['nullable', 'file', 'max:1024', 'mimes:pdf,jpg'],
            'order' => ['nullable', 'file', 'max:1024', 'mimes:pdf,jpg'],
            'received' => ['nullable', 'file', 'max:1024', 'mimes:pdf,jpg'],
        ], [
            'client_id.required' => 'The Client field is required.',
            'tax_authority.required' => 'The Tax Authority field is required.',
            'tax_office.required' => 'The Tax Office field is required.',
            'notice_heading.required' => 'The Notice Heading field is required.',
            'tax_year.required' => 'The Tax Year field is required.',
            'receiving_date.required' => 'The Receiving Date field is required.',
            'reply.max' => 'The Reply file may not be greater than 1MB.',
            'order.max' => 'The Order file may not be greater than 1MB.',
            'received.max' => 'The Received file may not be greater than 1MB.',
            'reply.mimes' => 'The Reply must be a file of type: pdf, jpg.',
            'order.mimes' => 'The Order must be a file of type: pdf, jpg.',
            'received.mimes' => 'The Received must be a file of type: pdf, jpg.',
        ]);

        $oldClient = Client::find($notice->client_id);
        $newClient = Client::find($request->client_id);
        $oldYear = $notice->tax_year;
        $newYear = $request->tax_year;

        $oldFolder = auth()->id() . '/' . ucfirst($oldClient->name) . '/' . ucfirst($oldYear);
        $newFolder = auth()->id() . '/' . ucfirst($newClient->name) . '/' . ucfirst($newYear);

        // Check if client or year has changed
        if ($oldClient->id !== $newClient->id || $oldYear !== $newYear) {
            Storage::disk('public')->makeDirectory($newFolder);

            // Move main notice file if it exists
            if ($notice->notice_path && Storage::disk('public')->exists($notice->notice_path)) {
                $fileName = basename($notice->notice_path);
                $newPath = $newFolder . '/' . $fileName;

                if (!Storage::disk('public')->exists($newPath)) {
                    try {
                        Storage::disk('public')->move($notice->notice_path, $newPath);
                    } catch (\Throwable $e) {
                        \Log::error("Failed to move notice file: " . $e->getMessage());
                    }
                }

                $notice->update([
                    'notice_path' => $newPath,
                    'notice_name' => $fileName,
                ]);
            }

            // Move associated document files
            $documents = $notice->noticeDocuments ?? collect();

            if ($documents->isNotEmpty()) {
                foreach ($documents as $document) {
                    if ($document->path && Storage::disk('public')->exists($document->path)) {
                        $fileName = basename($document->path);
                        $newDocPath = $newFolder . '/' . $fileName;

                        if (!Storage::disk('public')->exists($newDocPath)) {
                            try {
                                Storage::disk('public')->move($document->path, $newDocPath);
                            } catch (\Throwable $e) {
                                \Log::error("Failed to move document file: " . $e->getMessage());
                            }
                        }

                        $document->update([
                            'path' => $newDocPath,
                        ]);
                    }
                }
            }

            // Delete old folder if empty
            try {
                if (empty(Storage::disk('public')->allFiles($oldFolder))) {
                    Storage::disk('public')->deleteDirectory($oldFolder);
                }
            } catch (\Throwable $e) {
                \Log::warning("Could not delete old folder $oldFolder: " . $e->getMessage());
            }
        }

        // Handle new uploads: reply, order, received
        foreach (['reply', 'order', 'received'] as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);
                $originalName = $file->getClientOriginalName();
                $name = rand(1000, 9999) . '_' . $originalName;
                $path = $file->storeAs($newFolder, $name, 'public');

                $headingField = $type . '_heading';
                $dateField = $type . '_date';

                NoticeDocument::create([
                    'user_id' => auth()->id(),
                    'notice_id' => $notice->id,
                    'type' => $type,
                    'name' => $request->$headingField ?? ucfirst($type),
                    'date' => $request->$dateField ?? now(),
                    'path' => $path,
                ]);
            }
        }

        // Update notice fields
        $notice->update([
            'client_id' => $request->client_id,
            'tax_authority' => $request->tax_authority,
            'tax_office' => $request->tax_office,
            'notice_heading' => $request->notice_heading,
            'commissioner' => $request->commissioner,
            'tax_year' => $request->tax_year,
            'receiving_date' => $request->receiving_date,
            'due_date' => $request->due_date ?? null,
            'hearing_date' => $request->hearing_date ?? null,
        ]);

        return redirect()->route('notices')->with('success', 'Notice updated successfully.');
    }



    public function change($notice)
    {
        $notice = Notice::find($notice);
        if ($notice) {
            if ($notice->status == 1) {
                $notice->status = 0;
                $notice->save();
            } else {
                $notice->status = 1;
                $notice->save();
            }
        } else {
            abort(404);
        }
        return Redirect::route('notices')->with('success', 'Status updated.');
    }

    public function destroy(Notice $notice)
    {
        // Count how many notices exist for the same client and tax year
        $notices = Notice::where('client_id', $notice->client_id)
            ->where('tax_year', $notice->tax_year)
            ->count();

        if ($notices > 1) {
            // Delete main notice file if it exists
            if ($notice->notice_path && Storage::disk('public')->exists($notice->notice_path)) {
                Storage::disk('public')->delete($notice->notice_path);
            }

            // Delete related noticeDocuments (reply, order, received)
            foreach ($notice->noticeDocuments as $doc) {
                if ($doc->path && Storage::disk('public')->exists($doc->path)) {
                    Storage::disk('public')->delete($doc->path);
                }
                $doc->delete(); // delete DB row
            }

        } else {
            // Delete entire folder if this is the only notice in this group
            $folder = auth()->user()->id . '/' . $notice->client->name . '/' . $notice->tax_year;
            if (Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->deleteDirectory($folder);
            }
        }

        // Delete the main notice row
        $notice->delete();

        return Redirect::back()->with('success', 'Notice deleted.');
    }


}
