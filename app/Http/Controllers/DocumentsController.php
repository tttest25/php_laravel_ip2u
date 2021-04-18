<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentStore;
use App\Models\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use League\CommonMark\Normalizer\SlugNormalizer;

/*
public function index()
public function store(Request $request)
public function show($id)
public function update(Request $request, $id)
public function destroy($id)
*/

class DocumentsController extends Controller
{
    /**
     * show all documents
     *
     * show all documents available for user
     *
     * @param
     * @return \Illuminate\View\View
     * @throws
     **/
    public function index()
    {
        $search = request()->input('search') ?? '%';
        $documents=DocumentStore::with('files')->where('objstore', 'LIKE', "%$search%")->latest()->paginate(5);

        // $documents=DocumentStore::with('files')->latest()->paginate(15);
        // ->take(10)->get();
        // $docs=DocumentStore::latest()->paginate(10);
        // return $docs;
        # code...
        // $a=DocumentStore::find(1);
        // $a->saveNewSign("testcsp2",2);
        // dd($all);

        return view('documents.index',["documents" => $documents,"search" => $search]);
    }

/**
     * show current document
     *
     * show all documents available for user
     *
     * @param
     * @return \Illuminate\View\View
     * @throws
     **/
    public function show(DocumentStore $slug)
    {
        # route model binding refactory - in arguments
        // $document=DocumentStore::firstWhere('slug', $slug);

        // view <-> model binding refactory
        return view('documents.show',["document"=>$slug]);

    }

    /**
     * store
     *
     * Undocumented function long description
     *
     * @param request $req Description
     * @return type
     * @throws conditon
     **/
    public function store(Request $req)
    {
        $doc = DocumentStore::create($this->reqDocumentsValidate());
        // $doc->saveSecobjstore();
        $doc->save();

        $doc->saveFile($req->file);


        return redirect()->route('documents');
/*
        $doc= new DocumentStore();
        $doc->slug=$req->slug;
        try {
            $obj=json_decode($req->objstore,true, $depth=512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            $obj=[];
            throw ValidationException::withMessages(['objstore' => 'Not correct Json']);
        }

        $doc->objstore=$obj;

        $doc->user_admin=Auth::user()->getAuthIdentifier();
        // dd($doc);
        $doc->save();
        return redirect()->route('documents');
*/
    }




    public function edit(DocumentStore $slug)
    {
        // $document=DocumentStore::firstWhere('slug', $slug);

       return view('documents.edit',["document"=>$slug]);

    }


    public function update(DocumentStore $slug)
    {


        // move to model binding with DI in request
        // $a=1;
        // $doc=DocumentStore::firstWhere('slug', $slug);

        // dd($this->reqDocumentsValidate());
        $req=request();
        // dd($req->all());

        $slug->update($this->reqDocumentsValidate()); // set all data from validation
        $slug->save();

        // save file if exist in request
        $slug->saveFile($req->file);

            return  redirect()->route('document.show',$slug);

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
    public function reqDocumentsValidate()
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
            'slug'     => 'required',
            // 'objstore' => 'required',
            'objstore_type' => "required",
            'objstore_version' => "required",
            'objstore_topic' => "required",
            'objstore_caption' => "required",
            'objstore_comment' => "required",
            // 'secobjstore_userid' => "required",
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        // try {
        //     $obj=json_decode(request('objstore'),true, $depth=512, JSON_THROW_ON_ERROR);
        // } catch (\Throwable $th) {
        //     throw ValidationException::withMessages(['objstore' => 'Not correct Json']);
        // }

        $obj = [];
        $obj["type"]    = $data['objstore_type'];
        $obj["version"] = $data['objstore_version'];
        $obj["topic"]   = $data['objstore_topic'];
        $obj["caption"] = $data['objstore_caption'];
        $obj["comment"] = $data['objstore_comment'];


        $secobjstore = [];
        // $secobjstore["status"] = "статус по умолчанию";
        // array_key_exists("status",$opt) ? $opt["status"] : "Неизвестно";
        // $secobjstore["userid"] = $data['secobjstore_userid'];
        // array_key_exists("userid",$opt) ? $opt["userid"] : 0;


        $data['user_admin']=Auth::user()->getAuthIdentifier();
        $data['objstore']=$obj;
        $data['secobjstore']=$secobjstore;
        return $data;
    }



}
