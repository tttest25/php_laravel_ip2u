<?php

namespace App\View\Components;

use App\Models\DocumentStore;
use Illuminate\View\Component;

class DocAttribComponentSelector extends Component
{


    /**
     * The alert type.
     *
     * @var array
     */
    public array $attr;

    /**
     * Create a new component instance.
     *
     * @param  ?array   $attr
     * @return void
     */
    public function __construct(?array  $attr)
    {
        // ?array $attr
        $this->attr = $attr;
        // dd($attr);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {

        switch (true) {
            case ($this->attr['version'] ?? '-'==='0.1.0' &&
                  $this->attr['type'] ?? '-'==="document"):
                //  type : document + version : 0.1.0
                // array:5 [▼
                //   "type" => "document"
                //   "topic" => "кадровые документы"
                //   "caption" => "заявление на отпуск"
                //   "comment" => "УЖО отпуск иванов"
                //   "version" => "0.1.0"
                // ]
                // return view('components.doc-attrib-component-selector');
                return '<x-doc-card-attribute class="mb-2" :attr="$attr" />';
                break;

            default:
                //<x-doc-card-attribute class="mb-2" :attr="$document->objstore" />
                return <<<'blade'
                    <div class="mt-2 text-red-500 alert alert-danger">
                        Компонент для отображения отсутствует - сериализация
                        Атрибуты:
                        <div class="pl-2">
                        @foreach ($attr as $key => $value)
                            <div>
                                <span class="text-sm text-green-300"> {{$key}} </span> :
                                <span class="text-base green-400 "> {{ is_string($value) ? $value : serialize($value)  }}</span>
                            </div>

                        @endforeach
                        </div>
                        {{ $slot }}
                    </div>
                blade;
                break;
        }

    }


}
