@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
@endpush
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
                        data-overlay="" data-bs-toggle="sidebar" data-target="#app-chat-contacts"
                        onclick="closecontact()"></i>
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
                                    <p class="chat-contact-status text-truncate mb-0 text-muted">{{$d->jenis_kelamin}}
                                    </p>
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
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="catatanChat()">Berikan Catatan</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="resepChat()">Berikan Resep</a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="endChat()">End Chat
                                            Konsultasi</a>
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

    <!-- Catatan Chat -->
    <div class="modal fade" id="catatanModal" aria-labelledby="catatanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="catatanModalLabel">Catatan Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Gejala</label>
                        <textarea name="gejala" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Saran</label>
                        <textarea name="saran" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Diagnosis</label>
                        <select class="form-select" id="single-select-field" data-placeholder="Choose one thing">

                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="kirimCatatan()">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Catatan Chat -->

    <!-- Resep Chat -->
    <div class="modal fade" id="resepModal" aria-labelledby="resepModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resepModalLabel">Resep Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="">Nama Obat</label>
                                <input type="text" class="form-control" name="nama_obat">
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah">
                            </div>
                            <div class="form-group">
                                <label for="">Dosis</label>
                                <input type="text" class="form-control" name="dosis">
                            </div>

                            <button class="btn btn-sm btn-primary mt-2 mb-2" onclick="addResep()">Add</button>

                        </div>


                        <div class="col-md-6 border">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Obat</th>
                                            <th>Jumlah</th>
                                            <th>Dosis</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="kirimResep()">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Resep Chat -->



</div>
@endsection

@push('js')
@include('dokter.konsultasi_script')
@endpush
