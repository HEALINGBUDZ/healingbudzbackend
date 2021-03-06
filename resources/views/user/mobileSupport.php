                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,700i,900" rel="stylesheet">
        <style>
            *{
                box-sizing: border-box;   
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                -ms-box-sizing: border-box;
                -o-box-sizing: border-box;
            }
            body {
                margin: 0px;
                padding: 0px;
            }
            .AppStoreWebPage {
                background-image: url('userassets/images/bg-app-store-page.jpg');
                background-size: cover;
                width: 100%;
                height: 100%;
                position: fixed;
                top: 0px;
                left: 0px;
                font-family: 'Lato', sans-serif;
                text-align: center;
                z-index:9999999999;
            }
            .AppStoreWebPage .overlay {
                background-color: rgba(0,0,0,.6);
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                height: 100%;
                width: 100%;
            }
            .AppStoreWebPage .txt_wrap {
                padding: 20px;
                max-width: 767px;
                width: 100%;
                overflow: auto;
            }
            .AppStoreWebPage .icon-support {
                margin-bottom: 15px;
            }
            .AppStoreWebPage .icon-support img {
                max-width: 60px;
            }
            .AppStoreWebPage .txt_wrap h3 {
                font-weight: 900;
                color: #7cc245;
                font-size: 20px;
                margin: 0px 0px 10px 0px;
            }
            .AppStoreWebPage .txt_wrap p {
                color: #b9b9b9;
                line-height: 22px;
                font-size: 15px;
            }
            .appStoreBtnWrap {
                margin: 20px 0px;
            }
            .AppStoreBtn {
                font-weight: 700;
                background-color: #7cc245;
                color: #fff;
                padding: 10px 25px;
                border-radius: 36px;
                text-decoration: none;
                display: flex;
                max-width: 130px;
                align-items: center;
                margin: 0 auto;
            }
            .AppStoreBtn .iconStore {
                display: inline-block;
                width: 21px;
                height: 24px;
                background-size: contain;
                background-repeat: no-repeat;
                padding-right: 0px;
                margin-right: 11px;
            }
            .AppStoreBtn .iconStore.AppleStore {
                background-image: url('userassets/images/icon-appleStore.png');
            }
            .AppStoreBtn .iconStore.PlayStore {
                background-image: url('userassets/images/icon-playStore.png');
            }
            .AppStoreBtn:hover {
                background: #343434;
            }
            .AppStoreWebPage .logo {
                margin-top: 15px;
            }
            .AppStoreWebPage .logo img {
                width:100%;
                max-width: 250px;
            }

        </style>
    </head>
    <body>
        <div class="AppStoreWebPage">
            <div class="overlay">
                <div class="txt_wrap">
                    <div class="icon-support">
                        <img src="<?php echo asset('userassets/images/icon-sad.png')?>" alt=""/>
                    </div>                         
                    <h3>Install Application</h3>
                    <p>You may be able to install HealingBudz app in your mobile via store & Discover your local canna community. Be in the know about upcoming deals, promotions, fun industry events, and educational seminars in just a few taps.</p>
                    <div class="appStoreBtnWrap">
                        <?php 
                        if ($agent == 'iOS') { ?>
                        <a target="_blank" href="https://itunes.apple.com/us/app/healing-budz/id1438614769?mt=8" class="AppStoreBtn"> <span class="iconStore AppleStore"></span> Install</a>
                        <?php } else { ?>
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.healingbudz.android" class="AppStoreBtn"> <span class="iconStore PlayStore"></span> Install</a>
                        <?php } ?>
                    </div>
                    <div class="logo">
                        <img src="<?php echo asset('userassets/images/home-page-logo.png')?>" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>