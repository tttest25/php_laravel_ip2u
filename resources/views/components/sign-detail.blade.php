@props(['sign'])

@if ($sign)
{{--
--}}
<div {{ $attributes->merge(['class' => ' p-2 flex flex-col font-medium text-sm text-green-900 mt-2']) }}>
    <div class="bg-white border-2 border-gray-300 rounded main">
        <div class="flex items-center justify-between border-b-2 border-gray-300 rounded-t"
            style="background-color: #F0F3F5;">
            <div class="">
                <h1 class="p-4">Подпись</h1>
            </div>
            <div class="btn-group">
                <a href="{{route('signs.download',['sign' => $sign->id])}}">
                <button type="button"
                    class="px-4 py-2 mr-1 font-normal text-white transition duration-300 ease-in-out bg-gray-500 rounded btn-primary focus:outline-none focus:shadow-outline hover:bg-gray-900">Скачать
                    подпись</button>
                </a>
                <a href="{{route('file.download',['file' => $sign->files->id])}}">
                <button type="button"
                    class="px-4 py-2 mr-1 font-normal text-white transition duration-300 ease-in-out bg-gray-500 rounded btn-primary focus:outline-none focus:shadow-outline hover:bg-gray-900">Скачать
                    файл</button>
                </a>
                <button type="button"
                    class="px-4 py-2 mr-1 font-normal text-white transition duration-300 ease-in-out bg-gray-500 rounded btn-primary focus:outline-none focus:shadow-outline hover:bg-gray-900">Проверить
                    подпись</button>
            </div>
        </div>
        <div class="p-4">
            <div class="flex">
                <div class="w-1/4">Номер подписи:</div>
                <div>{{$sign->id}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">файл:</div>
                <div> {{$sign->files_id}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">создан:</div>
                <div> {{$sign->created_at}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">статус:</div>
                <div> {{$sign->signobj['status']}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">действителен:</div>
                <div> {{$sign->signobj["signers"][0]["valid"]["to"]}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">издатель:</div>
                <div> {{$sign->signobj["signers"][0]["issuer"]["CN"]}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">владелец:</div>
                <div> {{$sign->signobj["signers"][0]["subject"]["CN"]}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">алгоритм:</div>
                <div> {{$sign->signobj["signers"][0]["algorithm"]["name"]}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">отпечаток:</div>
                <div> {{$sign->signobj["signers"][0]["thumbprint"]}}</div>
            </div>

            <div class="flex">
                <div class="w-1/4">серийный:</div>
                <div> {{$sign->signobj["signers"][0]["serialNumber"]}}</div>
            </div>


        </div>
    </div>

    <h1>{{ "Подписанный файл {$sign->files_id} " ?? 'No file' }} </h1>

    <object data='{{ route('file.show', ['file' => $sign->files_id]) }}' type="application/pdf" width="500"
        height="678">
</div>


</div>

@else

<div {{ $attributes->merge(['class' => 'border border-black font-medium text-sm text-green-600 mt-2']) }}>
    <span>
        подпись не существует
    </span>
</div>


@endif
