@extends('Chat.Layouts.Main')
@section('plugins')
    <script src="{{ asset('assets/static/js/jquery-3.7.1.min.js') }}"></script>
@endsection
@section('content')
    <div class="flex justify-center items-center">
        <div class="container drop-shadow-xl">
            <div class="flex w-full h-screen py-14 grid-cols-2">
                <div class="bg-slate-700 w-4/12 rounded-l overflow-auto">
                    <div class="container bg-slate-600 rounded h-12 flex border-b-3 sticky top-0 drop-shadow-lg">
                        <p class="text-amber-50 font-black text-xl self-center m-auto">Webkelas Livechat</p>
                    </div>
                    @php
                        $countFriend = range(0, 2);
                        $friends = ['Ahmad', 'Dwi', 'Satria'];
                    @endphp
                    @foreach ($countFriend as $key => $f)
                        <div
                            class="chatroom container bg-slate-600 hover:bg-slate-500 focus:bg-slate-500 transition duration-150 ease-in-out py-3 px-5 flex column-2">
                            <img src="{{ asset('assets/static/profile-image.jpg') }}" class="w-16 rounded-full" alt="">
                            <div class="-my-1">
                                <div class="ms-4 text-white font-bold text-base" id="friendName">{{ $friends[$key] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="bg-slate-100 w-full">
                    <div class="h-14 bg-slate-200 grid grid-cols-1">
                        <p class="text-lg text-center place-self-center font-bold" id="roomName"></p>
                    </div>
                    <div class="grid columns-1 h-96 w-100 bg-sky-300 overflow-auto" id="roomField">
                        <div class="place-self-center">
                            Select a friend to start messaging
                        </div>
                    </div>
                    <div class="w-full bg-slate-600 h-auto py-[30px] px-5">
                        <div class="flex flex-row place-content-center">
                            <input type="text" name="" class="border border-sky-200 rounded place-content-center flex w-[100%] p-2 basis-5/6" id="">
                            <button class="w-24 bg-slate-700 rounded hover:bg-slate-500 transition-all duration-250 font-bold text-white">Kirim</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            // let chatRooms = $('#chatRoom');

            $('.chatroom').each(function() {
                $(this).on('click', function() {
                    $('.chatroom').removeClass('bg-sky-800');
                    $(this).toggleClass('bg-sky-800');
                    $('#roomName').empty().text($(this).find('#friendName').text());
                });
            });

        });
    </script>
@endpush
