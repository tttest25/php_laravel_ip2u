@props(['document'])

@if ($document)
{{-- `{"id":2,
    "created_at":"2021-03-11T10:18:47.000000Z",
    "updated_at":"2021-03-11T10:18:47.000000Z",
    "slug":"doc2",
    "user_admin":1,
    "objstore":{"sign":"testcsp2","attr1":"v1","attr2":"v2"}}
--}}

    <div {{ $attributes->merge(['class' => ' p-2 flex flex-col border border-black rounded-lg font-medium text-sm text-green-900 mt-2']) }}>
        <div class="flex">
            <div class="flex flex-col w-1/4 ">
                <div>Карточка документа -></div>
                <div>
                <a class="text-sm text-gray-800 underline" href={{ route('document.show', ['slug' => $document->slug ?? 1])}}>
                    id:{{ $document->id }} -> {{ $document->slug }}
                </a>
                <span class="mx-2">
                <a class="text-sm text-gray-800 underline" href={{ route('document.edit', ['slug' => $document->slug ?? 1])}}>
                    (edit)
                </a>
                </span>
            </div>
        </div>
            <div class="flex flex-col w-2/4 px-2 ">
                <div>Документ создан/обновлен</div>
                <div>{{ $document->created_at }}/{{ $document->updated_at }}</div>
            </div>
            <div> Владелец - {{ Auth::user($document->user_admin)->name }} </div>
        </div>

       {{-- Attributes show component if exist / if there is no -> serialize --}}
       <x-doc-attrib-component-selector :attr="$document->objstore" />

       {{-- Files --}}
        <div class="flex flex-row">
            <div class="w-full ml-2 ">
                <span class="font-extrabold ">Файлы -></span>
                @foreach ($document->files as $file)
                    <span class="text-sm text-green-300">
                        <a href="{{ route('signs.index', ['file' => $file->id]) }}" class="underline ">
                        {{$file->filename}}    {{ ($file->signs->count())>0 ? '🔒' : ''  }} </a>
                    </span>
                @endforeach
            </div>
        </div>
        <div class="mt-2">
        <div>Slot:</div>
        {{ $slot }}
        </div>
    </div>


@else
<div {{ $attributes->merge(['class' => 'border border-black font-medium text-sm text-green-600 mt-2']) }}>
    <span>
        Документ не найден
    </span>
</div>


@endif
