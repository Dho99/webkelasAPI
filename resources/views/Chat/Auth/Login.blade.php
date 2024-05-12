@extends('chat.layouts.Main')
@section('content')
    <div class="grid place-items-center py-24 lg:px-0 px-18">
        <div class=" bg-white rounded lg:w-1/2 py-5 md:w-3/4 sm:w-full">
            <div class="grid-cols-1 mx-auto text-center">
                <p class="font-semibold text-3xl">Login Page</p>
                <small>You should Log In before using this feature</small>
            </div>
            @if($errors->any())
               {{json_encode($errors->all())}}
            @endif
            <form action="{{route('processLogin')}}" method="POST">
                @csrf
                <div class="mt-10 mb-10 container px-12">
                    <div class="place-content-center grid gap-y-5 grid-cols-1">
                        <div class=" w-full">
                            <label for="">Email</label>
                            <input type="text" name="email" placeholder="Insert your Email"
                                   class="mt-2 border focus:outline-0 focus:border-sky-300 hover:border-sky-300 w-full rounded p-3 caret-sky-500 text-sky-500">
                        </div>
                        <div class=" w-full">
                            <label for="">Password</label>
                            <input type="password" name="password" placeholder="Insert your Password"
                                   class="mt-2 border focus:outline-0 focus:border-sky-300 hover:border-sky-300 w-full rounded p-3 caret-sky-500 text-sky-500">
                        </div>
                        <button type="submit"
                                class="bg-sky-400 w-full rounded-xl py-2 px-4 text-xl text-white font-bold mt-5">Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
