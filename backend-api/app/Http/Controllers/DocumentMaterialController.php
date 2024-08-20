<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventDocumentResource;
use App\Models\DocumentMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class DocumentMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $destinationPath;

    public function __construct()
    {
        $this->destinationPath = 'events/documents';
    }
    public function upload(Request $request ){
        // Validate the request
        $request->validate([
            'document' => 'required|extensions:pdf,xlsx|max:2048', // less 2MB
            'name' => 'required', // 
            'conference_id' => 'required', // 
        ]);

        // Handle the file upload
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $user_id = Auth::id();
            // Generate a unique file name
            $filename = $request->file('name').'-'.Str::uuid() . '.' . $file->getClientOriginalExtension();
            // Store directory
            // $file->move($this->destinationPath, $filename);
            $filePath = $file->storeAs('events/documents', $filename, 'public');
            // Save file information to the database
            $document = new DocumentMaterial();
            $document->name = $request->name;
            $document->user_id = $user_id;
            $document->conference_id = $request->conference_id;
            $document->file_name = $file->getClientOriginalName();
            $document->path = $filename;
            $document->save();

            return response()->json([
                'message' => 'Document uploaded successfully',
                'data' => $document
            ], 201);
        }

        return response()->json(['error' => 'Failed to uploaded'], 400);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        //
        $conferenceDocs = EventDocumentResource::collection(DocumentMaterial::all()->sortByDesc('createdDate'));
        if($conferenceDocs){
            return response()->json([
                'message'=> "Conference Docs Fetch Success",
                'data' => $conferenceDocs,
                'code' => 200,
            ]);
        }
        return response()->json([
            'message'=> "No Docs found",
            'code' => 300,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentMaterial $documentMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentMaterial $documentMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentMaterial $documentMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentMaterial $documentMaterial)
    {
        //
    }
}
