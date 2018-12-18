<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">

    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
    <a class="add_s" href="{{url('/')}}/add/event">Add New User</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Events</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Subscription Name</th>
                <th>Stripe Id</th>
                <th>Quantity</th>
                <th>Trial Ends At</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($subscriptions))
            <?php $i = 1;?>
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td>{{$subscription->name}}</td>
                        <td>{{$subscription->stripe_id}}</td>
                        <td>{{$subscription->quantity}}</td>
                        <td>{{$subscription->trial_ends_at}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>

