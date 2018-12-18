<!DOCTYPE html>
<html>
    <head>
             <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Forget Password</title>
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
                            <td align="center" valign="top" style="color: #fff;font-size:35px;font-weight: 500; font-family: 'Lato';padding: 0 85px;">
                                Forgot your password? Let's get you a new one.
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="color: #fff;font-size:15px;font-family: 'Lato';line-height: 2.3;">
                                Hello <?php echo $name; ?>,<br>
                                You told us forgot your password. If you really did, click here to set new one:
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="color: #fff;font-size:15px;font-family: 'Lato';padding: 35px 0;">
                               <a href="<?php echo asset('changepassword?token='.$token) ?>" style="background: #7cc244;padding:14px 30px;color: #fff;text-decoration: none;border-radius: 5px;font-weight: bold;">SET A NEW PASSWORD</a>
                            </td>
                        </tr>
                          <tr>
                            <td align="left" valign="top" style="color: #838383;font-size:15px;font-family: 'Lato';line-height: 1.6;padding-right: 80px;">
                                If you did not mean to reset your password, then you can just ignore this email; your password will not change.
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
                                <table border="0" cellpadding="20" cellspacing="0" width="660" id="emailContainer" style="border: 1px solid #7cc244;border-radius: 5px;">
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