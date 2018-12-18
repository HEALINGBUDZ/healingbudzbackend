<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <?php if(Session::has('success')) {?>
                <h4 class="alert alert-success fade in">
                    <?php echo Session::get('success'); ?>
                </h4>
            <?php } ?>
            <?php if(Session::has('error')) {?>
                <h4 class="alert alert-danger fade in">
                    <?php echo Session::get('error'); ?>
                </h4>
            <?php } ?>
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Transactions</h2>
                <?php if($errors->any()) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->all() as $error) { ?>
                            <?= $error ?><br/>
                        <?php } ?>
                    </div>
                <?php } ?>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="100">Sr.</th>
                        <th>Amount</th>
                        <th>User</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($transactions)) { ?>
                        <?php 
                        $i = 1;
                        foreach($transactions as $transaction) {?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $transaction->amount; ?></td>
                                <td><a href="<?= asset('user_detail/'.$transaction->user->id)?>"><?php echo $transaction->user->first_name; ?></a></td>
                                <td><?php echo  date("m-d-Y H:i:s", strtotime( $transaction->updated_at)); ?></td>
                           </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
    </body>
</html>
