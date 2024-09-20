<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfessinalResource;
use App\Http\Resources\ProfessionaListResource;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Imports\ProfessionalImport;
use Maatwebsite\Excel\Facades\Excel;

class ProfessionalController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'DateOfRegistration' => 'required|string',
            'RegNo' => 'required|string|unique:professionals,RegNo',
            'Name' => 'required|string',
            'Employer' => 'nullable|string',
            'ProfessionalCategory' => 'required|integer',
            'AreaOfSpecialization' => 'nullable|string',
            'Email' => 'required|email|unique:professionals,Email',
            'Mobile' => 'required|string',
            'Gender' => 'required|string',
            'Region' => 'required|string',
        ]);

        // Create a new instance of your model and save the data
        $new_data = new Professional(); 
        $new_data->DateOfRegistration = $validatedData['DateOfRegistration'];
        $new_data->RegNo = $validatedData['RegNo'];
        $new_data->Name = $validatedData['Name'];
        $new_data->Employer = $validatedData['Employer'];
        $new_data->ProfessionalCategory = $validatedData['ProfessionalCategory'];
        $new_data->AreaOfSpecialization = $validatedData['AreaOfSpecialization'];
        $new_data->Email = $validatedData['Email'];
        $new_data->Mobile = $validatedData['Mobile'];
        $new_data->Gender = $validatedData['Gender'];
        $new_data->Region = $validatedData['Region'];

        // Save the new_data
        $new_data->save();

        return response()->json([
            'message' => 'Success Fetching Professional',
            'data' => $new_data
        ],200);
    }

    public function importExel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        try {
            Excel::import(new ProfessionalImport, $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
        
            return response()->json([
                'message' => 'Success importing Professional',
            ], 200);
        
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // If there's a validation error during the import
            $failures = $e->failures();
        
            // Collect the errors
            $duplicateEntries = [];
            foreach ($failures as $failure) {
                $row = $failure->row(); // Row number at which the failure occurred
                $attribute = $failure->attribute(); // Column that caused the failure
                $errors = $failure->errors(); // Error messages
        
                $duplicateEntries[] = [
                    'row' => $row,
                    'attribute' => $attribute,
                    'errors' => $errors,
                ];
            }
        
            return response()->json([
                'message' => 'Error: Duplicate entries found - '.$duplicateEntries,
                'duplicates' => $duplicateEntries,
            ], 409); // 409 Conflict status code
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'error' => $e->getMessage(),
                'code' => 300
            ], 500);
        }
        
    }
    
    public function getProfessionalDetails(Request $request){
            $query = $request->input('reg_number');
            $query = strtoupper(trim($query));
            $result = ProfessinalResource::collection(Professional::where('RegNo' , $query)->get())->first();
        if ($result != []) {
            return response()->json([
                'message' => 'Success Fetching Professional',
                'data' => $result
            ],200);
        } else {
            return response()->json([
                'message' => 'Reg Number Not found',
            ],404);
        }
    }
    public function professionalList(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12); // Default items per page is 12
        // Build the query for fetching users
        $query = Professional::query()->orderBy('created_at', 'asc');
        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('RegNo', 'like', "%{$search}%")
                ->orWhere('Name', 'like', "%{$search}%")
                ->orWhere('Email', 'like', "%{$search}%");
                // ->orWhere('email', 'like', "%{$search}%");
                // Add other fields for search if needed
            });
        }
        // Paginate the results
        $list_data = $query->paginate($perPage);
        if ($list_data->isNotEmpty()) {
            return response()->json([
                'message' => "Application list_data",
                'data' => ProfessionaListResource::collection($list_data),
                'pagination' => [
                    'current_page' => $list_data->currentPage(),
                    'last_page' => $list_data->lastPage(),
                    'per_page' => $list_data->perPage(),
                    'total' => $list_data->total(),
                    'next_page_url' => $list_data->nextPageUrl(),
                    'prev_page_url' => $list_data->previousPageUrl(),
                ],
                'code' => 200,
            ]);
        }

        return response()->json([
            'message' => "No users found",
            'code' => 300,
        ]);
    }
}
