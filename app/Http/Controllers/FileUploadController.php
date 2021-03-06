<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;

class FileUploadController extends Controller
{
    public  function dropzoneUi()  
    {  
        return view('dropzone-file-upload');  
    }  

    /** 
     * File Upload Method 
     * 
     * @return void 
     */  

    public  function dropzoneFileUpload(Request $request)  
    {  
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension(); 
        $image->move(public_path('images'),$imageName);  

        return response()->json(['success'=>$imageName]);
    }

    ////////////////////////////////////////////////////////////////////

    public function index()
    {

        $files = FileUpload::all();

        return view('files.index', compact('files'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->file('file');
        $FileName = $image->getClientOriginalName();
        $image->move(public_path('images'), $FileName);

        $imageUpload = new FileUpload();
        $imageUpload->filename = $FileName;
        $imageUpload->save();
        return response()->json(['success' => $FileName]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function show(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function edit(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileUpload $fileUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $fileUpload = FileUpload::find($id);

        $fileUpload->delete();

        return redirect()->back()
            ->with('success', 'File deleted successfully');
    }
}
