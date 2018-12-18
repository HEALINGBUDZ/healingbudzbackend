<div  id="product" class="tab-pane fade <?php if (isset($_GET['tab']) && $_GET['tab'] == 'product') { ?> active in <?php } ?>">
    <?php if ($budz->user_id == $current_id) { ?>
        <div class="cus-btns">
            <?php if ($budz->subscriptions) { ?> 
                <a href="#add-product" class="btn-popup btn-primary">Add Product</a>
            <?php } else { ?>
                Please Subscribe
            <?php } ?>
        </div>
    <?php } ?>
    <?php
    $product_hybrid = 0;
    $product_Indica = 0;
    $product_Sativa = 0;
    $product_Others = 0;
    if (count($budz->products) > 0) {
        $unique = $budz->products->unique('menu_cat_id');

        $vacls = $unique->values()->all();
        $chec_in_array = [];
        ?>
        <div class="new-produ-main">   
            <?php
            foreach ($vacls as $group) {

                if ($group->menu_cat_id) {
                    foreach ($budz->products->where('menu_cat_id', $group->menu_cat_id) as $product) {

                        if ($product->menu_cat_id) {
                            if (!(in_array($product->category->title, $chec_in_array))) {
                                $chec_in_array[] = $product->category->title;
                                echo '<span style="color:#942b88">' . $product->category->title . '</span>';
                            }
                            ?>
                            <!--Dummy Text-->
                            <div class="new-produ-list img-holder">
                                <?php if (!$product->images->isEmpty()) { ?>
                                    <?php
                                    $i = 1;
                                    foreach ($product->images as $productImage) {
                                        $path = asset(image_fix_orientation('public/images' . $productImage->image));
                                        ?>
                                        <a style="<?= $i != 1 ? 'display: none;' : '' ?>" class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $product->id ?>">
                                            <figure style="background-image: url('<?php echo $path ?>');"><figcaption><?php if ($i == 1 && $product->images->count() > 1) { ?><i class="img-cap"><?= $product->images->count() - 1 ?>+</i><?php } ?></figcaption></figure>
                                        </a>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    <?php
                                } else {
                                    $path = asset('userassets/images/placeholder.jpg');
                                    ?>
                                    <a class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $product->id ?>">
                                        <figure style="background-image: url('<?php echo $path ?>');"><figcaption></figcaption></figure>
                                    </a>
                                <?php } ?>
                                <div class="produ-inner">
                                    <div class="produ-inn-top">
                                        <h3><?php echo $product->name; ?></h3>
                                        <div class="produ-inn-icons">
                                            <?php if ($product->subUser->user_id == $current_id) { ?>
                                                <a class="btn-popup" href="#edit-product<?= $product->id ?>"><i class=" fa fa-edit"></i></a>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_product<?= $product->id ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <a href="#share-post<?= $budz->id ?>" class="flag-icon btn-popup"><i class="fa fa-share-alt"></i></a>
                                        </div>
                                        <span class="produ-inn-top-top">
                                            <?php if ($product->strainType) { ?>
                                                <span><em class="key <?= $product->strainType->title ?>"><?= substr($product->strainType->title,0,1) ?></em> <?php echo $product->strainType->title; ?></span>
                                                <?php } ?><ul>
                                                    <li><?php echo $product->cbd; ?>% CBD</li>
                                                    <li><?php echo $product->thc; ?>% THC</li>
                                                </ul>
                                            
                                        </span>
                                    </div>
                                    <div class="produ-inn-bot">
                                        <ul>
                                            <?php foreach ($product->pricing as $pricing) { ?>


                                                <li>
                                                    <?php if ($pricing->weight) { ?>
                                                        <span class="pr-top-bg"><?= $pricing->weight ?> </span>
                                                    <?php } else { ?>
                                                        <span class="pr-top-bg" >0</span>
                                                    <?php } ?>
                                                    <?php
                                                    if ($pricing->price) {
                                                        $price = explode('.', $pricing->price);
                                                        if (count($price) > 1) {
                                                            ?>
                                                            <span class="pr-bot-bg">
                                                                <sup>$</sup>
                                                                <b><?= $price[0] ?></b>
                                                                <sup><?= $price[1] ?></sup>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="pr-bot-bg">
                                                                <sup>$</sup>
                                                                <b><?= $price[0] ?></b>
                                                                <sup>00</sup>
                                                            </span>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <span class="pr-bot-bg">
                                                            <sup>$</sup>
                                                            <b>00</b>
                                                            <sup>00</sup>
                                                        </span>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="pr-str-img-des">
                                             <?php if ($product->strain_id) { ?>
                                            <a href="<?php echo asset('strain-details/' . $product->strain_id); ?>">
                                                <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="icon" />
                                                <span>Strain<i class="fa fa-chevron-right"></i></span>
                                            </a>
                                             <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--Dummy Text-->
                            <?php
                            ?>      
                            <script>
                                window['attachments' +<?= $product->id ?>] = [];
                                window['attachment_counter' +<?= $product->id ?>] = 0;
                            </script>
                            <div id="edit-product<?= $product->id ?>" class="popup inp-pop">
                                <div class="popup-holder">
                                    <div class="popup-area">
                                        <div class="text">
                                            <header class="header low-pad">
                                                <h2>Update Product</h2>
                                            </header>
                                            <form action="<?php echo asset('edit-product') ?>" class="add-service-form product-form" id="product-form<?= $product->id ?>" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                                <input type="hidden" name="sub_user_id" value="<?php echo $budz->id; ?>">
                                                <input type="hidden" name="business_type_id" value="<?php echo $budz->business_type_id; ?>">
                                                <input type="hidden" name="attachments" id="attachments<?= $product->id ?>">
                                                <fieldset>
                                                    <div class="upl-row">
                                                        <div class="fields fluid">
                                                            <div class="align-left">
                                                                <input  max="5" class="custom-file file" product-id="<?= $product->id ?>" id="file<?= $product->id ?>" type="file" name="file[]" multiple accept="image/*" style="display: none;">
                                                                <label for="file<?= $product->id ?>" class="file-label hb_upload_photo" >
                                                                    <!--Attachments <span>Max 5</span>-->
                                                                    <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                                                     <span>Upload Photo</span>
                                                                </label>
                                                            </div>
                                                            <ul id="imagePreview<?= $product->id ?>" class="uploaded-files list-none">
                    <?php if (!$product->images->isEmpty()) { ?>
                        <?php foreach ($product->images as $productImage) { ?>

                                                                        <script>
                                                                            window['attachments' +<?= $product->id ?>].push({
                                                                                "file_path": "<?= asset(image_fix_orientation('public/images' . $productImage->image)) ?>",
                                                                                "delete_path": 'public/images<?= $productImage->image ?>',
                                                                                "path": '<?= $productImage->image ?>',
                                                                                "poster": '',
                                                                                "type": 'image'
                                                                            });
                                                                            window['attachment_counter' +<?= $product->id ?>]++;
                                                                        </script>

                                                                        <li id="<?= asset('public/images' . $productImage->image); ?>">
                                                                        <?php /*    <img src="<?= asset('public/images' . $productImage->image); ?>"> */ ?>
                                                                            <figure class="attache-back-image" style="background-image:url('<?= asset('public/images' . $productImage->image); ?>')"></figure>
                                                                            <a href="#" class="btn-remove" onclick="removeAttachmentEdit('public/images<?= $productImage->image ?>',<?= $product->id ?>)">
                                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                        <?php } ?>
                    <?php } ?>
                                                            </ul>
                                                            <div id="floading<?= $product->id ?>" class="floading" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Loading..</div>
                                                        </div>
                                                    </div>
                                                    <div class="s-row">
                                                        <label>Name</label>
                                                        <input autocomplete="off" maxlength="30" type="text" value="<?= isset($product->name) ? $product->name : '' ?>"  name="product_name" required="" class="inp-cls" placeholder="Type product name..">

                                                    </div>
                                                    <div class="s-row">
                                                        <label for="p-name">Category</label>
                                                        <input autocomplete="off" maxlength="30" type="text" id="p-name" name="cat_id"  class="inp-cls" value="<?= isset($product->menu_cat_id) ? $product->category->title : '' ?>" placeholder="Type category name..">

                                                    </div>
                                                    <!--<div class="s-row">-->
                                                    <!--<select data-placeholder="Search Strain" name="strain_id" class="chosen-select" tabindex="1">-->
                                                    <select data-placeholder="Search Strain" name="strain_id" class="inp-cls">
                                                        <option value="" selected>Select a strain</option>
                    <?php foreach ($strains as $strain) { ?>
                                                            <option value="<?php echo $strain->id; ?>" <?= $strain->id == $product->strain_id ? 'selected' : '' ?> ><?php echo $strain->title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!--</div>-->
                                                    <div class="s-row">
                                                        <div class="s-col">
                                                            <label for="thc">THC %</label>
                                                            <input maxlength="3" autocomplete="off" value="<?= isset($product->thc) ? $product->thc : ''; ?>" type="number" id="thc" name="thc" min="0" max="100"  step="any" class="inp-cls">
                                                        </div>
                                                        <div class="s-col">
                                                            <label for="cbd">CBD %</label>
                                                            <input maxlength="3" autocomplete="off" value="<?= isset($product->cbd) ? $product->cbd : '' ?>" type="number" id="cbd" name="cbd" min="0" max="100"  step="any" class="inp-cls">
                                                        </div>
                                                    </div>
                    <?php
                    $pricings = $product->pricing->toArray();
                    ?>
                                                    <div class="s-row">
                                                        <div class="s-col">
                                                            <label for="weight1">Weight 1</label>
                                                            <input  maxlength="8" autocomplete="off" value="<?= (isset($pricings[0]['weight']) ? $pricings[0]['weight'] : ''); ?>"  type="text" id="weight1" name="weight1" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" required="" class="inp-cls">
                                                        </div>
                                                        <div class="s-col">
                                                            <label for="price1">Price 1</label>
                                                            <input max="9999"  autocomplete="off" value="<?= isset($pricings[0]['price']) ? $pricings[0]['price'] : ''; ?>" type="number" id="price1" name="price1" min="0"  maxlength="4" required="" step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                        </div>
                                                    </div>
                                                    <div class="s-row">
                                                        <div class="s-col">
                                                            <label for="weight2">Weight 2</label>
                                                            <input maxlength="8"  autocomplete="off" value="<?= isset($pricings[1]['weight']) ? $pricings[1]['weight'] : '' ?>" type="text" id="weight2" name="weight2" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                                        </div>
                                                        <div class="s-col">
                                                            <label for="price2">Price 2</label>
                                                            <input max="9999" autocomplete="off" value="<?= isset($pricings[1]['price']) ? $pricings[1]['price'] : '' ?>" type="number" id="price2" name="price2" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                        </div>
                                                    </div>
                                                    <div class="s-row">
                                                        <div class="s-col">
                                                            <label for="weight3">Weight 3</label>
                                                            <input maxlength="8"  autocomplete="off" value="<?= isset($pricings[2]['weight']) ? $pricings[2]['weight'] : '' ?>" type="text" id="weight3" name="weight3" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                                        </div>
                                                        <div class="s-col">
                                                            <label for="price3">Price 3</label>
                                                            <input max="9999" autocomplete="off" value="<?= isset($pricings[2]['price']) ? $pricings[2]['price'] : '' ?>" type="number" id="price3" name="price3" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                        </div>
                                                    </div>
                                                    <div class="s-row">
                                                        <div class="s-col">
                                                            <label for="weight4">Weight 4</label>
                                                            <input  maxlength="8" autocomplete="off" value="<?= isset($pricings[3]['weight']) ? $pricings[3]['weight'] : ''; ?>" type="text" id="weight4" name="weight4" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                                        </div>
                                                        <div class="s-col">
                                                            <label for="price4">Price 4</label>
                                                            <input max="9999" autocomplete="off" value="<?= isset($pricings[3]['price']) ? $pricings[3]['price'] : '' ?>" type="number" id="price4" name="price4" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                        </div>
                                                    </div>
                                                    <div class="s-row">
                                                        <div class="">
                                                            <input type="button" value="Submit" class="s-file-label edit-product-submit-btn" id="saveform<?= $product->id ?>" product-id="<?= $product->id ?>" style="width: 175px;border-radius: 7px;font-weight: normal;background: #d5ad30;margin: 10px 0;color: #000;">
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            <a href="#" class="btn-close"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="delete_product<?= $product->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Product </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure to delete this product </p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?php echo asset('delete-product/' . $product->id); ?>" type="button" class="btn-heal">yes</a>
                                            <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                <?php
                }
            }
        }
    }

    echo '</div><div class="new-produ-main">';
    foreach ($budz->products as $product) {
        if (!$product->menu_cat_id) {
            $product_Others++;
            if ($product_Others == 1) {
                echo '<span style="color:#942b88">Others</span>';
            }
            ?> 
                    <!--Dummy Text-->
                    <div class="new-produ-list img-holder">
                        <?php if (!$product->images->isEmpty()) { ?>
                            <?php
                            $i = 1;
                            foreach ($product->images as $productImage) {
                                $path = asset(image_fix_orientation('public/images' . $productImage->image));
                                ?>
                                <a style="<?= $i != 1 ? 'display: none;' : '' ?>" class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $product->id ?>">
                                    <figure style="background-image: url('<?php echo $path ?>');"><figcaption><?php if ($i == 1 && $product->images->count() > 1) { ?><i class="img-cap"><?= $product->images->count() - 1 ?>+</i><?php } ?></figcaption></figure>
                                </a>
                                <?php
                                $i++;
                            }
                            ?>
                            <?php
                        } else {
                            $path = asset('userassets/images/placeholder.jpg');
                            ?>
                            <a class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $product->id ?>">
                                <figure style="background-image: url('<?php echo $path ?>');"><figcaption></figcaption></figure>
                            </a>
                        <?php } ?>
                        <div class="produ-inner">
                            <div class="produ-inn-top">
                                <h3><?php echo $product->name; ?></h3>
                                <div class="produ-inn-icons">
                                    <?php if ($product->subUser->user_id == $current_id) { ?>
                                        <a class="btn-popup" href="#edit-product<?= $product->id ?>"><i class=" fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_product<?= $product->id ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <?php } ?>
                                    <a href="#share-post<?= $budz->id ?>" class="flag-icon btn-popup"><i class="fa fa-share-alt"></i></a>
                                </div>
                                <span class="produ-inn-top-top">
                                    <?php if ($product->strainType) { ?>
                                                <span><em class="key <?= $product->strainType->title ?>"><?= substr($product->strainType->title,0,1) ?></em> <?php echo $product->strainType->title; ?></span>
                                                <?php } ?><ul>
                                                    <li><?php echo $product->cbd; ?>% CBD</li>
                                                    <li><?php echo $product->thc; ?>% THC</li>
                                                </ul>
                                            
                                </span>
                            </div>
                            <div class="produ-inn-bot">
                                <ul>
                                    <?php foreach ($product->pricing as $pricing) { ?>


                                        <li>
                                            <?php if ($pricing->weight) { ?>
                                                <span class="pr-top-bg"><?= $pricing->weight ?> </span>
                                            <?php } else { ?>
                                                <span class="pr-top-bg" >0</span>
                                            <?php } ?>
                                            <?php
                                            if ($pricing->price) {
                                                $price = explode('.', $pricing->price);
                                                if (count($price) > 1) {
                                                    ?>
                                                    <span class="pr-bot-bg">
                                                        <sup>$</sup>
                                                        <b><?= $price[0] ?></b>
                                                        <sup><?= $price[1] ?></sup>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="pr-bot-bg">
                                                        <sup>$</sup>
                                                        <b><?= $price[0] ?></b>
                                                        <sup>00</sup>
                                                    </span>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <span class="pr-bot-bg">
                                                    <sup>$</sup>
                                                    <b>00</b>
                                                    <sup>00</sup>
                                                </span>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                           <div class="pr-str-img-des">
                                        <?php if ($product->strain_id) { ?>
                                        <a href="<?php echo asset('strain-details/' . $product->strain_id); ?>">
                                            <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="icon" />
                                            <span>Strain<i class="fa fa-chevron-right"></i></span>
                                        </a>
                                        <?php } ?>
                                    </div>
                            </div>

                        </div>
                    </div>
                    <!--Dummy Text-->
                    <?php
                    ?>      
                    <script>
                        window['attachments' +<?= $product->id ?>] = [];
                        window['attachment_counter' +<?= $product->id ?>] = 0;
                    </script>
                    <div id="edit-product<?= $product->id ?>" class="popup inp-pop">
                        <div class="popup-holder">
                            <div class="popup-area">
                                <div class="text">
                                    <header class="header low-pad">
                                        <h2>Update Product</h2>
                                    </header>
                                    <form action="<?php echo asset('edit-product') ?>" class="add-service-form product-form" id="product-form<?= $product->id ?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                        <input type="hidden" name="sub_user_id" value="<?php echo $budz->id; ?>">
                                        <input type="hidden" name="business_type_id" value="<?php echo $budz->business_type_id; ?>">
                                        <input type="hidden" name="attachments" id="attachments<?= $product->id ?>">
                                        <fieldset>
                                            <div class="upl-row">
                                                <div class="fields fluid">
                                                    <div class="align-left">
                                                        <input  max="5" class="custom-file file" product-id="<?= $product->id ?>" id="file<?= $product->id ?>" type="file" name="file[]" multiple accept="image/*" style="display: none;">
                                                        <label for="file<?= $product->id ?>" class="file-label hb_upload_photo" >
                                                            <!--Attachments <span>Max 5</span>-->
                                                            <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                                            <span>Upload Photo</span>
                                                        </label>
                                                    </div>
                                                    <ul id="imagePreview<?= $product->id ?>" class="uploaded-files list-none">
                                                        <?php if (!$product->images->isEmpty()) { ?>
                                                            <?php foreach ($product->images as $productImage) { ?>

                                                                <script>
                                                                    window['attachments' +<?= $product->id ?>].push({
                                                                        "file_path": "<?= asset(image_fix_orientation('public/images' . $productImage->image)) ?>",
                                                                        "delete_path": 'public/images<?= $productImage->image ?>',
                                                                        "path": '<?= $productImage->image ?>',
                                                                        "poster": '',
                                                                        "type": 'image'
                                                                    });
                                                                    window['attachment_counter' +<?= $product->id ?>]++;
                                                                </script>

                                                                <li id="<?= asset('public/images' . $productImage->image); ?>">
                                                                <?php /*    <img src="<?= asset('public/images' . $productImage->image); ?>"> */ ?>
                                                                    <figure class="attache-back-image" style="background-image:url('<?= asset('public/images' . $productImage->image); ?>')"></figure>
                                                                    <a href="#" class="btn-remove" onclick="removeAttachmentEdit('public/images<?= $productImage->image ?>',<?= $product->id ?>)">
                                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                    <div id="floading<?= $product->id ?>" class="floading" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Loading..</div>
                                                </div>
                                            </div>
                                            <div class="s-row">
                                                <label>Name</label>
                                                <input autocomplete="off" maxlength="30" type="text" value="<?= isset($product->name) ? $product->name : '' ?>"  name="product_name" required="" class="inp-cls" placeholder="Type product name..">

                                            </div>
                                            <div class="s-row">
                                                <label for="p-name">Category</label>
                                                <input autocomplete="off" maxlength="30" type="text" id="p-name" name="cat_id"  class="inp-cls" value="<?= isset($product->menu_cat_id) ? $product->category->title : '' ?>" placeholder="Type category name..">

                                            </div>
                                            <!--<div class="s-row">-->
                                            <!--<select data-placeholder="Search Strain" name="strain_id" class="chosen-select" tabindex="1">-->
                                            <select data-placeholder="Search Strain" name="strain_id" class="inp-cls">
                                                <option value="" selected>Select a strain</option>
                                                <?php foreach ($strains as $strain) { ?>
                                                    <option value="<?php echo $strain->id; ?>" <?= $strain->id == $product->strain_id ? 'selected' : '' ?> ><?php echo $strain->title; ?></option>
                                                <?php } ?>
                                            </select>
                                            <!--</div>-->
                                            <div class="s-row">
                                                <div class="s-col">
                                                    <label for="thc">THC %</label>
                                                    <input maxlength="3"  autocomplete="off" value="<?= isset($product->thc) ? $product->thc : ''; ?>" type="number" id="thc" name="thc" min="0" max="100"  step="any" class="inp-cls">
                                                </div>
                                                <div class="s-col">
                                                    <label for="cbd">CBD %</label>
                                                    <input maxlength="3"  autocomplete="off" value="<?= isset($product->cbd) ? $product->cbd : '' ?>" type="number" id="cbd" name="cbd" min="0" max="100"  step="any" class="inp-cls">
                                                </div>
                                            </div>
                                            <?php
                                            $pricings = $product->pricing->toArray();
                                            ?>
                                            <div class="s-row">
                                                <div class="s-col">
                                                    <label for="weight1">Weight 1</label>
                                                    <input maxlength="8" autocomplete="off" value="<?= (isset($pricings[0]['weight']) ? $pricings[0]['weight'] : ''); ?>"  type="text" id="weight1" name="weight1" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" required="" class="inp-cls">
                                                </div>
                                                <div class="s-col">
                                                    <label for="price1">Price 1</label>
                                                    <input max="9999"  autocomplete="off" value="<?= isset($pricings[0]['price']) ? $pricings[0]['price'] : ''; ?>" type="number" id="price1" name="price1" min="0"  required="" step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                </div>
                                            </div>
                                            <div class="s-row">
                                                <div class="s-col">
                                                    <label for="weight2">Weight 2</label>
                                                    <input maxlength="8" autocomplete="off" value="<?= isset($pricings[1]['weight']) ? $pricings[1]['weight'] : '' ?>" type="text" id="weight2" name="weight2" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                                </div>
                                                <div class="s-col">
                                                    <label for="price2">Price 2</label>
                                                    <input max="9999" autocomplete="off" value="<?= isset($pricings[1]['price']) ? $pricings[1]['price'] : '' ?>" type="number" id="price2" name="price2" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                </div>
                                            </div>
                                            <div class="s-row">
                                                <div class="s-col">
                                                    <label for="weight3">Weight 3</label>
                                                    <input maxlength="8" autocomplete="off" value="<?= isset($pricings[2]['weight']) ? $pricings[2]['weight'] : '' ?>" type="text" id="weight3" name="weight3" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                                </div>
                                                <div class="s-col">
                                                    <label for="price3">Price 3</label>
                                                    <input max="9999"  autocomplete="off" value="<?= isset($pricings[2]['price']) ? $pricings[2]['price'] : '' ?>" type="number" id="price3" name="price3" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                </div>
                                            </div>
                                            <div class="s-row">
                                                <div class="s-col">
                                                    <label for="weight4">Weight 4</label>
                                                    <input maxlength="8" autocomplete="off" value="<?= isset($pricings[3]['weight']) ? $pricings[3]['weight'] : ''; ?>" type="text" id="weight4" name="weight4" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                                </div>
                                                <div class="s-col">
                                                    <label for="price4">Price 4</label>
                                                    <input max="9999" autocomplete="off" value="<?= isset($pricings[3]['price']) ? $pricings[3]['price'] : '' ?>" type="number" id="price4" name="price4" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                                </div>
                                            </div>
                                            <div class="s-row">
                                                <div class="">
                                                    <input type="button" value="Submit" class="s-file-label edit-product-submit-btn" id="saveform<?= $product->id ?>" product-id="<?= $product->id ?>" style="width: 175px;border-radius: 7px;font-weight: normal;background: #d5ad30;margin: 10px 0;color: #000;">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                    <a href="#" class="btn-close"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="delete_product<?= $product->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Product </h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to delete this product </p>
                                </div>
                                <div class="modal-footer">
                                    <a href="<?php echo asset('delete-product/' . $product->id); ?>" type="button" class="btn-heal">yes</a>
                                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php
                }
            }
//            echo '</div>';
            ?>


 </div>
<?php } ?>
   
    <div id="add-product" class="popup inp-pop">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="text">
                    <header class="header low-pad">
                        <h2>Add Product</h2>
                    </header>
                    <form action="<?php echo asset('add-product') ?>" class="add-service-form product-form" id="product-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="sub_user_id" value="<?php echo $budz->id; ?>">
                        <input type="hidden" name="business_type_id" value="<?php echo $budz->business_type_id; ?>">
                        <input type="hidden" name="attachments" id="attachments">
                        <fieldset>
                            <div class="upl-row">
                                <div class="fields fluid">
                                    <div class="align-left">
                                        <input  max="5" class="custom-file" id="file" type="file" name="file[]" multiple accept="image/*" style="display: none;">
                                        <label for="file" class="file-label hb_upload_photo" >
                                            <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                            <span>Upload Photo</span>
                                        </label>
                                    </div>
                                    <div>
                                        <ul id="imagePreview" class="uploaded-files list-none">
                                        </ul>
                                        <div id="floading" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Loading..</div>
                                    </div>
                                </div>
                            </div>
                            <div class="s-row">
                                <label for="p-name">Name</label>
                                <input autocomplete="off" maxlength="30" type="text" id="p-name" name="product_name" required="" class="inp-cls" placeholder="Type product name..">

                            </div>
                            <div class="s-row">
                                <label for="p-name">Category</label>
                                <input autocomplete="off" maxlength="30" type="text" id="p-name" name="cat_id"  class="inp-cls" placeholder="Type category name..">

                            </div>
                            <!--<div class="s-row">-->
                            <!--<select data-placeholder="Search Strain" name="strain_id" class="chosen-select" tabindex="1">-->
                            <select data-placeholder="Search Strain" name="strain_id" class="inp-cls">
                                <option value="" selected>Select a strain</option>
                                <?php foreach ($strains as $strain) { ?>
                                    <option value="<?php echo $strain->id; ?>"><?php echo $strain->title; ?></option>
<?php } ?>
                            </select>
                            <!--</div>-->
                            <div class="s-row">
                                <div class="s-col">
                                    <label for="thc">THC %</label>
                                    <input maxlength="3"  autocomplete="off"  type="number" id="thc" name="thc" min="0" max="100"  step="any" class="inp-cls">
                                </div>
                                <div class="s-col">
                                    <label for="cbd">CBD %</label>
                                    <input maxlength="3"  autocomplete="off"  type="number" id="cbd" name="cbd" min="0" max="100"   step="any" class="inp-cls">
                                </div>
                            </div>
                            <div class="s-row">
                                <div class="s-col">
                                    <label for="weight1">Weight 1</label>
                                    <input maxlength="8" autocomplete="off"  type="text" id="weight1" name="weight1" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" required="" class="inp-cls">
                                </div>
                                <div class="s-col">
                                    <label for="price1">Price 1</label>
                                    <input  autocomplete="off"  type="number" id="price1" name="price1" min="0" max="9999" required="" step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                </div>
                            </div>
                            <div class="s-row">
                                <div class="s-col">
                                    <label for="weight2">Weight 2</label>
                                    <input maxlength="8" autocomplete="off"  type="text" id="weight2" name="weight2" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                </div>
                                <div class="s-col">
                                    <label for="price2">Price 2</label>
                                    <input max="9999"  autocomplete="off"  type="number" id="price2" name="price2" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                </div>
                            </div>
                            <div class="s-row">
                                <div class="s-col">
                                    <label for="weight3">Weight 3</label>
                                    <input maxlength="8" autocomplete="off"  type="text" id="weight3" name="weight3" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                </div>
                                <div class="s-col">
                                    <label for="price3">Price 3</label>
                                    <input max="9999"  autocomplete="off"  type="number" id="price3" name="price3" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                </div>
                            </div>
                            <div class="s-row">
                                <div class="s-col">
                                    <label for="weight4">Weight 4</label>
                                    <input maxlength="8" autocomplete="off"  type="text" id="weight4" name="weight4" placeholder="e.g. 1 lb, 16 oz, 453.6 g or 0.45 kg" class="inp-cls">
                                </div>
                                <div class="s-col">
                                    <label for="price4">Price 4</label>
                                    <input max="9999"  autocomplete="off"  type="number" id="price4" name="price4" min="0"  step="any" class="inp-cls" placeholder="Add amount.. Max 9999">
                                </div>
                            </div>
                            <div class="s-row">
                                <div class="s-col">
                                    <!--<label for="p-image" class="s-file-label purple">Upload Image</label>-->
                                    <input name="image" accept="image/*" type="file" id="p-image" class="hidden">
                                </div>
                                <div class="">
                                    <input type="button" id="saveform" value="Submit" class="s-file-label" style="width: 175px;border-radius: 7px;font-weight: normal;background: #d5ad30;margin: 10px 0;color: #000;">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <a href="#" class="btn-close"></a>
                </div>
            </div>
        </div>
    </div>
    <div id="share-post<?= $budz->id ?>" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="reporting-form">
                    <h2>Select an option</h2>
                    <div class="custom-shares">
                        <?php
                        $url_to_share = urlencode(asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id));
                        echo Share::page($url_to_share, $budz->title, ['class' => 'budz_product_class', 'id' => $budz->id])
                                ->facebook($budz->description)
                                ->twitter($budz->description)
                                ->googlePlus($budz->description);
                        ?>
                        <?php if (Auth::user()) { ?>
                        <!--<div class="budz_product_class in_app_button" onclick="shareInapp('<?= asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id) ?>', '<?php echo trim(revertTagSpace($budz->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>-->
<?php } ?>                </div>
                    <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <script>
    //        for add case
        $("#saveform").click(function () {
            event.preventDefault();
            $('#file').val('');
            $("#attachments").val(JSON.stringify(attachments));
            $('#product-form').submit();
        });
    //        for edit case
        $(".edit-product-submit-btn").click(function () {
            var productId = $(this).attr('product-id');
            $('#file' + productId).val('');
            $("#attachments" + productId).val(JSON.stringify(window['attachments' + productId]));
            $('#product-form' + productId).submit();
        });

        //Edit product case
        $('.file').on('change', function () {

            var productId = $(this).attr('product-id');
            var fileInput = document.getElementById('file' + productId);
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type = fileInput.files[0].type;
            imagesPreviewEdit(this, productId);
        });

        function imagesPreviewEdit(input, productId) {

            $('#floading' + productId).show();
            $('#saveform' + productId).prop('disabled', true);
            if (input.files) {
                for (var x = 0; x < input.files.length; x++) {
                    var filePath = input.value;
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif )$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        $('#floading').hide();
                        $('#showError').html('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');
                        $('#showError').fadeIn();
                        setTimeout(function () {
                            $('#showError').fadeOut();
                        }, 5000);

                        $('#file').val('');

                        return false;
                    }
                }
                if (parseInt(input.files.length) > 5 - window['attachment_counter' + productId]) {
                    $('#floading').hide();
                    $('#showError').html('You can only upload maximum 5 files');
                    $('#showError').fadeIn();
                    setTimeout(function () {
                        $('#showError').fadeOut();
                    }, 5000);
    //                alert('You can only upload maximum 5 files');
                    $("#floading" + productId).hide();
                    $('#saveform' + productId).prop('disabled', false);
                    $('#file' + productId).val('');

    //                        $('#imagePreview').html('');
                    return false;
                }

                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var data = new FormData();
                    data.append('file', input.files[i]);
                    window['attachment_counter' + productId]++;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_product_attachment'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (successdata) {

                            $('#file').val('');
                            var results = JSON.parse(successdata);
                            var path = "'" + results.delete_path + "'";
                            if (results.type == 'image') {
//                                $('#imagePreview' + productId).append('<li id="' + results.file_path + '"><img src="' + results.file_path + '"><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');
                                $('#imagePreview' + productId).append('<li id="' + results.file_path + '"><figure class="attache-back-image" style="background-image:url(' + results.file_path + ')"></figure><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');
                                window['attachments' + productId].push({"file_path": results.file_path, "delete_path": results.delete_path, "path": results.path, "poster": '', "type": results.type});
                                
                            }
                            $('#saveform' + productId).prop('disabled', false);
                            $('#floading' + productId).hide();
                        }
                    });
                }
            }

        }

        function removeAttachmentEdit(file, productId) {
            $.each(window['attachments' + productId], function (i) {
                if (window['attachments' + productId][i].delete_path === file) {
                    $.ajax({
                        url: "<?php echo asset('remove-product-attachment') ?>",
                        type: "POST",
                        data: {"file_path": file, "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                            }
                            window['attachments' + productId].splice(i, 1);
                            window['attachment_counter' + productId]--;
                        }
                    });
                    return false;
                }
            });
        }

        //Add product case
        $('#file').on('change', function () {
            var fileInput = document.getElementById('file');
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type = fileInput.files[0].type;
            imagesPreview(this);
        });
        var attachments = [];
        var attachment_counter = 0;

        function imagesPreview(input) {
    //                var attachments = [];
            $('#floading').show();
            $('#saveform').prop('disabled', true);
            if (input.files) {
                for (var x = 0; x < input.files.length; x++) {
                    var filePath = input.value;
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif )$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        $('#floading').hide();
                        $('#showError').html('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');
                        $('#showError').fadeIn();
                        setTimeout(function () {
                            $('#showError').fadeOut();
                        }, 5000);
                        $('#file').val('');

    //                            $('#imagePreview').html('');
                        return false;
                    }
                }

                if (parseInt(input.files.length) > 5 - attachment_counter) {
                    $('#floading').hide();
                    $('#showError').html('You can only upload maximum 5 files');
                    $('#showError').fadeIn();
                    setTimeout(function () {
                        $('#showError').fadeOut();
                    }, 5000);
    //                alert('You can only upload maximum 5 files');
                    $("#floading").hide();
                    $('#saveform').prop('disabled', false);
                    $('#file').val('');
    //                        $('#imagePreview').html('');
                    return false;
                }

                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var data = new FormData();
                    data.append('file', input.files[i]);
                    attachment_counter++;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_product_attachment'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (successdata) {
                            $('#file').val('');
                            var results = JSON.parse(successdata);
                            var path = "'" + results.delete_path + "'";
                            if (results.type == 'image') {
//                                $('ul.uploaded-files').append('<li id="' + results.file_path + '"><img src="' + results.file_path + '"><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');
                                $('ul.uploaded-files').append('<li id="' + results.file_path + '"><figure class="attache-back-image" style="background-image:url(' + results.file_path + ')"></figure><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');
                                attachments.push({"file_path": results.file_path, "delete_path": results.delete_path, "path": results.path, "poster": '', "type": results.type});
                            }
                            $('#saveform').prop('disabled', false);
                            $('#floading').hide();
                        }
                    });
                }
            }

        }

        function removeAttachment(file) {
            $.each(attachments, function (i) {
                if (attachments[i].delete_path === file) {
                    $.ajax({
                        url: "<?php echo asset('remove-product-attachment') ?>",
                        type: "POST",
                        data: {"file_path": file, "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                            }
                            attachments.splice(i, 1);
                            attachment_counter--;
                        }
                    });
                    return false;
                }
            });
        }

        $(document).on("click", "#imagePreview li", function () {
            var curr_img_src = $(this).find('img').attr('src');
            $('#image_popup').addClass('active');
            $('#image_popup').find('img').attr('src', curr_img_src);
        });

        $('.budz_product_class').unbind().click(function () {
            count = 0;

            if (count === 0) {
                count = 1;
                id = this.id;
                $.ajax({
                    url: "<?php echo asset('add_question_share_points') ?>",
                    type: "GET",
                    data: {
                        "id": id, "type": "Budz"
                    },
                    success: function (data) {
                        count = 0;
                    }
                });
            }
        });
                    </script></div>