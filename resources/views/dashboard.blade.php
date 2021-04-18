<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center ">
                        <div id="proj logo"> <svg viewBox="0 0 512 511" width="24" style="stroke-linecap: round; stroke: currentcolor; stroke-linejoin: round; stroke-width: 60;" xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com" class="w-8 h-8 text-gray-500">
                            <defs>
                              <bx:grid x="0" y="0" width="514" height="514"/>
                            </defs>
                            <g style="stroke-width: 40;" transform="matrix(1, 0, 0, 0.91307, 0.000016, 31.730522)">
                              <title>Lines</title>
                              <rect x="71.945" width="368.11" height="490.004" y="11" style="fill: none;"/>
                              <line x1="141.95" y1="101.523" x2="370.05" y2="101.523"/>
                              <line x1="141.95" y1="206.205" x2="370.05" y2="206.205"/>
                              <line x1="141.95" y1="310.887" x2="370.05" y2="310.887"/>
                              <line x1="141.95" y1="415.568" x2="370.05" y2="415.568"/>
                            </g>
                          </svg></div>
                        <div id="text" class="mx-2 text-xl "><a class="text-gray-700 underline" href="{{ route('documents') }}">Documents</a> - <span class="text-base text-gray-400 ">project for work with documents and CSP</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



