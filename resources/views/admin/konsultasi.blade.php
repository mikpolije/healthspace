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
                        
                            <small class="user-status text-muted">Pasien</small>
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


                        @forelse($dokter as $d)

                        <li class="chat-contact-list-item" onclick="pilihdokter({{$d}},this)">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar avatar-online">
                                    <img src="{{asset('profil/'.$d->profil)}}" alt="Avatar"
                                        class="rounded-circle border">
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">{{$d->nama}}</h6>
                                    <p class="chat-contact-status text-truncate mb-0 text-muted">{{$d->nama_poli}}</p>
                                </div>
                                <small class="text-muted mb-auto"></small>
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
                               
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="chat-header-actions"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                        
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
                   
                </div>
            </div>
            <!-- /Chat History -->

            

            <div class="app-overlay"></div>
        </div>
    </div>


</div>

  <!--Lihat Catatan -->
  <div class="modal fade" id="lihatCatatan" aria-labelledby="lihatCatatanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lihatCatatanLabel">Catatan Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
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
                                    
                                </tbody>
                            </table>
                        </div>


                </div>
            </div>
        </div>
    </div>
    <!--Lihat Catatan -->

@endsection

@push('js')
@include('admin.konsultasi_script')
@endpush