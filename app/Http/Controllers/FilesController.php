<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Files  $file
     * @return \Illuminate\Http\Response
     */
    public function show(Files $file)
    {

        // $data = Storage::get($file->filepath);
         return Storage::response($file->filepath, $file->filename,[
             'Content-Type' =>  'application/pdf',
             'Accept-Ranges' =>  'bytes',
         ]);

        //  return response()->file(storage_path('app').'/'.$file->filepath);
    }

    /**
     * Display the specified resource in base 64.
     *
     * @param  \App\Models\Files  $file
     * @return \Illuminate\Http\Response
     */
    public function showB64mem(Files $file)
    {

        $data = $file->toArray();
        $data['body64']=base64_encode(Storage::get($file->filepath));
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Files  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(Files $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Files  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Files $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Files  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $file)
    {
        //
    }


    public function downloadStream($rows = 5000000)
    {
        // We've specified a default value for the number of rows we want to write out to the file.
        // callback function that writes to php://output
        $callback = function () use ($rows) {

            // Open output stream
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Name',
                'Address',
            ]);

            // Generate a faker instance
            $faker = app('Faker\Generator');

            // add the given number of rows to the file.
            for ($i = 0; $i < $rows; $i++) {
                $row = [
                    $faker->name,
                    $faker->address,
                ];
                fputcsv($handle, $row);
            }


            // Close the output stream
            fclose($handle);
        };

        // build response headers so file downloads.
        $headers = [
            'Content-Type' => 'text/csv',
        ];

        // return the response as a streamed response.
        return response()->streamDownload($callback, 'download.csv', $headers);
    }

  /**
     * Display the specified resource in base 64.
     *
     * @param  \App\Models\Files  $file
     * @return \Illuminate\Http\Response
     */
    public function showB64Stream(Files $file)
    {
        //disable execution time limit when downloading a big file.
        set_time_limit(0);

        /** @var \League\Flysystem\Filesystem $fs */
         $fs = Storage::disk('local')->getDriver();

        $fileName = $file->filepath;

        $metaData = $fs->getMetadata($fileName);
        $stream = $fs->readStream($fileName);
        stream_filter_append($stream, 'convert.base64-encode');

        if (ob_get_level()) ob_end_clean();

        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);
            },
            200,
            [
                'Content-Type' => 'text/plain',
                // 'Content-disposition' => 'attachment; filename="' . $metaData['path'] . '"',
            ]
        );
    }



    /**
     * download binary file specified resource from storage.
     *
     * @param  \App\Models\Signs  $signs
     * @return \Illuminate\Http\Response
     */
    public function download(Files $file)
    {
        //

        return Storage::download($file->filepath, $file->filename);
    }
}
