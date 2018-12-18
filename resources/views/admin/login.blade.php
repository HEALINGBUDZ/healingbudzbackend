<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<section class="content publicContent loginPage no-top-padding">
    <div class="contentPd">
    <div class="form-area">
    <div class="form-holder">
        <div class="userForm">
            <?php if(\Illuminate\Support\Facades\Session::has('error')){ ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                <?php echo \Illuminate\Support\Facades\Session::get('error') ?>
            </div>
            <?php } ?>
            <form action="{{url('/')}}/admin_login" method="post" id="loginform">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Email</span>
                    <input type="text" name="email" value="{{old('email')}}">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('email') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Password</span>
                    <input type=password name="password" value="">
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('password') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <div class="btnCol signinbtn">
                    <input type="submit" name="signIn"  value="Login">
                </div>
            </form>
           
        </div>
        </div>
        </div>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>