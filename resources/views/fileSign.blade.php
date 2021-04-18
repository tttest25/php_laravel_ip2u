<x-app-layout>

        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                FileSign
            </h2>
        </x-slot>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>



{{-- Content --}}
<div class="box-border flex py-4">
    <!-- Menu left -->
    <x-doc-menu />

    {{-- Content --}}
    <div class="w-full p-2 mx-4 bg-white border">
        <form action="{{ route('signs.create',["file"=>$fileid->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf


            @if ($errors->any())
            <div class="text-sm text-red-600 alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            {{-- Сертификаты --}}
            <label class="block mb-6">
                <label for="certList"
                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400 @error('slug') border-red-500 @enderror">Выберите сертификат:</label>

                <select name="certList" id="certList"
                   required
                   class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                >
                </select>
            </label>

            <label class="block mb-3">
                <label for="fileid"
                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">signobj:</label>
                <textarea
                    class="@error('signb64') border-red-500 @enderror w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                    required name="signb64" id="signb64" placeholder="{}" >{{old("signb64")}}</textarea>
            </label>



            <label class="block mb-3">
                <label for="fileid"
                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">fileid:</label>
                <input name="fileid" id="fileid" type="text" value="{{$fileid->id}}" readonly/>


            </label>



            <div id="myList">
                <p id="loading">Идет загрузка ЭЦП Browser plug-in...</p>

            </div>
            <a href="#" class="text-yellow-800" onclick="testSign()"> Подписать и проверить</a>
            <input type="submit" value="Сохранить созданную подпись"  class="text-yellow-800" />
            <div id="myError" class="font-mono text-xs"></div>

            <div class="border">
                {{-- add card of file  --}}
                <h1>{{ "Информация о файле для подписи: {$fileid->id} {$fileid->filename} {$fileid->created_at}" ?? 'No file' }}</h1>

                <object data='{{ route('file.show', ['file' => $fileid]) }}' type="application/pdf"
                    width="500"
                    height="678">
            </div>
    </div>
</div>



{{------------------------------ Scripts!!!------------------------------------------------ --}}
        <script type="text/javascript" src="{{ URL::asset('js/cadesplugin_api.js') }}"></script>
        <script>
            const CADESCOM_CADES_X_LONG_TYPE_1 = 0x5d;
            const CAPICOM_CURRENT_USER_STORE = 2;
            const CAPICOM_MY_STORE = "My";
            const CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED = 2;
            const CAPICOM_CERTIFICATE_FIND_SUBJECT_NAME = 1;

            const FILEID = "{{ $fileid->id ?? 'null' }}";
        </script>
        <script type="text/javascript" src="{{ URL::asset('js/async-crypto.es6.js') }}"></script>



<script>

    let loading = document.getElementById("loading");

    // ожидание загрузки плагина
    window["cadesplugin"].then(() => {

        document.getElementById("myList").removeChild(loading);
        let loadingCertList = document.createTextNode("Идет загрузка сертификатов...");
        document.getElementById("myList").appendChild(loadingCertList);

        // ожидание загрузки сертификатов
        window["FillCertList_NPAPI"]().then(
            (certList) => {
                window.certList=certList;
                console.log(JSON.stringify(certList, null, 4));
                // remove alert
                document.getElementById("myList").removeChild(loadingCertList);
                // clear list if exist
                let el = document.getElementById("certList");
                while (el.firstChild) {
                       el.removeChild(el.firstChild);
                }

                certList.forEach((cert) => {
                    let op = document.createElement("option");
                    op.innerText=cert.text;
                    // let text = document.createTextNode(cert.text);
                   el.appendChild(op);
                });
                // document.getElementById("myList").appendChild(el);
            },
            (error) => {

                document.getElementById("myList").removeChild(loadingCertList);
                let myError = document.createTextNode("Обнаружены ошибки, смотри в логах");
                document.getElementById("myError").appendChild(myError);


                console.error(error);
            }
        ).catch(function (e) {
            console.error(e);
            let myError = document.createTextNode("Обнаружены ошибки, смотри в логах");
            document.getElementById("myError").appendChild(myError);
        });

    }, (error) => {

        console.error(error);
        document.getElementById("myList").removeChild(loading);
        let myError = document.createTextNode("Обнаружены ошибки, смотри в логах");
        document.getElementById("myError").appendChild(myError);

    });




async function getFile(id) {

    // запрашиваем base64 с данными пользователя
    let response = await fetch(`/filesb64/`+id);
    let file = await response.text();

    // console.log(file);
    return file;

}


function testSign() {
// some data.
// var dataInBase64 = "U29tZSBEYXRhLg==";
    var dataInBase64=null;
    getFile(FILEID).then(
        (dataInBase64) => {
            console.log('getdata in base 64');
            var thumbprint = certList[document.getElementById('certList').selectedIndex].thumbprint;
            var dataToSign=dataInBase64;
            SignCreate(thumbprint, dataToSign)
            .then((a) => {
                console.log(a.substring(0, 10));
                document.getElementById("signb64").value=a;
                // var elPre = document.createElement("PRE")
                // elPre.innerText=a;
            // test sign
                verifySign(dataInBase64,a);
                // document.getElementById("myError").appendChild(elPre);
        }
    );


    })
    // .catch((a) => console.log(a))
}


async function verifySign( datab64, signb64) {

 let response = await fetch('/testsign', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json;charset=utf-8'
  },
  body: JSON.stringify({datab64,signb64,"_token":document.querySelector('meta[name="csrf-token"]').content})
});

  let data = await response.json();
    // console.log({datab64,signb64});
     document.getElementById("myError").innerText= JSON.stringify(data,null,'\t');
    console.log('Get result - %o',data);

}


</script>

{{-- for node
    <script src="https://cdn.jsdelivr.net/npm/cadesplugin-crypto-pro-api@0.9.5/index.min.js"></script>
--}}


</x-app-layout>

