<?php

namespace App\Http\Controllers;

use App\Cservice;
use App\Models\Files;
use App\Models\Signs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Files $file)
    {
        //

        return view('fileSign', ['fileid' => $file]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Files $file,Cservice $cservice)
    {

        $user = Auth::user();

        $data=request()->validate([
            'signb64'  => 'required',
            'fileid'   => 'required',
        ]);

        $data=$cservice->verifyD(base64_encode(Storage::get($file->filepath)),request()->signb64);

        $serial=$data['signers'][0]['serialNumber'];

        if ($user->CSPserials->where('serialNumber',$serial )->isEmpty()) {
            return back()
            ->withErrors(array_merge(["Сертификат c serial {$serial} не закреплен за текущим пользователем !"]))
            ->withInput();
        }

        if ( !( $data['status'] === "ok" ) ) {

            return back()
                        ->withErrors(array_merge(['Сертификат не прошел проверку !'],$data))
                        ->withInput();

        } else {

            $sign = new Signs(['signobj' => $data, 'signpath' => $this->saveFileB64(request()->signb64)]);
            $file->signs()->save($sign);


            return redirect()->route('documents');

        }

    }


    /**
     * save file to files model
     *
     * save file if exist in request
     *
     * @param String  $b64
     * @return string
     * @throws conditon
     **/
    public function saveFileB64(String  $b64)
    {
        $filename='sign'.date("Ym").'/'.Str::random(40);
         Storage::put($filename, base64_decode($b64));
         return $filename;

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Default working mode

        $sign = new Signs($this->reqSignsValidate($request));
        $sign->save();
        $sign->saveFile($request->file);

        return redirect()->route('signs.show');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Signs  $signs
     * @return \Illuminate\Http\Response
     */
    public function show(Signs $sign)
    {
        //
        return view('signs.show')->with('sign',$sign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Signs  $signs
     * @return \Illuminate\Http\Response
     */
    public function edit(Signs $signs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Signs  $signs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signs $signs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signs  $signs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signs $signs)
    {
        //
    }


    /**
     * download binary file specified resource from storage.
     *
     * @param  \App\Models\Signs  $signs
     * @return \Illuminate\Http\Response
     */
    public function download(Signs $sign)
    {
        //
        return Storage::download($sign->signpath,"{$sign->files->filename}.sig");
    }

 /**
     * request validation
     *
     * return data or exception
     * {2 entries
     *    slug: "testnew12",
     *    objstore: "[1,2]"
     *}
     *
     * @param Type $var Description
     * @return array
     * @throws exception of required
     **/
    public function reqSignsValidate()
    {
        // files
        // array:1 [▼
        //   "file" => array:5 [▼
        //     "name" => "0.pdf"
        //     "type" => "application/pdf"
        //     "tmp_name" => "/tmp/phpL2QXYC"
        //     "error" => 0
        //     "size" => 22977
        // ]
        // ]

        $data=request()->validate([
            'signpath'  => 'required',
            'signobj'   => 'required',
            'file_id'   => 'required',
            'file' => 'max:2048',
        ]);

        dd($data);

        try {
            $obj=json_decode(request('signobj'),true, $depth=512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['signobj' => 'Not correct Json - signobj']);
        }

        $data['signobj']=$obj;
        return $data;
    }

}
