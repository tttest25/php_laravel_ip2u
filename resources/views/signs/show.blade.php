<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
           Signs show
        </h2>
    </x-slot>

     {{-- Content --}}
     <div class="box-border flex py-4">
        <!-- Menu left -->
        <x-doc-menu />

        {{-- Content --}}
        <div class="w-full p-2 mx-4 bg-white border">
            <x-sign-detail :sign="$sign" />
        </div>
    </div>



</x-app-layout>
