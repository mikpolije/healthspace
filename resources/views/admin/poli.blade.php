@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

<!-- Modal Add  -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddLabel">Add</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Nama Poli</label>
                <input type="text" class="form-control" name="nama_poli">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Add  -->

    <div class="card">

        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Poli
                <button class="btn btn-sm btn-primary float-end" onclick="add()">Add</button>
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive text-nowrap" style="min-height:180px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Poli</th>
                            <th width="25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        <tr>
                            <td>1</td>
                            <td>Albert Cook</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>

                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection

@push('js')
<script>
    let add = ()=>{
        $("#modalAdd").modal('show')
    }
</script>
@endpush