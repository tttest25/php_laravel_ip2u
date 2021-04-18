<?php

namespace App\Http\Controllers;

use App\Cservice as Cservice;
use App\Example;
use Illuminate\Http\Request;
use App\Models\DocumentStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    protected Example $example;

    public function __construct()
    {

    }
/**
 * undocumented function summary
 *
 * Undocumented function long description
 *
 * @param Type $var Description
 * @return type
 * @throws conditon
 **/
public function home(Example $example)
{

    $this->example=$example;
    ddd($example);
}
    //

    /**
     * show method
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function showPost(string $post )
    {
        $name = request('name','empty_name_param');
        // DB facade
        // $data = DB::table('documentstore')->where('slug',$post)->first();
        // Eloquent
        $data = DocumentStore::where('slug',$post)->firstOrFail();

        ddd($data->attributes);
        return view('test', ['name' => $name,'slug' => $post, "content"=> $data->attributes ?? 'no content']);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        return view('fileUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)
    {
        return $_FILES;
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);

        $fileName = time().'.'.$request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);

        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);

    }

    /**
     * test sign
     *
     * procedure get data for test sign
     *
     * @param
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws conditon
     **/
    public function TestSign(Cservice $cservice)
    {
      $sign = request()->only(['datab64', 'signb64']);
      return $cservice->verifyD($sign['datab64'],$sign['signb64']);

    }
}
