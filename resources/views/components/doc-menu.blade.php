<div class="flex flex-col min-h-full p-2 mx-1 bg-gray-600 w-60 flex-nowrap">
    <div class="w-full text-white">Menu </div>
    @if (Route::has('documents'))
    @auth
    <div class="w-full min-h-screen mx-1 mt-1">
        <div class=""><a href="{{ route('document.create') }}" class="text-sm text-gray-200 underline">CreateNew</a>
        </div>
        <div class=""> <a href="{{ route('documents') }}" class="text-sm text-gray-200 underline">Documents</a></div>
        <div>Report</div>
    </div>
    @else
    @endauth

    @endif
</div>
