<!-- approved -->
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no"> <!-- Tell iOS not to automatically link certain text strings. -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font.
    <!--[if mso]>  -->
    <style>
        * {
            font-family: 'Roboto', sans-serif !important;
        }


        .text--black {
            font-size: 18px;
            line-height: 25px;
            padding: 0;
            margin: 0;
            padding: 5px 0px;
        }


        .text--gray {
            color: #656565;
            font-size: 18px;
            line-height: 25px;
            padding: 0;
            margin: 0;
            padding: 5px 0px;
        }


        .btn--red {
            background-color: #D63447;
            color: #fff;
            font-size: 18px;
            line-height: 25px;
            font-weight: 700;

            -webkit-box-shadow: 0px 12px 24px 0px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0px 12px 24px 0px rgba(0, 0, 0, 0.15);
            box-shadow: 0px 12px 24px 0px rgba(0, 0, 0, 0.15);

            padding: 15px 50px;
            margin: 10px;
            border-radius: 200px;
        }


        .btn--green {
            background-color: #3EC061;
            color: #fff;
            font-size: 18px;
            line-height: 25px;
            font-weight: 700;

            -webkit-box-shadow: 0px 12px 24px 0px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0px 12px 24px 0px rgba(0, 0, 0, 0.15);
            box-shadow: 0px 12px 24px 0px rgba(0, 0, 0, 0.15);

            padding: 15px 50px;
            margin: 10px;
            border-radius: 200px;
        }



        ol li {
            padding-bottom: 10px;
            font-size: 14px;
        }

        ol.reminders li {
            font-size: 12px;
            line-height: 16px;
            padding-left: 0;
        }

        .tr__section {
            padding: 20px 25px;
            background-color: #fff;
        }

        .td__block {
            padding: 30px 25px 20px 25px;
        }

        hr.divider {
            background-color: #fff;
            width: 95%;
            color: rgba(0, 0, 0, 0.3);
            border-style: dashed;
            border-width: 0.025rem;
            margin: 30px 0;
        }


        ul.footer {
            list-style: none;
            padding-left: 0;
            color: #fff;
            font-size: 12px;
        }

        ul.footer li {
            padding-bottom: 5px;
        }


        .row__desktop_col_mobile {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-flow: row wrap;
            flex-wrap: wrap;
            max-width: 650px;
        }
    </style>
    <!-- <![endif] -->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: forces Samsung Android mail clients to use the entire viewport */
        #MessageViewBody,
        #MessageWebViewDiv {
            width: 100% !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            /* table-layout: fixed !important; */
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        a[x-apple-data-detectors],
        /* iOS */
        .unstyle-auto-detected-links a,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img+div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }

            .two__column_responsive {
                width: 100%;
            }

            .two__column_70_responsive {
                width: 100%;
            }

            .two__column_30_responsive {
                width: 100%;
            }

            .three__column_responsive {
                width: 100%;
            }

            .four__column_responsive {
                width: 100%;
            }

        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }

            .two__column_responsive {
                width: 100%;
            }

            .two__column_70_responsive {
                width: 100%;
            }

            .two__column_30_responsive {
                width: 100%;
            }

            .three__column_responsive {
                width: 100%;
            }

            .four__column_responsive {
                width: 100%;
            }

            .left__align_mobile {
                text-align: left;
            }

        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }


            .two__column_responsive {
                width: 100%;
            }

            .two__column_70_responsive {
                width: 100%;
            }

            .two__column_30_responsive {
                width: 100%;
            }

            .three__column_responsive {
                width: 100%;
            }

            .four__column_responsive {
                width: 100%;
            }

            .left__align_mobile {
                text-align: right;
            }

        }


        @media only screen and (min-device-width: 768px) {

            .two__column_responsive {
                width: 50%;
                min-height: 60px;
            }

            .two__column_70_responsive {
                width: 70%;
            }

            .two__column_30_responsive {
                width: 30%;
            }

            .three__column_responsive {
                width: 33.33%;
                min-height: auto;
                vertical-align: top;
            }

            .four__column_responsive {
                width: 25%;
                min-height: auto;
                vertical-align: top;
            }
        }

        .text-right{
            text-align: right !important;
        }

        .text-left{
            text-align: left !important;
        }
    </style>

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }

        .button-td-primary:hover,
        .button-a-primary:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            /* What it does: Adjust typography on small screens to improve readability */
            /* .email-container p {
                font-size: 17px !important;
            } */

        }
    </style>
    <!-- Progressive Enhancements : END -->

</head>
<!--
    The email background color (#222222) is defined in three places:
    1. body tag: for most email clients
    2. center tag: for Gmail and Inbox mobile apps and web versions of Gmail, GSuite, Inbox, Yahoo, AOL, Libero, Comcast, freenet, Mail.ru, Orange.fr
    3. mso conditional: For Windows 10 Mail
-->

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #fff;">
    <center style="width: 100%; background-color: #D3D3D3;">
        <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #222222;">
    <tr>
    <td>
    <![endif]-->

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            Hello {{ $order->user->name }}, This is your order confimation.
        </div>
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div><div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div><div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div><div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div><div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don’t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <!-- Preview Text Spacing Hack : END -->

        <!--
            Set the email width. Defined in two places:
            1. max-width for all clients except Desktop Windows Outlook, al lowing the email to squish on narrow but never go wider than 600px.
            2. MSO tags for Desktop Windows Outlook enforce a 600px width.
        -->
        <div style="max-width: 680px; min-height: 700px; margin: 0 auto; padding-top: 20px; padding-bottom: 20px;" class="email-container">
            <!--[if mso]>
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600">
            <tr>
            <td>
            <![endif]-->

            <!-- Email Body : BEGIN -->
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto; padding: 40px;">
                <!-- Email Header : BEGIN -->
                <!-- <tr>
                    <td style="padding: 20px 0; text-align: center">
                        <img src="https://via.placeholder.com/200x50" width="200" height="50" alt="alt_text" border="0" style="height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                    </td>
                </tr> -->
                <!-- Email Header : END -->


                <!-- Logo, Flush : BEGIN -->
                <tr>
                    <td style="background-color: #ffffff; padding: 20px 40px; padding-bottom: 0;">
                      <a href="{{url('/')}}">
                        <img src="{{$message->embed(asset('assets/images/iwellness_logo_text.png'))}}" width="150" height="" alt="alt_text" border="0" style="object-fit: contain;" class="g-img">
                      </a>
                    </td>
                </tr>
                <!-- Logo, Flush : END -->



                <!-- Hero Image, Flush : BEGIN -->
                <tr>
                    <td style="background-color: #ffffff;">
                        <img src="{{$message->embed(asset('assets/images/order-confirmed.png'))}}" width="700" height="" alt="alt_text" border="0" style="width: 100%; height: auto; display: block; object-fit: contain;" class="g-img">
                    </td>
                </tr>
                <!-- Hero Image, Flush : END -->


                <!-- Message : BEGIN -->
                <tr>
                    <td align="left" valign="top" style="font-size:0; background-color: #ffffff; padding: 10px 60px;" class="td__block row__desktop_col_mobile">
                        <!--[if mso]>
                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="660">
                        <tr>
                        <td valign="top" width="220">
                        <![endif]-->
                        <div style="display:inline-block;" class="">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px;text-align: left;">
                                            <tr>
                                                <td valign="top" style="">
                                                    <p class="text--black">
                                                       Hi {{$order->user->name}},
                                                    </p>
                                                    <br/>
                                                    <p class="text--black">
                                                        We received your order with transaction no: <strong>{{$order->order_id}}</strong> in total amount of <strong>₱{{number_format(($order->total + $order->shipping_fee + $order->payment), 2, '.', ',')}}</strong>.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <!-- Message : END -->

                <tr>
                    <td align="left" valign="top" style="font-size:0; background-color: #ffffff; padding: 10px 60px;">
                        <div style="display:inline-block;" class="">
                            <h3>Order Details</h3>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">Item</th>
                                    <th class="text-left">Quantity</th>
                                    <th class="text-right">Unit Cost</th>
                                    <th class="text-right">Total</th>
                                </tr>

                                @foreach($order->cart as $key => $item)
                                    <tr>
                                        <td class="text-left">
                                        {{$key + 1}}
                                        </td>
                                        <td class="text-left">
                                        {{$item->details->name}}
                                        </td>
                                        <td class="text-left">
                                        {{$item->quantity}}
                                        </td>
                                        <td class="text-right">
                                        ₱ {{$item->price}}
                                        </td>
                                        <td class="text-right">
                                        ₱ {{$item->price * $item->quantity}}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </td>
                </tr>


                <!-- CLOSING MESSAGE : BEGIN -->
                <tr>
                    <td align="left" valign="top" style="font-size:0; padding: 20px 60px; background-color: #ffffff;">
                        <p class="text--black">
                            Regards,
                        </p>
                        <p class="text--black" style="font-weight: 600;">
                            {{ env('APP_MAIL_NAME', 'IWellness')}}
                        </p>
                    </td>
                </tr>
                <!-- CLOSING MESSAGE : END -->

                <!-- Credits : BEGIN -->
                <tr>
                    <td align="center" valign="top" style="font-size:0; padding: 10px; background-color: #fff;">
                        <div style="display:inline-block; margin: 0 -1px;" class="">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td valign="top" style="padding: 10px 10px; font-family: 'Inter-Semibold', sans-serif;">
                                        <h1 style="margin-bottom: 10px; font-size: 13px; line-height: 30px; color: #000; font-weight: 300;">
                                          © {{ date('Y') }} <a href="{{url('/')}}">IWellness</a> All Rights Reserved.
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <!-- Credits : END -->
            </table>
        </div>
    </center>
</body>

</html>

<!-- end -->
