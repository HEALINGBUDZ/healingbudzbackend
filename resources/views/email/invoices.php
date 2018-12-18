<!DOCTYPE html>
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Reciept of Billing</title>
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
                                Budz Adz Receipt of  billing
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="color: #999;font-size:20px;font-weight: 500; font-family: 'Lato';line-height: 1.6">
                                Hello <?= $to_name; ?>, <br>
                                please find the latest ranking analysis enclosed for your monitored search terms. The changes in rankings reflect the previous week from Monday to Monday of the current week. To find all keyword's stats login to Healing Budz.
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #1f1f1f;border: 1px solid #666;border-radius: 3px;border-collapse: collapse;">
                                    <tr style="background: #921e8e;color: #fff">
                                        <th align="left" valign="center" style="color: #fff;font-family: 'Lato';font-size: 14px;"> 
                                            DATE
                                        </th>
                                        <th align="left" valign="center" style="color: #fff;font-family: 'Lato';font-size: 14px;"> 
                                            BUDZ ADZ NAME
                                        </th>
                                        <th align="center" valign="center" style="color: #fff;font-family: 'Lato';font-size: 14px;"> 
                                            PRICE
                                        </th>
                                    </tr>
                                    <?php foreach($invoices as $invoice) { ?>
                                        <tr style="border-bottom: 1px solid #666;border-collapse: separate">   
                                            <td align="left" valign="center" style="color: #666;font-size:15px;font-weight: 500; font-family: 'Lato'; padding: 10px 20px;">
                                                <?= date("d-m-Y", $invoice->date); ?>
                                            </td>
                                            <td align="left" valign="center" style="color: #fff;font-size:15px;font-weight: 500; font-family: 'Lato'; padding: 10px 20px;">
                                                <?php if($budz_map_name){ echo $budz_map_name; } else {     echo 'pending detail'; } ?>
                                            </td>
                                            <td align="center" valign="center" style="color: #7cc244;font-size:15px;font-weight: 500; font-family: 'Lato'; padding: 10px 20px;">
                                                $ <?= number_format((int)$invoice->total/100,2); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                               </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="padding:0;">
                                <table border="0" cellpadding="10" cellspacing="0" width="100%" height="270" id="emailContainer" style="background:  url(https://image.ibb.co/dZhs4S/63_CFB7_A48_DC4_ED7_B1_FBDF07356638878_F023_D5_A33844_B8_DAFA_pimgpsh_fullsize_distr.png);background-repeat:no-repeat;background-position:top center;background-size:cover;border: 1px solid #666;padding: 19px;">
                                    <tr>
                                        <td align="center" width="100%" colspan="2" style="font-size: 35px;color: #fff;font-family: 'Lato';">Get full report on your device...</td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="2" valign="top" style="color: #fff;font-family: 'Lato';font-size:18px;">Download Ios & Android HB app today!</td>
                                    </tr>
                                     <tr>
                                        <td align="center" valign="top"  ><a href="#"><img src="https://image.ibb.co/jzxZjS/app_store.png" width="220px" alt="app_store" border="0"></a></td>
                                        <td align="center" valign="top" >
                                            <a href="#"><img src="https://image.ibb.co/eWaFr7/playstore.png" width="220px"></a><!--<a href="#" style="width: 240px;display: block;background-color: #fff;padding: 15px 19px 23px;border-radius: 23px;text-decoration: none;">
                               <img style="float:left;clear:both;" width="80px" class="pull-left" src="http://www.userlogos.org/files/logos/jumpordie/google_play_04.png"><div style="margin-top:6px;"><small style="font-size: 18px;color:#666;">Available on the</small><br><strong style="font-size: 25px;color: #000;
line-height: 25px;">Playstore</strong></div></a>--></td>

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
                            <td align="center" valign="top" style="color: #ccc;font-size:13px;font-family: 'Lato';padding-top: 18px;">
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
                                            <a href="#" style="color: #ccc;font-size:13px;font-family: 'Lato';text-decoration: none;">Copyright Healing Budz,LLC 2018</a>  
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