<div class="container-fluid px-2 px-md-4">
    <div class="card card-body mx-3" style="padding-bottom:50px">
      <div class="row">
        <div class="row">
          <div class="col-12">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">View Message</h6>
              </div>
              <div class="card-body">

                <form class="text-start">  
                  
                  <div class="row mb-4">
                    <div class="col-6">
                      <label class="form-label">Name  </label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="name" value={{$message->name}} autocomplete="off">
                      </div>
                    </div>
                    
                    <div class="col-6">
                      <label class="form-label">Email</label>
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="email" value={{$message->email}} autocomplete="off">
                      </div>
                    </div>
                  
                  </div>
                  
                  <div class="row mb-4">
                    
                    
                    <div class="col-12">
                        <label class="form-label">Message</label>
                        <div class="input-group input-group-outline">
                        <textarea type="text" style="resize: none;" class="form-control" name="message"  autocomplete="off" rows="3" style="resiez:none" readonly>{{$message->message}}</textarea>
                        </div>
                    </div>
                      
                  
                  </div>

                  

                  

                
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('layout.footer')
    
  </div>

