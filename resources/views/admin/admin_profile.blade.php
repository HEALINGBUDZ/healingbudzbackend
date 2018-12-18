<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content publicContent loginPage no-top-padding">
    <div class="contentPd">
    <div class="form-area">
    <div class="form-holder">
        <div class="userForm upload-forms">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/update_admin_profile" method="post" id="loginform">
                {{csrf_field()}}
<!--                <label class="fullField">
                    <span>First Name</span>
                    <input type="text" name="first_name" value="{{$admin->first_name}}">
                    @if ($errors->has('first_name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('first_name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Last Name</span>
                    <input type="text" name="last_name" value="{{$admin->last_name}}">
                    @if ($errors->has('last_name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('last_name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>-->
                <label class="fullField">
                    <span>Email</span>
                    <input type="text" name="email" value="{{$admin->email}}">
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
                    <input type="submit" name="signIn"  value="Update">
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