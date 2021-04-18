<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('documents.Create') }}
        </h2>
    </x-slot>


    {{-- Content --}}
    <div class="box-border flex py-4">
        <!-- Menu left -->
        <x-doc-menu />


        {{-- Show documents from documents --}}
        <!-- Main content -->
        <div class="w-full min-h-screen p-2 mr-1 bg-white">
            <div class="text-center">
                <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Create New document</h1>
                <p class="text-gray-400 dark:text-gray-400">Fill up the form below to create new document.</p>
            </div>
            <div class="m-4">


                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{--
                            {"id":2,
                            "created_at":"2021-03-11T10:18:47.000000Z",
                            "updated_at":"2021-03-11T10:18:47.000000Z",
                            "slug":"doc2",
                            "user_admin":1,
                            "objstore":{"sign":"testcsp2","attr1":"v1","attr2":"v2"}}
                    --}}


                    {{-- type document
                    topic кадровые документы
                    caption тестовое заявление отпуск
                    comment заявление на отпуск
                    version 0.1.0 --}}

                    <input id="type" name="objstore_type" type="hidden" value="document">
                    <input id="version" name="objstore_version" type="hidden" value="0.1.0">
                    <input id="topic" name="objstore_topic" type="hidden" value="кадровые документы">

                    <label class="block mb-2">
                        <label for="slugid" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Идентификатор(Slugid - #IDEA генерация с участием подразделения) :</label>

                        <input type="text"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('slug') border-red-500 @enderror"
                            required
                            type="text" name="slug" id="slugid" placeholder="{{ old("slug")}}"
                            {{-- value="{{}}" --}}
                            value="{{  old("slug")}}">
                    </label>
                    <label class="block mb-2">
                        <label for="objstore_caption" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 ">Название:</label>
                        <input type="text"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('objstore_caption') border-red-500 @enderror"
                            {{-- required --}}
                            type="text" name="objstore_caption" id="objstore_caption" placeholder="заявление на отпуск"
                            value="{{  old("objstore.caption") }}"
                            >
                    </label>
                    <label class="block mb-2">
                        <label for="objstore_comment" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Комментарий:</label>
                        <input type="text"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('objstore_comment') border-red-500 @enderror"
                            required
                            type="text" name="objstore_comment" id="objstore_comment" placeholder="подразделение УЖО от Иванова "
                            value="{{ old("objstore.comment") }}"
                            >

                    </label>

                    <label class="block mb-6">
                        <label for="objstore" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Objstore(readonly) only for debug:</label>
                        <textarea
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('objstore') border-red-500 @enderror "
                            {{-- required --}}
                            readonly
                            name="objstore" id="objstore" placeholder="{}"
                            rows=6
                            >{{  old("objstore")  }}</textarea>
                    </label>
                    {{-- <div class="mb-6 custom-file">
                        <input type="file" name="file" class="custom-file-input" id="chooseFile">
                        <label class="custom-file-label" for="chooseFile">Select file</label>
                    </div> --}}



                    <div class="custom-file">
                        <label class="custom-file-label" for="chooseFile">Select file</label>
                        <input type="file" name="file" id="chooseFile">

                    </div>

                    <label class="block mb-6">
                        <button type="submit" class="w-full px-3 py-4 text-white bg-indigo-500 rounded-md focus:bg-indigo-600 focus:outline-none"> Создать документ</button>
                    </label>


                </form>
            </div>
        </div>
    </div>


</x-app-layout>
