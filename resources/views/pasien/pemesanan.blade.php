

  <div class="content-wrapper">
  

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              
              <div class="card-body">
                           

                      <div class="row">
                      <div class="col-lg-6"><br>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                          
                            <tr>
                              <th>Nama </th>
                              <td>Oliv</td>
                            </tr>    

                        
                            </table>
                        </div><br>
                    </div>
              <div class="col-lg-6">
                <form method="post" action="{{url('proses-pemesanan')}}" enctype="multipart/form-data">
                   
                                   
                        {{csrf_field()}}

                        

                        
                         
            
            <button class="btn btn-primary" type="Submit">Checkout</button>
                </form>
            </div>
                <br>
              
                </div>
              </div>

             
               
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
         
    <!-- /.content -->
  </div>