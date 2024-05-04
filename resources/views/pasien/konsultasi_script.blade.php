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
                if(data.isi_chat.type == "end chat"){
                    $(".message-input").prop('disabled',true)
                    $(".message-actions").html(`
                        <button disabled class="btn btn-primary d-flex ssee_messend-msg-btn">
                                    Sesi Habis
                        </button>`);
                }
                i.scrollTo(0, i.scrollHeight)

            }
        })
    });




    $(".form-send-message").on('submit', (e) => {
        e.preventDefault()
        axios.post("{{url('sendchat')}}", {
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
                            <small>ago</small>
                        </div>
                    </div>
                  
                </div>
            </li>

        `)

        i.scrollTo(0, i.scrollHeight)
        input_message.val('')

    });

    let catatan_resep = (type,time,id)=>{
        let mmee =  `
                            <li class="chat-message">
                                    <div class="d-flex overflow-hidden">
                                       
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text bg-${type=='catatan'?'primary':'success'}">
                                                <p class="mb-0  fw-bold text-white">${type=='catatan'?'Catatan':'Resep'} Dokter</p>
                                                <button class="d-block btn bg-white mt-3" onclick="lihatCatatan('${id}','${type}')">Lihat ${type=='catatan'?'Catatan':'Resep'}</button>
                                            </div>
                                            <div class="text-end text-muted mt-1">
                                                <i class="bx bx-check-double text-success"></i>
                                                <small>${time}</small>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </li>
                            `;
        return mmee;
    }


    let my_mee = (data)=>{
        let my_mee =  
        `
        <li class="chat-message chat-message-right">
                <div class="d-flex overflow-hidden">
                    <div class="chat-message-wrapper flex-grow-1">
                        <div class="chat-message-text">
                            <p class="mb-0">${data.isi_chat}</p>
                        </div>
                        <div class="text-end text-muted mt-1">
                            <i class="bx bx-check-double text-success"></i>
                            <small>${timeAgo(data.created_at)}</small>
                        </div>
                    </div>
                    <div class="user-avatar flex-shrink-0 ms-3">
                       
                    </div>
                </div>
            </li>
        `;

        return my_mee;
    }


    let see_mess = (data) => {
        let mess = '';
            if(data.type == 'catatan' || data.type=='resep'){
             mess=  catatan_resep(data.type,timeAgo(data.created_at),data.isi_chat)
            }else{
            mess = `
             <li class="chat-message">
                    <div class="d-flex overflow-hidden">
                        <div class="user-avatar flex-shrink-0 me-3">
                           
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text ${data.type == 'end chat' ? 'bg-secondary' : ''}">
                                <p class="mb-0 ${data.type == 'end chat' ? 'font-italic text-white' : ''}">${data.isi_chat}</p>
                            </div>
                            <div class="text-muted mt-1">
                                <small>${timeAgo(data.created_at)}</small>
                            </div>
                        </div>
                    </div>
                </li>
        `;
            }
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
        let data = await axios.get(`{{url('getchat')}}/${id}`)
            .then((res) => {
                if (res.data.status_konsultasi === 'active') {
                    $(".message-actions").html(`  
                                <button class="btn btn-primary d-flex send-msg-btn">
                                    <i class="bx bx-paper-plane me-md-1 me-0"></i>
                                    <span class="align-middle d-md-inline-block d-none">Send</span>
                                </button>`)
                    $(".message-input").prop('disabled',false)
                    $("#active_chat .chat-contact-info .user-status").html(
                        `<span class="badge bg-success">Sesi Konsultasi Berlangsung</span>`);
                } else {
                    $(".message-input").prop('disabled',true)
                    $(".message-actions").html(`
                        <button disabled class="btn btn-primary d-flex send-msg-btn">
                                    Sesi Habis
                        </button>`);
                        $("#active_chat .chat-contact-info .user-status").html(
                        `<span class="badge bg-danger">Tidak Ada Sesi Konsultasi</span>`);
                }

                $(".chat-history").empty()
                res.data.chats.forEach((cat)=>{
                    console.log(cat.to_id == id)
                    if(cat.to_id == id_to){
                        $(".chat-history").append(my_mee(cat))
                    }else{
                        $(".chat-history").append(see_mess(cat))
                    }
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

    let lihatCatatan = (id,type)=>{
        axios.post(`{{url('pasien/konsultasi/lihatcatatan')}}`,{
            id:id,
            type:type
        }).then(res=>{
            console.log(res.data)
            let mmee="";
            if(type=="catatan"){
                mmee = `
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th class='w-25'>Gejala</th>
                                        <td>: ${res.data.gejala}</td>
                                    </tr>
                                    <tr>
                                        <th>Saran</th>
                                        <td>:  ${res.data.saran}</td>
                                    </tr>
                                    <tr>
                                        <th>Diagnosa</th>
                                        <td><p>: ${res.data.code}</p> <p class="fst-italic">(${res.data.name_en})</p> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                `
            }else{
                mmee = `
                     <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Dosis</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                res.data.forEach((resep,n)=>{
                    mmee = mmee+`
                    <tr>
                        <td>${n+1}</td>
                        <td>${resep.nama_obat}</td>
                        <td>${resep.jumlah}</td>
                        <td>${resep.dosis}</td>
                    </tr>
                    `;
                })
                mmee = mmee+` </tbody></table></div>`;
            }

            $("#lihatCatatan .modal-title").html(`${type=='catatan'?'Catatan Dokter':'Resep Dokter'}`)
            $("#lihatCatatan .modal-body").html(mmee)
            $("#lihatCatatan").modal("show")
        })
    }
</script>
