<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentStore extends Model
{
    use HasFactory;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'objstore' => '{}',
        'secobjstore' => '{}'
    ];

    /**
     * path method for return URL on show entity
     *
     * Undocumented function long description
     *
     * @return string for url to model
     **/
    public function path()
    {
        return route('document.show', $this);
    }

    /**
     * return field name for route-model binding
     *
     * @return string
     * @throws conditon
     **/
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // guarded field
    protected $guarded = ['secobjstore'];

    // link model to table
    protected $table = 'documentstore';

    // wotk with json - to get arrat
    protected $casts = [
        'objstore' => 'array',
        'secobjstore' => 'array',
    ];

    /**
     * store new sign
     *
     * function add new sign in attributes
     *
     * @param string $csp sign
     * @param integer $userid
     * @return boolean
     * @throws conditon
     **/
    public function saveNewSign(string $csp, int $userid)
    {

        $objstore = $this->objstore;

        $objstore['sign'] = $csp;

        $this->objstore = $objstore;

        // Example of update inline
        // $user = User::find(1);
        // $user->update(['options->key' => 'value']);

        // array_push(, "signUserId", $userid);
        $this->save();
    }


    /**
     * return user to admin of document
     *
     * return user of admin document
     *
     *
     * @return
     * @throws conditon
     **/
    public function userOwner()
    {
        //  in this case eloquent assume that foreign ley is method_name+_ID , but it is not pass second argument
        return $this->belongsTo(User::class, 'user_admin');
    }


    /**
     * releation to file
     *
     * Undocumented function long description
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function files()
    {
        return $this->hasMany(Files::class);
    }

    /**
     * save file to files model
     *
     * save file if exist in request
     *
     * @param UploadedFile  $file
     * @return void
     * @throws conditon
     **/
    public function saveFile(?UploadedFile  $uploadedFile)
    {
        if ($uploadedFile) {
            // $time_micro = (int) round(microtime(true) * 1000000);
            // $fileName = $time_micro . '.' . $uploadedFile->extension();
            // $uploadedFile->move(public_path('uploads'), $fileName);
            $path = $uploadedFile->store( date("Ym"));

            $file = new Files();
            $file->filename = $uploadedFile->getClientOriginalName();
            // $file->filepath = $fileName;
            $file->filepath = $path;
            $file->document_store_id = $this->getKey();
            $file->save();
        }
    }

    /**
     * save secobj with status and sign userid
     *
     * ["status"=>"","userid"=>""]
     *
     * @param array $opt
     * @return type
     * @throws conditon
     **/
    public function saveSecobjstore(array $opt)
    {
        $secobjstore=[];
        $secobjstore["status"] = array_key_exists("status",$opt) ? $opt["status"] : "Неизвестно";
        $secobjstore["userid"] = array_key_exists("userid",$opt) ? $opt["userid"] : 0;
        $this->secobjstore=$secobjstore;

    //   $this->save();
    }

    /**
     * get status of
     *
     * ["status"=>"","userid"=>""]
     *
     *
     * @return string
     * @throws conditon
     **/
    public function getStatus():string
    {
        $stat= $this->secobjstore ?? [];

        return array_key_exists("status",$stat) ? $stat[ "status"] : "Неизвестно";

    //   $this->save();
    }
}
