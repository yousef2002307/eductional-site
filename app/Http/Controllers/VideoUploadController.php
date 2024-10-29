<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;

// class VideoUploadController extends Controller
// {
//     public function showUploadForm()
//     {
//         return view('upload');
//     }

//     public function upload(Request $request)
//     {
//         $request->validate([
//             'video' => 'required|file', // Max size 20MB
//         ]);

//         // Get the uploaded file
//         $file = $request->file('video');

//         // Store the file in Google Drive
//         $path = Storage::disk('google')->putFile('MrOmarsite', $file);

//         return back()->with('success', 'Video uploaded successfully to Google Drive: ' . $path);
       
//     }
// }
