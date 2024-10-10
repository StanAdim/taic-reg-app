<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventDocumentResource;
use App\Models\DocumentMaterial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;




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

    public function docUpload(Request $request){
          // Validate the request
          $request->validate([
            'document' => 'required|extensions:pdf,xlsx', // less 2MB
            'name' => 'required', // 
            'conference_id' => 'required', // 
        ]);
        DB::beginTransaction();
        try {
            if (!($request->document instanceof \Illuminate\Http\UploadedFile)) {
                return response()->json(['message' => "Attachment not found"], 400);
            }
            $file = $request->file('document');
            $filename =  time() . '_' .str_replace(' ', '',$file->getClientOriginalName());
            $filename = $file->storeAs('documents', $filename, 'local');
            $user_id = Auth::id();


            $document = new DocumentMaterial();
            $document->name = $request->name;
            $document->user_id = $user_id;
            $document->conference_id = $request->conference_id;
            $document->file_name = $file->getClientOriginalName();
            $document->path = $filename;
            $document->save();
            DB::commit();
            return response()->json(['message' => 'File Uploaded successfully'], 200);
        } catch (Exception $e) {
            Db::rollBack();
            Log::error($e);
            return response()->json(['message' => "Failed to upload guidelines"], 400);
        }
    }
    public function index(){
        //
        $isAdmin = Auth::user()->role->name === 'admin';
        $isAdmin ? $adminDoc = DocumentMaterial::all() : $adminDoc = DocumentMaterial::where('status',1)->get();
        $conferenceDocs = EventDocumentResource::collection($adminDoc->sortByDesc('createdDate'));

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
    //Get Document public
    public function getDocumentByName($name){
        $data = DocumentMaterial::where('name', $name);
        $exists = $data -> exists();
        if($exists){
            $file_name  =  $data->first()->path;
            if (!Storage::disk('local')->exists($file_name)) {
                abort(404);
            }
            $pdfPath = storage_path('app/'. $file_name);
            return response()->file($pdfPath);
        }
        return response()->json(['message' => 'File not found'], 500);
    }
    //Update
    public function updateStatus($id) {
        $dataTgt = DocumentMaterial::findOrFail($id);
        $dataTgt->status = !$dataTgt->status;
        $dataTgt->save();
        return response()->json(['message' => 'Status updated successfully'], 200);
    }
     // Delete 
     public function destroy($id)
     {
         $supportRequest = DocumentMaterial::findOrFail($id);
         $supportRequest->delete();
         return response()->json(['message' => 'Event Doc deleted successfully'], 200);
     }
     
}
