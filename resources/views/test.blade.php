<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="box-border flex py-4">
        <div class="flex flex-col min-h-full p-2 mx-1 bg-gray-600 w-60 flex-nowrap">
            <div class="w-full text-white">Menu </div>
            <div class="w-full mx-1 mt-1">
                <div>items</div>
                <div>items</div>
                <div>items</div>
            </div>

        </div>
        <div class="w-full min-h-screen p-2 mr-1 bg-white">
            <p>Content  Request variables:
            <div   class="p-1 bg-red-300"> {{ $name }}</div></p>
            <p>Slug:<div class="bg-green-700"> {{ $slug ?? '' }}</div></p>
            <div class="m-1 border border-black"> Content {{ $content ?? '' }} </div>
        </div>
    </div>


</x-app-layout>
