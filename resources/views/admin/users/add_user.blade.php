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

                        <!--<a class="add_s" href="{{url('/')}}/show_users">Back</a>-->

                    <form action="{{url('/')}}/add_user" method="post" id="loginform">
                        {{csrf_field()}}
                        <label class="fullField">
                            <span>Nick Name</span>
                            <input maxlength="20" type="text" name="first_name" value="{{old('first_name')}}">
                            @if ($errors->has('first_name'))
                                <div class="alert alert-danger">
                                    @foreach ($errors->get('first_name') as $message)
                                        {{ $message }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </label>
<!--                        <label class="fullField">
                            <span>Last Name</span>
                            <input type="text" name="last_name" value="{{old('last_name')}}">
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
                            <input autocomplete="off" type="text" name="email" value="{{old('email')}}" readonly onfocus="this.removeAttribute('readonly')">
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
                        <label class="fullField">
                            <span>Zip Code</span>
                            <input  type="number" name="zip_code" value="{{old('zip_code')}}" readonly onfocus="this.removeAttribute('readonly')">
                            @if ($errors->has('zip_code'))
                                <div class="alert alert-danger">
                                    @foreach ($errors->get('zip_code') as $message)
                                        {{ $message }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </label>
                        <div class="btnCol signinbtn">
                            <input type="submit" name="signIn"  value="Submit">
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