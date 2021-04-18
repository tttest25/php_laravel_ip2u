<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('documents.DocTitle') }}
        </h2>
    </x-slot>


    {{-- Content --}}
<div class="box-border flex py-4">
        <!-- Menu left -->
        <x-doc-menu />


        {{-- Show documents from documents --}}
        <!-- Main content -->
        <div class="w-full min-h-screen p-2 mr-1 bg-white">

            {{-- Search form --}}
            <form class="w-full " action="{{ route('documents') }}" method="get">
                <div class="flex items-center py-2 border-b border-teal-500">
                  <label for="search" class="block w-full px-3 py-2 mb-2 text-sm leading-tight text-gray-700 appearance-none dark:text-gray-400 focus:outline-none focus:shadow-outline"> {{ __('documents.docList') }} @auth  {{ Auth::user()->name }} @endauth </label>
                  <input class="w-full px-2 py-1 mr-3 leading-tight text-gray-700 bg-transparent border rounded shadow appearance-none focus:outline-none "  aria-label="search"
                  type="text" name="search" id="search" placeholder="полнотекстовый поиск"
                  value="{{ $search }}"
                  />
                  <button class="flex-shrink-0 px-2 py-1 text-sm text-gray-600 bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700" type="submit">
                    Поиск
                  </button>
                </div>
              </form>



            {{ $documents->links() }}

            @foreach ($documents as $document)
            <x-doc-card :document="$document">
                <div>Document Card End 🛴</div>
            </x-doc-card>
            @endforeach

        </div>
    </div>


</x-app-layout>
