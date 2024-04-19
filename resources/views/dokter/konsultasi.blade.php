@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">


    <div class="app-chat overflow-hidden card">
        <div class="row g-0">
           

            <!-- Chat & Contacts -->
            <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                id="app-chat-contacts">
                <div class="sidebar-header pt-3 px-3 mx-1">
                    <div class="d-flex align-items-center me-3 me-lg-0">
                        <div class="flex-shrink-0 avatar avatar-online me-2" data-bs-toggle="sidebar"
                            data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                            <img class="user-avatar rounded-circle cursor-pointer border"
                                src="{{asset('profil/'.auth()->user()->profil)}}" alt="Avatar">
                        </div>
                        <div class="chat-contact-info flex-grow-1 ms-3">
                            <h6 class="m-0">{{auth()->user()->nama}}</h6>
                            <small class="user-status text-muted">Dokter</small>
                        </div>
                    </div>
                    <i class="bx bx-x cursor-pointer position-absolute top-0 end-0 mt-2 me-1 fs-4 d-lg-none d-block"
                        data-overlay="" data-bs-toggle="sidebar" data-target="#app-chat-contacts" onclick="closecontact()"></i>
                </div>
                <hr class="container-m-nx mt-3 mb-0">
                <div class="sidebar-body ps ps--active-y">

                    <!-- Chats -->
                    <ul class="list-unstyled chat-contact-list pt-1" id="chat-list">
                        <li class="chat-contact-list-item chat-contact-list-item-title">
                            <h5 class="text-primary mb-0">Konsultasi</h5>
                        </li>


                        @forelse($pasien as $d)

                        <li class="chat-contact-list-item" onclick="pilihdokter({{$d}},this)">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar avatar-online">
                                    <img src="{{asset('profil/'.$d->profil)}}" alt="Avatar"
                                        class="rounded-circle border">
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">{{$d->nama}}</h6>
                                    <p class="chat-contact-status text-truncate mb-0 text-muted">{{$d->jenis_kelamin}}</p>
                                </div>
                                <small class="text-muted mb-auto">5 Minutes</small>
                            </a>
                        </li>
                        @empty
                        <li class="chat-contact-list-item chat-list-item-0">
                            <h6 class="text-muted mb-0">Tidak Ditemukan</h6>
                        </li>
                        @endforelse



                    </ul>
                    <!-- Contacts -->

                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; height: 391px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 142px;"></div>
                    </div>
                </div>
            </div>
            <!-- /Chat contacts -->

            <!-- Chat History -->
            <div class="col app-chat-history">
                <div class="chat-history-wrapper">
                    <div class="chat-history-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex overflow-hidden align-items-center" id="active_chat">
                                <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2"
                                    onclick="showcontact()"></i>
                                <div class="flex-shrink-0 avatar">

                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="m-0"></h6>
                                    <small class="user-status text-muted"></small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <!-- <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                                <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                                <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i> -->
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="chat-header-actions"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                        <a class="dropdown-item" href="javascript:void(0);"  onclick="catatanChat()">Berikan Catatan</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Berikan Resep</a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="endChat()">End Chat Konsultasi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history-body ps ps--active-y">
                        <ul class="list-unstyled chat-history mb-0">

                        </ul>

                    </div>
                    <!-- Chat message form -->
                    <div class="chat-history-footer">
                        <form class="form-send-message d-flex justify-content-between align-items-center ">
                            <input class="form-control message-input border-0 me-3 shadow-none"
                                placeholder="Type your message here..." disabled>
                            <div class="message-actions d-flex align-items-center">
                                <!-- <i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i>
                                <label for="attach-doc" class="form-label mb-0">
                                    <i class="bx bx-paperclip bx-sm cursor-pointer mx-3 text-body"></i>
                                    <input type="file" id="attach-doc" hidden="">
                                </label> -->

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Chat History -->

            <div class="app-overlay"></div>
        </div>
    </div>


</div>
@endsection

@push('js')
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('admin_theme/assets/vendor/js/app-chat.js')}}"></script>
<script>
    let id_saya = "{{auth()->user()->id}}"
    let id_to = "";
    let input_message = $(".message-input");
    let i = document.querySelector(".chat-history-body");

    $(document).ready(function () {

        Pusher.logToConsole = true;

        var pusher = new Pusher('84d89372bac06830ab70', {
            cluster: 'ap1',
            forceTLS: true
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            if (id_saya == data.to && id_to == data.from) {
                $(".chat-history").append(see_mess(data.isi_chat))
                i.scrollTo(0, i.scrollHeight)
            }
        })
    });




    $(".form-send-message").on('submit', (e) => {
        e.preventDefault()
        axios.post("{{url('dokter/sendchat')}}", {
            to: id_to,
            isi_chat: input_message.val()
        });
        $(".chat-history").append(`
        <li class="chat-message chat-message-right">
                <div class="d-flex overflow-hidden">
                    <div class="chat-message-wrapper flex-grow-1">
                        <div class="chat-message-text">
                            <p class="mb-0">${input_message.val()}</p>
                        </div>
                        <div class="text-end text-muted mt-1">
                            <i class="bx bx-check-double text-success"></i>
                            <small>a go</small>
                        </div>
                    </div>
                    <div class="user-avatar flex-shrink-0 ms-3">
                        <div class="avatar avatar-sm">
                            <img src="http://127.0.0.1:8000/admin_theme/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                        </div>
                    </div>
                </div>
            </li>

        `)

        i.scrollTo(0, i.scrollHeight)
        input_message.val('')

    });

    let my_mee = (data)=>{
        let my_mee =  
        `
        <li class="chat-message chat-message-right">
                <div class="d-flex overflow-hidden">
                    <div class="chat-message-wrapper flex-grow-1">
                        <div class="chat-message-text ${data.type == 'end chat' ? 'bg-secondary' : ''}">
                            <p class="mb-0  ${data.type == 'end chat' ? 'fst-italic text-white' : ''}">${data.isi_chat}</p>
                        </div>
                        <div class="text-end text-muted mt-1">
                            <i class="bx bx-check-double text-success"></i>
                            <small>${timeAgo(data.created_at)}</small>
                        </div>
                    </div>
                    <div class="user-avatar flex-shrink-0 ms-3">
                        <div class="avatar avatar-sm">
                            <img src="http://127.0.0.1:8000/admin_theme/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                        </div>
                    </div>
                </div>
            </li>
        `;

        return my_mee;
    }


    let see_mess = (data) => {
        let mess = `
             <li class="chat-message">
                    <div class="d-flex overflow-hidden">
                        <div class="user-avatar flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <img src="{{asset('admin_theme')}}/assets/img/avatars/5.png" alt="Avatar"
                                    class="rounded-circle">
                            </div>
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text">
                                <p class="mb-0">${data.isi_chat}</p>
                            </div>
                            <div class="text-muted mt-1">
                                <small>${timeAgo(data.created_at)}</small>
                            </div>
                        </div>
                    </div>
                </li>
        `
        return mess;
    }

    let pilihdokter = async (data, el) => {
        $(".chat-contact-list-item").removeClass('active')
        $(el).addClass('active')

        let profil = `{{asset('profil')}}/${data.profil}`
        id_to = data.user_id
        $("#active_chat .avatar").html(` <img src="${profil}" alt="Avatar"
                                        class="rounded-circle border" data-bs-toggle="sidebar" data-overlay=""
                                        data-target="#app-chat-sidebar-right"> `)

        $("#active_chat .chat-contact-info").html(`  <h6 class="m-0">${data.nama}</h6>
                                    <small class="user-status text-muted">${data.nama_poli}</small>  `)
        await getChat(data.user_id)

    }

    let getChat = async (id) => {
        let data = await axios.get(`{{url('dokter/getchat')}}/${id}`)
            .then((res) => {
                $(".message-actions").html(`  
@ -280,6 +280,11 @@ class="rounded-circle border" data-bs-toggle="sidebar" data-overlay=""
                                </button>`)
                    $(".message-input").prop('disabled',false)
                $(".chat-history").empty()
                if(res.data.status_konsul){
                    $("#active_chat .chat-contact-info .user-status").html(`<span class="badge bg-success">Sesi Konsultasi Berlangsung</span>`);
                }else{
                    $("#active_chat .chat-contact-info .user-status").html(`<span class="badge bg-danger">Tidak Ada Sesi Konsultasi</span>`);
                }
                res.data.chats.forEach((cat)=>{
                    if(cat.to_id == id_to){
                        $(".chat-history").append(my_mee(cat))
@ -289,53 +294,54 @@
                })

                i.scrollTo(0, i.scrollHeight)

            })
        return data;
    }

    let showcontact = ()=>{
        $(".app-chat-contacts").addClass('show')
    }

    let closecontact = ()=>{
        $(".app-chat-contacts").removeClass('show')
    }

    let endChat = ()=>{
        axios.post("{{url('dokter/sendchat')}}", {
            to: id_to,
            type : 'end chat',
            isi_chat: 'Sesi Konsultasi Telah Berahir'
        })
        .then(res=>{
            $("#active_chat .chat-contact-info .user-status").html(`<span class="badge bg-danger">Tidak Ada Sesi Konsultasi</span>`);
            if(res.data.status_konsul != false){
                $(".chat-history").append(`
                    <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text bg-secondary">
                                        <p class="mb-0 font-italic text-white">Sesi Telah Berahir</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class="bx bx-check-double text-success"></i>
                                        <small>a go</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="http://127.0.0.1:8000/admin_theme/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>

                    `)
            }
        })
        i.scrollTo(0, i.scrollHeight)
    }

</script>
@endpush
