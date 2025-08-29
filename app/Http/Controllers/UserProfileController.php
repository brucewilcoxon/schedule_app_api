<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileStoreRequest;
use App\UseCases\UserProfileStoreAction;
use App\UseCases\UserProfile\UserProfileIndexAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function index(UserProfileIndexAction $action)
    {
        return $action();
    }

    public function store(UserProfileStoreRequest $request, UserProfileStoreAction $action)
    {
        return $action($request);
    }

    public function uploadImage(Request $request)
    {
        \Log::info('Profile image upload request received', [
            'user_id' => auth()->id(),
            'has_file' => $request->hasFile('image'),
            'file_size' => $request->file('image') ? $request->file('image')->getSize() : 'no file'
        ]);

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            \Log::error('Profile image upload validation failed', [
                'errors' => $validator->errors()
            ]);
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            \Log::info('Attempting to save file', [
                'original_name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'upload_path' => public_path('upload')
            ]);
            
            // Store file in public/upload directory
            $file->move(public_path('upload'), $fileName);
            
            // Return the file path that will be stored in database
            $filePath = 'upload/' . $fileName;
            
            \Log::info('File uploaded successfully', [
                'file_path' => $filePath,
                'full_path' => public_path('upload/' . $fileName)
            ]);
            
            return response()->json([
                'success' => true,
                'file_path' => $filePath,
                'message' => 'Image uploaded successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile image upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Upload failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
