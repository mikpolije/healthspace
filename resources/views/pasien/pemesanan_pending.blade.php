

  <div class="content-wrapper">
  
  @midtransCardScript
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          


        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              
              <div class="card-body">
                
                <h1>Menunggu Pembayaran</h1>
                <br><br>
                X
                <div class="row">
                  <div class="col-lg-6">
                      <div class="card-body p-0">

                          <table class="table table-striped">
                                <tr>
                                  <th>Nama Paket </th>
                             
                                </tr> 

                        
                          </table><br>
                          <a href="{{route('pemesanan-cancel',$status->id)}}"><button class="btn btn-danger">Batalkan Booking</button></a>
                          <a href="{{$status->payment_url}}"> <button id="pay-button" class="btn btn-primary" onclick="handlePayment()">Bayar Sekarang</button>
                      </div><br>
                    </div>
                  </div>     
                

               
              </div>
            </div>
            <!-- /.card -->

          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
         
    <!-- /.content -->
  </div>
 



 <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-CR3stOw0sihvBdk_"></script>

        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                var snapToken = "{{ $status->payment_token }}";
                    if (snapToken) {
                        snap.pay(snapToken, {
                            // Optional
                            onSuccess: function(result){
                                console.log('Payment successful:', result);
                            },
                            // Optional
                            onPending: function(result){
                                console.log('Payment pending:', result);
                            },
                            // Optional
                            onError: function(result){
                                console.error('Payment error:', result);
                            }
                        });
                    } else {
                        console.error('Snap Token is not available');
                    }
                };
        </script>

