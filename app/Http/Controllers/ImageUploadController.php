<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Log PHP configuration for debugging
        Log::info('Image upload request received', [
            'user_id' => auth()->id(),
            'has_file' => $request->hasFile('image'),
            'file_size' => $request->file('image') ? $request->file('image')->getSize() : 'no file',
            'php_upload_max_filesize' => ini_get('upload_max_filesize'),
            'php_post_max_size' => ini_get('post_max_size'),
            'php_max_execution_time' => ini_get('max_execution_time'),
            'content_length' => $request->header('Content-Length'),
        ]);

        // Check if file was actually received (might be blocked by PHP limits)
        if (!$request->hasFile('image') && $request->header('Content-Length')) {
            $contentLength = (int) $request->header('Content-Length');
            $postMaxSize = $this->parseSize(ini_get('post_max_size'));
            
            if ($contentLength > $postMaxSize) {
                Log::error('Upload blocked by PHP post_max_size limit', [
                    'content_length' => $contentLength,
                    'post_max_size' => $postMaxSize,
                    'upload_max_filesize' => ini_get('upload_max_filesize'),
                ]);

                return response()->json([
                    'error' => 'File too large',
                    'message' => 'ファイルサイズが大きすぎます。サーバーの設定により、アップロードできる最大サイズを超えています。',
                    'max_size' => ini_get('upload_max_filesize'),
                ], 413);
            }
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            Log::error('Image upload validation failed', [
                'errors' => $validator->errors(),
                'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                'php_post_max_size' => ini_get('post_max_size'),
            ]);

            // Provide more specific error message for file size issues
            $errors = $validator->errors();
            if ($errors->has('image') && str_contains($errors->first('image'), 'size')) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => 'ファイルサイズが大きすぎます。5MB以下の画像をアップロードしてください。',
                    'messages' => $validator->errors(),
                ], 422);
            }

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

    /**
     * Parse PHP size string (e.g., "10M", "512K") to bytes
     */
    private function parseSize(string $size): int
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;

        switch ($last) {
            case 'g':
                $size *= 1024;
                // no break
            case 'm':
                $size *= 1024;
                // no break
            case 'k':
                $size *= 1024;
        }

        return $size;
    }
}
