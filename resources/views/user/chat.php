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
                    <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                    <li>Messages</li>
                </ul>
                <div class="groups add">
                    <header class="intro-header">
                        <h1 class="custom-heading orange">California Healing</h1>
                    </header>
                    <div class="messages">
                        <input data-emojiable="true">
                        <span class="msg-time">Monday, 3:30pm</span>
                        <div class="msg">
                            <a href="#" class="likes"><span>13</span></a>
                            <div class="img-holder"><img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image"></div>
                            <div class="txt">
                                <strong><a href="chat-settings.html">marimmj</a></strong>
                                <p>Hey everybody, what's up? Happy Monday!</p>
                            </div>
                        </div>
                        <div class="joined-notice"><span>GlitterStorm has joined the group</span></div>
                        <div class="msg">
                            <a href="#" class="likes"><span>13</span></a>
                            <div class="img-holder"><img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image"></div>
                            <div class="txt">
                                <strong>GlitterStorm</strong>
                                <p>Hi everyone. I'm new to the group. I live in Miami, FL and I hear that marijuana will be legal here soon. I'm interested in knowing how it has affected the community in California.</p>
                            </div>
                        </div>
                        <div class="msg">
                            <a href="#" class="likes"><span>13</span></a>
                            <div class="img-holder"><img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image"></div>
                            <div class="txt">
                                <strong>marimmj</strong>
                                <p>Hey everybody, what's up? Happy Monday!</p>
                            </div>
                        </div>
                        <span class="msg-time">Monday, 3:30pm</span>
                        <div class="msg">
                            <a href="#" class="likes"><span>13</span></a>
                            <div class="img-holder"><img src="<?php echo asset('userassets/images/img3.png') ?>" alt="Image"></div>
                            <div class="txt">
                                <strong>marimmj</strong>
                                <p>Hey everybody, what's up? Happy Monday!</p>
                            </div>
                            <img src="<?php echo asset('userassets/images/img13.jpg') ?>" alt="Image">
                        </div>
                        <form action="#" class="message-form">
                            <fieldset>
                                <label for="attachment" class="attachment-label">Attachment</label>
                                <input type="file" id="attachment" class="hidden">
                                <input type="text" placeholder="Type message..." data-emojiable="true">
                                <div class="emo-holder">
<!--                                    <a href="#" class="btn-emotions"></a>
                                    <input type="submit" value="Submit">-->
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <?php include('includes/footer.php');?>
    <script src="<?php echo asset('userassets/js/config.js')?>"></script>
    <script src="<?php echo asset('userassets/js/util.js')?>"></script>
    <script src="<?php echo asset('userassets/js/jquery.emojiarea.js')?>"></script>
    <script src="<?php echo asset('userassets/js/emoji-picker.js')?>"></script>
</body>
<script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: 'userassets/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
      var emoji=[];
      function getvalues(){
          $('.emoji-wysiwyg-editor img').each(function() {
              emoji.push($(this).attr('alt'));
              
});
$('#emoji').val(emoji);
$('#forms').submit();
      }
    </script>
</html>