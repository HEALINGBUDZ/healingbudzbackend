<!DOCTYPE html>
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Redeem</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    </head>
    <body>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #1f1f1f">
                        <tr>
                            <td align="center" valign="top">
                                <a href="https://imgbb.com/"><img src="https://image.ibb.co/gdL7m7/logo.png" alt="logo" border="0"></a>
                            </td>
                        </tr>
                         <tr>
                            <td align="center" valign="top" style="color: #fff;font-size:40px;font-weight: 500; font-family: 'Lato';padding: 0 85px;">
                                Thanks for Redeem
                            </td>
                        </tr>
                         <tr>
                            <td align="left" valign="top" style="color: #999;font-size:20px;font-weight: 500; font-family: 'Lato';line-height: 1.6">
                                Hello <?php echo $user->first_name; ?>, <br>
                                We've received your order and are working on it now.
                                If you have any question, feel free to reach out to us <a href="mailto:contact@healingbudz.com" style="color:#7cc244;text-decoration:none;">contact@healingbudz.com</a>
                            </td>
                        </tr>
                         <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #1f1f1f;border: 1px solid #666;border-radius: 3px;">
                                    <tr style="background: #7cc244;color: #fff">
                                        <th align="left" valign="top" style="color: #fff;font-family: 'Lato';font-size: 18px;"> 
                                            SHIPPING ADDRESS
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr>   
                                        <td width="180" align="left" valign="top" style="color: #999;font-size:18px;font-weight: 500; font-family: 'Lato'; padding: 10px 20px 0px;">
                                            SHIP TO:
                                        </td>
                                            <td align="left" valign="top" style="color: #fff;font-size:18px;font-weight: 500; font-family: 'Lato'; padding: 10px 20px 10px;line-height:1.9">
                                            <?php echo $user->first_name; ?><br>
                                            <?php if($state){ 
                                                $user_state = $state->state;
                                            }else{
                                                $user_state = '';
                                            } ?>
                                            <?php echo $user->zip_code.', '.$user->city.', '.$user_state; ?>
                                        </td>
                                    </tr>
                               </table>
                            </td>
                         </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #1f1f1f;border: 1px solid #666;border-radius: 3px;">
                                    <tr style="background: #7cc244;color: #fff">
                                        <th align="left" valign="top" style="color: #fff;font-family: 'Lato';font-size: 18px;"> 
                                            REDEAM PRODUCT
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr>   
                                        <td width="180" align="left" valign="top" style="color: #999;font-size:18px;font-weight: 500; font-family: 'Lato'; padding: 15px 20px 10px;">
                                            <a href="https://imgbb.com/"><img src="<?php echo asset('public/images'.$product->attachment); ?>" alt="man" border="0"></a>
                                        </td>
                                            <td align="left" valign="top" style="color: #fff;font-size:20px;font-weight: 500; font-family: 'Lato'; padding: 10px 20px 10px;line-height:1.9">
                                            <?php echo $product->name; ?>
                                            <br><span style="color:#7cc244;font-size:12px;"><a href="https://ibb.co/d0CH4S"><img src="https://preview.ibb.co/mE2vr7/16_star_png_image.png" alt="16_star_png_image" border="0" width="15"></a> <?php echo $product->points; ?> points</span>
                                        </td>
                                    </tr>
                               </table>
                            </td>
                        </tr>
                        <tr>
                             <td align="center" valign="top" style="padding:38px 0 8px;">
                                 <table border="0" cellpadding="10" cellspacing="0" width="100%" height="270" id="emailContainer" style="background:  url(https://image.ibb.co/dZhs4S/63_CFB7_A48_DC4_ED7_B1_FBDF07356638878_F023_D5_A33844_B8_DAFA_pimgpsh_fullsize_distr.png);background-repeat:no-repeat;background-position:center;background-size:cover;border: 1px solid #666;padding: 19px;">
                                    <tr>
                                        <td align="center" width="100%" colspan="2" style="font-size: 35px;color: #fff;font-family: 'Lato';">Get full report on your device...</td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="2" valign="top" style="color: #fff;font-family: 'Lato';font-size:18px;">Download iOS & Android HB app today!</td>
                                    </tr>
                                    <tr>
                                       <td align="center" valign="top"  ><a href="#"><img src="https://image.ibb.co/jzxZjS/app_store.png" width="220px" alt="app_store" border="0"></a></td>
                                       <td align="center" valign="top" >
                                           <a href="#"><img src="https://image.ibb.co/eWaFr7/playstore.png" width="220px"></a></td>
                                   </tr>
                                 </table>
                             </td>
                        </tr>
<!--                        <tr>
                            <td align="center" valign="top" style="color: #057ec4;font-size:13px;font-family: 'Lato';padding-bottom: 0;padding-top: 50px;">
                                <a>Unsubscribe from notifications</a>
                            </td>
                          
                        </tr>-->
                        <tr>
                            <td align="center" valign="top" style="color: #ccc;font-size:13px;font-family: 'Lato';padding-top: 0">
                                Support: <a href="mailto:Support@healingbudz.com" style="color: #ccc;font-size:15px;font-family: 'Lato';text-decoration: none;">Support@healingbudz.com</a>
                            </td>
                          
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="color: #838383;font-size:13px;font-family: 'Lato';padding-top: 0">
                                <table border="0" cellpadding="20" cellspacing="0" width="680" id="emailContainer" style="border: 1px solid #7cc244;border-radius: 5px;">
                                    <tr>
                                        <td align="center" valign="top" style="color: #838383;font-size:13px;font-family: 'Lato';padding-bottom: 0;">
                                            <a href="<?php echo asset('signup-privacy-policy'); ?>" style="color: #ccc;font-size:13px;font-family: 'Lato';text-decoration: none;padding-bottom: 0;">Privacy Policy</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="color: #ccc;font-size:13px;font-family: 'Lato';padding-top: 0;padding-bottom: 10px;">
                                            <a href="<?php echo asset('signup-terms-conditions'); ?>" style="color: #ccc;font-size:13px;font-family: 'Lato';text-decoration: none;padding-top: 0">Terms & Conditions</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="color: #ccc;font-size:13px;font-family: 'Lato';padding-top:0;padding-bottom: 10px;">
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://image.ibb.co/jo9iR7/facebook_256.png" alt="facebook_256" border="0" width="20" style="background: #fff;padding: 3px;border-radius: 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://preview.ibb.co/eRZHm7/twitter_1.png" alt="twitter_1" border="0" width="20" style="background: #fff;padding: 3px;border-radius: 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://image.ibb.co/mqa1Dn/images_2.jpg" alt="twitter_1" border="0" width="26" style="border-radius: 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://image.ibb.co/do2ReS/109479.png" alt="twitter_1" border="0" width="20" style="background: #fff;padding: 3px;border-radius: 5px;">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="color: #ccc;font-size:13px;font-family: 'Lato';padding-top: 0;padding-bottom: 0;">
                                            <a href="#" style="color: #ccc;font-size:13px;font-family: 'Lato';text-decoration: none;">Copyright Healing Budz, LLC 2018</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="color: #ccc;font-size:13px;font-family: 'Lato';    padding-top: 5px;padding-bottom: 10px;">
                                            <a href="#" style="color: #555;font-size:13px;font-family: 'Lato';text-decoration: none;">Version 1.0.17</a>  
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>