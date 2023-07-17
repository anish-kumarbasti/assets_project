

  @extends('Backend.Auth.Layouts.app')
     @section('Style-Area')
  <style>
 
  .first-heading-1{
  color:#5C61F2;
  font-size: 30px;
  font-weight:700;
 }
 .first-heading-p{
   color:#777777;
  font-size: 14px;
  font-weight:400;
 }

.login-card{
  background-repeat:no-repeat;
  background-size:cover;
 }
</style>
@endsection
  @section('Cantent-Area')
 
  <div class="container-fluid p-0"> 
      <div class="row m-0">
        <div class="col-12 p-0">    
          <div class="login-card">
            <div>
              <div><a class="logo text-center" href="index.html"><img class="img-fluid for-light" src="{{asset('Backend/assets/images/IT-Assets/logo.svg')}}" alt="looginpage"></a></div>
              <div class="login-main"> 
                <form class="theme-form">
                  <h4 class="text-center first-heading-1">Create your account</h4>
                  <p class="text-center first-heading-p pt-2">Enter your personal details to create account</p>
                  <div class="form-group">
                    <label class="col-form-label pt-0">Your Name</label>
                    <div class="row g-2">
                      <div class="col-6">
                        <input class="form-control" type="text" required="" placeholder="First name">
                      </div>
                      <div class="col-6">
                        <input class="form-control" type="text" required="" placeholder="Last name">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control" type="email" required="" placeholder="Test@gmail.com">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="login[password]" required="" placeholder="*********">
                      <div class="show-hide"><span class="show"></span></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="checkbox p-0">
                      <input id="checkbox1" type="checkbox">
                      <label class="text-muted" for="checkbox1">Agree with<a class="ms-2" href="javascript:void(0)">Privacy Policy</a></label>
                    </div>
                    <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Create Account</button>
                  </div>
                
                  <p class="mt-4 mb-0 text-center">Already have an account?<a class="ms-2" href="login.html">Sign in</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
     @endsection