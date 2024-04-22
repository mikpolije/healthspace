<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('admin_theme/assets/vendor/js/app-chat.js')}}"></script>
<script>
    let id_saya = "{{auth()->user()->id}}"
    let id_to = "";
    let input_message = $(".message-input");
    let i = document.querySelector(".chat-history-body");

    $(document).ready(function () {

        $('#single-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: 'Diagnosis...',
            dropdownParent: $("#catatanModal"),
            allowClear: true,
            ajax: {
                url: "{{url('dokter/geticds')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function (data) {
                    var res = data.results.map(function (item) {
                        return {
                            id: item.code,
                            text: item.name_en
                        };
                    });
                    return {
                        results: res
                    };
                },
                cache: true
            }
        });

        Pusher.logToConsole = false;

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

    let my_mee = (data) => {
        let mmee = '';
        switch (data.type) {
            case 'catatan':
                mmee =  `
                            <li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text bg-primary">
                                                <p class="mb-0  fw-bold text-white">Catatan Dokter</p>
                                                <button class="d-block btn bg-white mt-3">Lihat Catatan</button>
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
                break;
            case 'resep':

                mmee =  `
                            <li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text bg-success">
                                                <p class="mb-0  fw-bold text-white">Resep Dokter</p>
                                                <button class="d-block btn bg-white mt-3">Lihat Resep</button>
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
                break;
        
            default:
                mmee =  `
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
                break;
        }
           

        return mmee;
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
                                <button class="btn btn-primary d-flex send-msg-btn">
                                    <i class="bx bx-paper-plane me-md-1 me-0"></i>
                                    <span class="align-middle d-md-inline-block d-none">Send</span>
                                </button>`)
                $(".message-input").prop('disabled', false)
                $(".chat-history").empty()
                if (res.data.status_konsul) {
                    $("#active_chat .chat-contact-info .user-status").html(
                        `<span class="badge bg-success">Sesi Konsultasi Berlangsung</span>`);
                } else {
                    $("#active_chat .chat-contact-info .user-status").html(
                        `<span class="badge bg-danger">Tidak Ada Sesi Konsultasi</span>`);
                }
                res.data.chats.forEach((cat) => {
                    if (cat.to_id == id_to) {
                        $(".chat-history").append(my_mee(cat))
                    } else {
                        $(".chat-history").append(see_mess(cat))
                    }
                })

                i.scrollTo(0, i.scrollHeight)

            })
        return data;
    }

    let showcontact = () => {
        $(".app-chat-contacts").addClass('show')
    }

    let closecontact = () => {
        $(".app-chat-contacts").removeClass('show')
    }

    let endChat = () => {
        axios.post("{{url('dokter/sendchat')}}", {
                to: id_to,
                type: 'end chat',
                isi_chat: 'Sesi Konsultasi Telah Berahir'
            })
            .then(res => {
                $("#active_chat .chat-contact-info .user-status").html(
                    `<span class="badge bg-danger">Tidak Ada Sesi Konsultasi</span>`);
                if (res.data.status_konsul != false) {
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


    // Catatan
        let c_gejala = $("#catatanModal [name='gejala']")
        let c_saran = $("#catatanModal [name='saran']")
        let c_diagnosa = $("#single-select-field")
    let catatanChat = () => {
        c_gejala.val('')
        c_saran.val('')
        c_diagnosa.val('').val(null).trigger("change")
        $("#catatanModal").modal('show')
    }

    let kirimCatatan = async ()=>{
        if(c_gejala.val()!=''&&c_saran.val()!=''&&c_diagnosa.val()!=null&&id_to!=''){
            let gejala = c_gejala.val()
            let saran = c_saran.val()
            let diagnosa = c_diagnosa.val()
            $("#catatanModal").modal('hide')
                axios.post("{{url('dokter/konsultasi/catatan')}}",{
                    gejala : gejala,
                    saran : saran,
                    diagnosa : diagnosa,
                    to : id_to
                })
                .then(res=>{
                    mmee =  `
                            <li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text bg-primary">
                                                <p class="mb-0  fw-bold text-white">Catatan Dokter</p>
                                                <button class="d-block btn bg-white mt-3">Lihat Catatan</button>
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
                            `;
                            $(".chat-history").append(mmee)
                            i.scrollTo(0, i.scrollHeight)
                })
        }
    }

    let reseps = []

    let resepChat = ()=>{
        reseps = []
        showAllResep()
        $("#resepModal").modal('show')
    }

    let showAllResep = ()=>{
        $("#resepModal table tbody").empty()
        reseps.forEach((r,nn)=>{
            $("#resepModal table tbody").append(`
                <tr>
                    <td>${nn+1}</td>
                    <td>${r.nama_obat}</td>
                    <td>${r.jumlah}</td>
                    <td>${r.dosis}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeResep(${nn})"><i class='bx bxs-checkbox-minus'></i></button>
                    </td>
                </tr>
            `)
        })
    }

    let addResep = ()=>{
        let nama_obat = $("#resepModal [name='nama_obat']")
        let jumlah = $("#resepModal [name='jumlah']")
        let dosis = $("#resepModal [name='dosis']")

        if(nama_obat.val()!=""&&jumlah.val()!=""&&jumlah.val()!=""){
                reseps.push({
                nama_obat : nama_obat.val(),
                jumlah : jumlah.val(),
                dosis : dosis.val(),
            })

            showAllResep()
            nama_obat.val('')
            jumlah.val('')
            dosis.val('')
        }
        return false;
    }

    let removeResep = (no)=>{
        reseps.splice(no,1)
        showAllResep()
    }

    let kirimResep = ()=>{
        if(reseps.length > 0 && id_to!=''){
            $("#resepModal").modal('hide')
            axios.post("{{url('dokter/konsultasi/resep')}}",
            {
                data_catatan : JSON.stringify(reseps),
                to : id_to
            })
            .then(res=>{
                mmee =  `
                            <li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text bg-success">
                                                <p class="mb-0  fw-bold text-white">Resep Dokter</p>
                                                <button class="d-block btn bg-white mt-3">Lihat Resep</button>
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
                            `;
                            $(".chat-history").append(mmee)
                            i.scrollTo(0, i.scrollHeight)
            })
        }
        return false;
    }
</script>