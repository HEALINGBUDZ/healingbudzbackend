<script src="<?php echo url('/');?>/adminassets/js/jquery.min.js"></script>
<aside class="sideBar">
    <div class="userPro">
        <!--<input id="profile_photo" type="file" name="" value="" class="custom-file-btn">-->
        <figure>
            <label for="profile_photo" class="custom-label">
                <a href="<?php echo asset('admin_dashboard');?>"><img id="profile_image" src="<?php echo url('/').'/userassets/images/new_logo1.png'; ?>" alt=""></a>
            </label>
        </figure>
        <h4><?php //echo \Illuminate\Support\Facades\Auth::user()->user_name ;?></h4>
    </div>
    <style>
        .dropdown-content {
            display: none;
            background-color: #303030;
            width: 96%;
        }
        .span-column {
            position: absolute;
            /* left: 0; */
            right: 0;
            top: 0;
            width: 100%;
            height: 42px;
            cursor: pointer;
        }
        .dropdown-content ul li {
            padding-left: 10px;
        }
        .dropdown-content ul {
            padding-left: 0px;
        }
        .navList li {
            display: block;
            position: relative;
        }
        .caret.submenulists{
            color: #fff;
            position: absolute;
            right: 15px;
            top: 19px;
            cursor: pointer;
            border-top: 6px dashed;
            border-right: 6px solid transparent;
            border-left: 6px solid transparent;
        }
        .navList li a {
            padding: 11px;
            color: #FFF;
            padding-right: 35px;
            display: inline-block;
        }
        .custom-form{
            padding: 0 15px;
            overflow: hidden;
        }
        .custom-form input[type="submit"]{
            padding:0;
            background:none;
            border:none;
            color:#fff;
        }
        .custom-file-btn{ display: none !important; }
        .custom-label{cursor:pointer;}
    </style>
    <div class="mainNav" id="leftmenuinnerinner">
        <ul class="navList">
            <li id="show_users">
                <a href="<?php echo asset('/show_users'); ?>">Users <?php $total_user_flag= getFlagCountSubUserReviews()+getFlagCountSubUser(); if($total_user_flag) { ?> <span style="color:red">  <?php echo '('.$total_user_flag.')'; ?> </span> <?php } ?></a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="show_users" <?php if($title == 'Users' || $title == 'User Detail'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/show_users'); ?>">Users</a>
                        </li>
                        <li id="get_special_users" <?php if($title == 'Special Users'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/get_special_users'); ?>">Special Users</a>
                        </li>
<!--                        <li id="get_special_users" <?php if($title == 'Special User Icon'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/get_special_users_icons'); ?>">Special User Icons</a>
                        </li>-->
                        
                        <li id="user_searches" <?php if($title == 'Searches'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/user_searches'); ?>">User Searches</a>
                        </li>
                        <li id="business_profiles" <?php if($title == 'Business Profiles'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/business_profiles'); ?>">Business Profiles</a>
                        </li>
                        <li id="flagged_business" <?php if($title == 'Flagged Business'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/flagged_business'); ?>">Flagged Business <?php if(getFlagCountSubUser()) { ?> <span style="color:red">  <?php echo '('.getFlagCountSubUser().')'; ?> </span> <?php } ?></a>
                        </li>
                        <li id="flagged_business" <?php if($title == 'Flagged Business Reviews'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/flagged_business_reviews'); ?>">Flagged Business Reviews <?php if(getFlagCountSubUserReviews()) { ?> <span style="color:red">  <?php echo '('.getFlagCountSubUserReviews().')'; ?> </span> <?php } ?></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li id="admin_wall">
                <a href="<?php echo asset('/admin_wall'); ?>">Wall Posts <?php if(getFlagCountPosts()) { ?> <span style="color:red">  <?php echo '('. getFlagCountPosts().')'; ?> </span> <?php } ?></a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="admin_wall" <?php if($title == 'Wall Posts'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/admin_wall'); ?>">Wall Posts</a>
                        </li>
                        <li id="flagged_posts" <?php if($title == 'Flagged Posts'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/flagged_posts'); ?>">Flagged Posts <?php if(getFlagCountPosts()) { ?> <span style="color:red">  <?php echo '('. getFlagCountPosts().')'; ?> </span> <?php } ?></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li id="shout_outs" <?php if($title == 'Shout Outs'){echo "class='active'";}?> >
                <a href="<?php echo asset('/shout_outs'); ?>">Shout Outs</a>
            </li>
            <li id="tags">
                <a href="<?php echo asset('/tags'); ?>">Keywords</a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="tags" <?php if($title == 'Keywords'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/tags'); ?>">Keywords</a>
                        </li>  
                        <li id="purchased_tags" <?php if($title == 'Purchased Tags'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/purchased_tags'); ?>">Purchased Keyword</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!--<li <?php //if($title == 'keywords'){echo "class='active'";}?> ><a href="<?php //echo asset('/keywords'); ?>">Keywords</a></li>-->
            <li id="user_questions">
                <a href="<?php echo asset('/user_questions'); ?>">Questions <?php $total = getFlagCountQuestion()+getFlagCountAnswers(); if($total) { ?> <span style="color:red">  <?php echo '('. $total.')'; ?> </span> <?php } ?></a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="user_questions" <?php if($title == 'User Questions'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/user_questions'); ?>">Questions</a>
                        </li>
                        <li id="flagged_questions" <?php if($title == 'Flagged Questions'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/flagged_questions'); ?>">Flagged Questions <?php  if(getFlagCountQuestion()) { ?> <span style="color:red">  <?php echo '('. getFlagCountQuestion().')'; ?> </span> <?php } ?></a>
                        </li>
                        <li id="flagged_answers" <?php if($title == 'Flagged Answers'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/flagged_answers'); ?>">Flagged Answers <?php if(getFlagCountAnswers()) { ?> <span style="color:red">  <?php echo '('. getFlagCountAnswers().')'; ?> </span> <?php } ?></a>
                        </li>
<!--                        <li id="expertise_questions" <?php if($title == 'Questions'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/expertise_questions'); ?>">Experience Questions</a>
                        </li>-->
<!--                        <li id="basic_qa" <?php if($title == 'Basic Q&A'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/basic_qa'); ?>">Basic Q&A</a>
                        </li>-->
                    </ul>
                </div>
            </li>
            <li id="user_icons">
                <a href="<?php echo asset('/user_icons'); ?>">Icons</a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="user_icons" <?php if($title == 'Icons'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/user_icons'); ?>">Icons</a>
                        </li>
                        <li id="special_icons" <?php if($title == 'Special Icons'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/special_icons'); ?>">Special Icons</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li id="strains">
                <a href="<?php echo asset('/strains'); ?>" >Strains <?php $total_flags_strain=getFlagCountStainReviews()+ getFlagCountStainImages(); if($total_flags_strain) { ?> <span style="color:red">  <?php echo '('.$total_flags_strain.')'; ?> </span> <?php } ?></a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="strains" <?php if($title == 'Strains'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/strains'); ?>" >Strains</a>
                        </li>
                        <li id="strain-flagged-images" <?php if($title == 'Strain Flagged Images'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/strain_flagged_images'); ?>" >Strain Flagged Images <?php  if(getFlagCountStainImages()) { ?> <span style="color:red">  <?php echo '('.getFlagCountStainImages().')'; ?> </span> <?php } ?></a>
                        </li>
                        <li id="strain-flagged-reviews" <?php if($title == 'Strain Flagged Reviews'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/strain_flagged_reviews'); ?>" >Strain Flagged Reviews <?php  if(getFlagCountStainReviews()) { ?> <span style="color:red">  <?php echo '('.getFlagCountStainReviews().')'; ?> </span> <?php } ?></a>
                        </li>
                        <li id="flavors" <?php if($title == 'Flavors' || $title == 'Flavor Categories'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/flavors'); ?>">Flavors</a>
                        </li>
                        <li id="medical_conditions" <?php if($title == 'Medical Conditions'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/medical_conditions'); ?>">Medical Use</a>
                        </li>
                        <li id="negative_effects" <?php if($title == 'Negative Effects'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/negative_effects'); ?>">Negative Effects</a>
                        </li>
                        <li id="sensations" <?php if($title == 'Sensations'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/sensations'); ?>">Mood And Sensations</a>
                        </li>
                        <li id="preventions" <?php if($title == 'Preventions'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/preventions'); ?>">Disease Preventions</a>
                        </li>
                        <li id="users_strains" <?php if($title == 'Users Edits'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/users_strains'); ?>" >User Edits</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li id="admin_products">
                <a href="<?php echo asset('/admin_products'); ?>">Products</a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="admin_products" <?php if($title == 'Products'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/admin_products'); ?>">Products</a>
                        </li>
                        <li id="get_orders" <?php if($title == 'Orders'){echo "class='active'";}?> a="a">
                            <a href="<?php echo asset('/get_orders'); ?>">Orders</a>
                        </li>
                        <li id="payment_methods" <?php if($title == 'Payment Methods'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/payment_methods'); ?>">Payment Methods</a>
                        </li>
                        <li id="admin_payment" <?php if($title == 'Payments Record'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/admin_payment'); ?>">Payments Record</a>
                        </li>
                        <li id="transactions" <?php if($title == 'Transactions'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/transactions'); ?>">Transactions</a>
                        </li>
                        <li id="admin_products" <?php if($title == 'Menu Categories'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/admin_menu_categories'); ?>">Menu Categories</a>
                        </li>
                    </ul>
                </div>
            </li>
            
<!--            <ul>-->
<!--                <li --><?php //if($title == 'strains'){echo "class='active'";}?><!-- ><a href="--><?php //echo asset('/strains'); ?><!--">View Strains</a></li>-->
<!--                <li><a href="">Strain Images</a></li>-->
<!--            </ul>-->
            <!--<li <?php //if($title == 'legal'){echo "class='active'";}?> ><a href="<?php //echo asset('/legal'); ?>">Legal</a></li>-->
            <li id="admin_journals" <?php if($title == 'Journals'){echo "class='active'";}?> ><a href="<?php echo asset('/admin_journals'); ?>">Journals</a></li>
            <li id="admin_articles" <?php if($title == 'Articles'){echo "class='active'";}?> ><a href="<?php echo asset('/admin_articles'); ?>">Articles</a></li>
            <li id="admin_support">
                <a href="<?php echo asset('/admin_support'); ?>">Help & Support</a>
                <div class="span-column">
                    <span class="caret submenulists"></span>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    <ul>
                        <li id="admin_support" <?php if($title == 'Support'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/admin_support'); ?>">Help & Support</a>
                        </li>    
                        <li id="terms" <?php if($title == 'Terms'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/terms'); ?>">Terms</a>
                        </li>
                        <li id="policy" <?php if($title == 'Policy'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/policy'); ?>">Policies</a>
                        </li>
                        
                        
                        <li id="contact" <?php if($title == 'Contact Us'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/contact'); ?>">Contact Us</a>
                        </li>
                        
                        
                        <li id="about_us" <?php if($title == 'About Us'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/about_us'); ?>">About Us</a>
                        </li>
                        
                        
                        <li id="business_services" <?php if($title == 'Business Services'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/business_services'); ?>">Business Services</a>
                        </li>
                        
                        
                        <li id="careers_admin" <?php if($title == 'Careers'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/careers_admin'); ?>">Careers</a>
                        </li>
                        
                        
                        <li id="who_can_join" <?php if($title == 'Who can join'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/who_can_join'); ?>">Who can join</a>
                        </li>
                        
                        
<!--                        <li id="daily_buzz" <?php if($title == 'Daily Buzz'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/daily_buzz'); ?>">Daily Buzz</a>
                        </li>-->
                        
                        
                        <li id="advertise" <?php if($title == 'Advertise'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/advertise'); ?>">Advertise</a>
                        </li>
                        
                        
                        <li id="commercial" <?php if($title == 'Commercials'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/commercial'); ?>">Commercials</a>
                        </li>
                        
                        
                        <li id="final_note" <?php if($title == 'Final Note'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/final_note'); ?>">Final Note</a>
                        </li>
                        
                        
                        <li id="what_to_expect" <?php if($title == 'What to expect'){echo "class='active'";}?> >
                            <a href="<?php echo asset('/what_to_expect'); ?>">What to expect</a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            <li id="send_to_all" <?php if($title == 'Send Notification'){echo "class='active'";}?> ><a href="<?php echo asset('/send_to_all'); ?>">Send Notification</a></li>
            <li id="send_to_all" <?php if($title == 'Import Section'){echo "class='active'";}?> ><a href="<?php echo asset('/import_sction'); ?>">Import Section</a></li>
            <li id="send_to_all" <?php if($title == 'Home Image'){echo "class='active'";}?> ><a href="<?php echo asset('/home_image'); ?>">Home Image</a></li>
            <li id="admin_logout" ><a href="<?php echo asset('/admin_logout'); ?>">Logout</a></li>
            <input type="hidden" value="<?php echo $title; ?>" id="strain">
        </ul>
    </div>
    <sidebar class="copy">&copy; Copyright <?=date('Y')?>
<!--    <div class="codingpixel">-->
<!--        Designed & Developed by <a href="http://codingpixel.com" target="_blank">CodingPixel</a>-->
<!--    </div>-->
    </sidebar>
</aside>

<script>
    var base_url = "<?php echo url('/'); ?>";
    $("#profile_photo").change(function (event){
        var data = event.target.files;
        var image = new FormData(event.target);
        image.append('image',data[0]);
        image.append('_token', "<?php echo csrf_token(); ?>");
        $.ajax({
            url: base_url + '/add/profile_image',
            method : "POST",
            data: image,
            contentType:false,
            processData:false,
            success: function(data){
                data = JSON.parse(data);
                $('#profile_image').attr('src',base_url + data);
            }
        });

    });
    $( document ).ready(function() {
        $('.span-column').on('click',function(){
            $(this).next('.dropdown-content').toggle();
        });
        $('li.active').parent('ul').parent('#myDropdown').toggle();
    });
//    $( document ).ready(function() {
//        var title = $('#strain').val();
//        if(title == 'strains'){
//            $('.navList ul').fadeIn();
//        }else{
//            $('.navList ul').fadeOut();
//        }
//
//        $('.mi-click').click(function(){
//            $('.navList ul').fadeToggle();
//        })
//    });


</script>


