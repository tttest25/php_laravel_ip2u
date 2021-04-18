@props(['document'])

@if ($document)
{{-- `{"id":2,
    "created_at":"2021-03-11T10:18:47.000000Z",
    "updated_at":"2021-03-11T10:18:47.000000Z",
    "slug":"doc2",
    "user_admin":1,
    "objstore":{"sign":"testcsp2","attr1":"v1","attr2":"v2"}}
--}}
<div
    {{ $attributes->merge(['class' => ' p-2 flex flex-col border border-black font-medium text-sm text-green-900 mt-2']) }}>
    <div class="flex flex-row">
        <div class="w-1/2 "><span class="font-extrabold">Document detail -></span>
                <a class="text-sm text-gray-800 underline"
                    href={{ route('document.edit', ['slug' => $document->slug ?? 1])}}>
                    edit id:{{ $document->id }} -> slug:{{ $document->slug }}
                </a>
        </div>
        <div class="w-full px-2 ">
            <span class="font-extrabold">Document created/updated</span>
            {{ $document->created_at }}/{{ $document->updated_at }}
        </div>

    </div>
    <div class="flex flex-row flex-wrap">

        <div class="w-1/2 mt-2 h-23">
            <span class="font-extrabold ">Attributes -></span>
            <div class="pl-2">
                @foreach ($document->objstore as $key => $value)
                @if (! in_array($key,['type','version']) )
                    <div>
                        <span class="text-sm text-green-300"> {{$key}} </span> :
                        <span class="text-base green-400 "> {{is_string($value) ? $value  : serialize($value)}}</span>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
        <div class="flex flex-col flex-wrap w-1/2 mt-2">
            <div class="min-w-full font-extrabold "> UserOwner -> </div>
            <div class="w-1/2">Name: {{$document->userOwner->name }}</div>
            <div class="w-1/2">Email: {{$document->userOwner->email }}</div>
        </div>

    </div>
    <div class="flex flex-col">
        <div class="w-1/2 mt-2 ">
            <span class="font-extrabold ">Files -></span>
            <div class="pl-2">

                @foreach ($document->files as $file)
                <div>
                    <a href="{{ route('signs.index', ['file' => $file->id]) }}" class="underline ">
                        <span class="text-base text-green-300"> {{$file->filename}} </span> <span class="text-sm green-400 "> ({{($file->id)}})</span>
                    </a>
                    @foreach ($file->signs as $sign)
                     <div class="ml-4">🔒 подпись {{$loop->iteration}}: {{$sign->signobj['signers']['0']['subject']['CN'] ?? 'отсутствует'}}
                     <a class="underline" href="{{ route('signs.show', ['sign' => $sign]) }}"> детально </a>

                    </div>
                    @endforeach
                </div>

                @endforeach
            </div>
        </div>

    </div>

    <div class="mt-2">

        Slot:
        {{ $slot }}
    </div>
</div>

@else
<div {{ $attributes->merge(['class' => 'border border-black font-medium text-sm text-green-600 mt-2']) }}>
    <span>
        Empty document
    </span>
</div>


@endif
