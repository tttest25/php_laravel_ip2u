@props(['attr'])

@if ($attr)
{{--          type : document + version : 0.1.0
                 array:5 [▼
                   "type" => "document"
                   "topic" => "кадровые документы"
                   "caption" => "заявление на отпуск"
                   "comment" => "УЖО отпуск иванов"
                   "version" => "0.1.0"
                 ]
--}}


<div {{ $attributes->merge(['class' => 'flex flex-col w-full  text-sm mt-2']) }}>
    <div class="flex flex-col">
        <div class="mb-2">
            <span class="font-extrabold ">Документ( версия {{$attr['version']}}) -></span>
        </div><div class="flex flex-row">
            <div class="w-1/4"><span class="font-bold">Тема:</span> {{$attr['topic']}}</div>
            <div class="w-1/4"><span class="font-bold">Заголовок:</span>{{$attr['caption']}}</div>
        </div>
        <div>
            <span class="font-bold">Комментарий:</span>
            {{$attr['comment']}}
        </div>
    </div>
</div>



@else
<div {{ $attributes->merge(['class' => ' p-2 flex flex-row  text-sm mt-2']) }}>
    <span>
        Аттрибуты отсутвуют
    </span>
</div>


@endif
