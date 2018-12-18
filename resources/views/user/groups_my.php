<!DOCTYPE html>
<html lang="en">

<?php include('includes/top.php');?>
<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php');?>
        <article id="content">
            <?php include('includes/header.php');?>
            <div class="padding-div">
                <ul class="bread-crumbs list-none">
                    <li><a href="#">Home</a></li>
                    <li><a href="<?php echo asset('groups');?>">Groups</a></li>
                    <li>All</li>
                </ul>
                <div class="search-area">
                    
                    <form action="#" class="search-form">
                        <input type="search" placeholder="Search">
                        <input type="submit" value="Submit">
                    </form>
                    <div class="sort-dropdown">
                        <div class="form-holder">
                            <form action="#">
                                <fieldset>
                                    <select>
                                        <option>Groups</option>
                                    </select>
                                </fieldset>
                            </form>
                            <a href="#" class="options-toggler opener"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        </div>
                        <div class="options">
                            <ul class="list-none">
                                <li>
                                    <img src="<?php echo asset('userassets/images/heart-icon.png')?>" alt="Favorites">
                                    <span>ALPHABETICAL</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/new-icon.png')?>" alt="Newest">
                                    <span>NEWEST</span>
                                </li>
                                <li>
                                    <img src="<?php echo asset('userassets/images/question-icon2.png')?>" alt="Unanswered">
                                    <span>JOINED</span>
                                </li>
                            </ul>
                            <a href="#" class="options-toggler closer"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="groups">
                    <header class="header">
                        <a href="<?php echo asset('create-group') ?>" class="create-group">Create Group</a>
                        <strong>Public Groups</strong>
                    </header>
                    <ul class="list-none">
                        <?php foreach ($groups as $group){ ?>
                        <li>
                            <div class="actions">
                                <a href="#" class="lock">Lock</a>
                                <a href="#" class="edit">Edit</a>
                            </div>
                            <div class="txt">
                                <div class="img-holder">
                                    <img src="<?php echo asset('userassets/images/img2.png')?>" alt="Image" class="img-responsive">
                                    <span class="counts">11</span>
                                </div>
                                <div class="text">
                                    <strong>Mojo MMJ Medical</strong>
                                    <span>8 Budz</span>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
</body>

</html>