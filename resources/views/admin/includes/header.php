
<style>
    ul {list-style: none;}

    .topNav h2{
        width: 78%;
        display: inline-block;
    }
    .topNav ul{
        display: inline-block;
    }
</style>
<header class="header">
    <div class="topNav">
        <?php if(\Illuminate\Support\Facades\Auth::guard('admin')->check()) { ?>
      <h2>Healing Budz-Admin</h2>
            <ul class="pf">
                <li><a  class="heading-top" href="<?php echo asset('/get_admin_profile'); ?>">Profile</a></li>
            </ul>
        <?php  }
        else{?>
            <ul class="pf">
            <li><a  class="heading-top" href="<?php echo asset('/login'); ?>">Healing Budz-Admin</a></li>
        </ul>
        <?php }



        ?>
    </div>

</header>


