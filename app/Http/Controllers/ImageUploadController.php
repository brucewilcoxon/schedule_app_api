<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        Log::info('Image upload request received', [
            'user_id' => auth()->id(),
            'has_file' => $request->hasFile('image'),
            'file_size' => $request->file('image') ? $request->file('image')->getSize() : 'no file',
        ]);

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            Log::error('Image upload validation failed', [
                'errors' => $validator->errors(),
            ]);

            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors(),
            ], 422);
        }

        try {
            $file = $request->file('image');

            if (! $file) {
                return response()->json([
                    'error' => 'No file uploaded',
                    'message' => 'Please select an image file',
                ], 400);
            }

            // Ensure upload directory exists
            $uploadPath = public_path('upload');
            if (! file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $fileName = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            // Sanitize filename
            $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);

            Log::info('Attempting to save file', [
                'original_name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'upload_path' => $uploadPath,
            ]);

            // Store file in public/upload directory
            $file->move($uploadPath, $fileName);

            // Return the file path that will be stored in database
            $filePath = 'upload/'.$fileName;

            Log::info('File uploaded successfully', [
                'file_path' => $filePath,
                'full_path' => public_path('upload/'.$fileName),
            ]);

            return response()->json([
                'success' => true,
                'file_path' => $filePath,
                'message' => 'Image uploaded successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Image upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'error' => 'Upload failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
