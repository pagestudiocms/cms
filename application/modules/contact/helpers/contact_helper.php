<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entry URL
 *
 * Returns the URL of a CMS page
 *
 * @param       string $message
 * @return      string
 */
if ( ! function_exists('html_template'))
{
    function html_template($subject, $message) {
        $template = '
            <!doctype html>
            <html>
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.5"/>
                <title>'.$subject.'</title>
                
                <style type="text/css">
                    /*////// RESET STYLES //////*/
                    body, #bodyTable, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;}
                    table{border-collapse:collapse;}
                    img, a img{border:0; outline:none; text-decoration:none;}
                    h1, h2, h3, h4, h5, h6{margin:0; padding:0;}
                    p{margin: 1em 0;}
                    /*////// CLIENT-SPECIFIC STYLES //////*/
                    .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
                    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
                    table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
                    #outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
                    img{-ms-interpolation-mode: bicubic;} /* Force IE to smoothly render resized images. */
                    body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
                    /*////// MOBILE STYLES //////*/
                    @media only screen and (max-width: 480px){			
                        /*////// CLIENT-SPECIFIC STYLES //////*/
                        body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */
                        /*////// GENERAL STYLES //////*/
                        table[id="emailPreheader"], table[id="emailHeader"], table[id="emailBody"]{width:100% !important;}
                        table[class="flexibleContainer"], table[class="flexibleFooterContainer"]{width:100% !important;}
                        img[class="flexibleImage"]{width:100% !important;}
                        table[class="flexibleButton"]{width:100% !important;}
                        td[class="clearPadding"]{padding:0 !important;}
                        td[class="clearPaddingT"]{padding-top:0 !important;}
                        td[class="clearPaddingB"]{padding-bottom:0 !important;}
                        td[class="clearPaddingRL"]{padding-right:0 !important; padding-left:0 !important;}
                        td[class="paddingR20"]{padding-right:20px !important;}
                        td[class="paddingRL15"]{padding-right:15px !important; padding-left:15px !important;}
                        td[class="paddingB10"]{padding-bottom:10px !important;}
                        span[class="blockIt"]{display:block !important;}
                        span[class="mobileHide"]{display:none !important;}
                        h1{font-size:28px !important;}
                        h2{font-size:24px !important;}
                        td[class="logoContainer"]{text-align:center !important; width:100% !important;}
                        td[class="socialBlockContainer"]{text-align:center !important;}
                        td[class="preheaderContent"]{line-height:150% !important; text-align:left !important;}
                        td[class="emailTitleContent"], td[class="emailDateContent"]{text-align:center !important;}
                        td[class="rightColumnContent"], td[class="leftColumnContent"]{font-size:17px !important;padding-bottom:30px !important;}
                        td[class="leftColumnContent"]{}
                        td[class="utilityLinks"] a{display:block; margin-bottom:20px;}
                    }
                </style>
                 <!-- OUTLOOK-SPECIFIC STYLES // -->
                 <!--[if gte mso 9]>
                 <style type="text/css">
                    .quadLinkContainer{width:100%;}
                    .flexibleFooterContainer{width:640px;}
                 .clearPaddingB{padding-bottom:0 !important;}
                 </style>
                 <![endif]-->
                 <!-- // OUTLOOK-SPECIFIC STYLES -->
            </head>
            <body style="background-color:#F8F8F8; height:100% !important; margin:0; padding:0; width:100% !important;">
            <div id="emailContents">
            <center>
                <table id="bodyTable" style="background-color:#F8F8F8; border-collapse:collapse; height:100% !important; margin:0; padding:0; width:100% !important;" height="100%" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                <td id="bodyCell" style="height:100% !important; margin:0; padding-top:0; padding-right:0; padding-bottom:100px; padding-left:0; width:100% !important;" align="center" valign="top">
                <table style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
             <tr>
                <td align="center" valign="top">
             <table id="emailHeader" style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody>
                    <tr>
                        <td><br><br></td>
                    </tr>
                </tbody>
             </table>
             </td>
             </tr>
             <tr>
                <td align="center" valign="top">
                <table id="emailBody" style="background-color:#FFFFFF; border:1px solid #E5E5E5; border-bottom:3px solid #E5E5E5; border-collapse:separate; border-radius:4px;" border="0" cellpadding="0" cellspacing="0" width="640">
                    <!-- BEGIN CONTENT BLOCKS // -->
                    <tbody>
                        <tr>
                            <td style="padding-top:30px;" align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style="color:#666666; font-family: Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:125%; padding-right:10px; padding-left:15px; text-align:right; text-transform:uppercase;" class="" align="right" valign="middle">
                                                A Message From Your Website
                                            </td>
                                            <!--
                                             <td class="" align="center" valign="middle" width="24">
                                                <img src="https://gallery.mailchimp.com/27aac8a65e64c994c4416d6b8/images/icon_diamond.png" style="border:0; outline:none; text-decoration:none;" height="19" width="24">
                                             </td>
                                             <td style="color:#666666; font-family: Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:125%; padding-right:15px; padding-left:10px; text-align:left; text-transform:uppercase;" class="" align="left" valign="middle">
                                                Release
                                             </td>
                                             -->
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- // FEATURE RELEASE HEADER -->
                        <!-- LEAD IMAGE // -->
                         <tr>
                            <td class="clearPaddingRL" style="padding-top:0px; padding-right:15px; padding-bottom:0px; padding-left:15px;" align="center" valign="top">
                                <table style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="padding-top:15px; padding-right:0; padding-bottom:0px; padding-left:0;">
                                                <table style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td align="center" valign="top">
                                                                <table style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="color: rgb(102, 102, 102); font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 150%; padding: 0px; text-align: left;" class="" pardot-data="">
                                                                                <!-- 
                                                                                <h1 style="color: rgb(120, 163, 0); font-family: Helvetica, Arial, sans-serif; font-size: 42px; font-weight: 100; line-height: 125%; margin: 0px; padding: 0px; text-align: center;">
                                                                                    <a href="http://go.pardot.com/e/20822/ember2014-utm-content-headline/lstqb/123037095" style="text-decoration:none;color:#78A300;">
                                                                                        <span style="font-size:18px;">Ten new apps to try before class</span></a>
                                                                                </h1>
                                                                                -->
                                                                                <h2 style="margin: 0px; padding: 10px; color: rgb(99, 99, 99); font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 100; line-height: 150%; text-align: left;">
                                                                                    <span style="font-size:14px;">'.$message.'</span>
                                                                                </h2>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                         </tr>
                         <!-- // LEAD IMAGE -->


                 <!-- // TWO-COLUMN CONTENT -->
                <!--Copy this row and place it within the emailBody <table> in the newsletter email. -->
                 <tr>
                    <td class="clearPaddingRL" style="padding-top:15px; padding-bottom:15px;" align="center" valign="top">
                    <table style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                    <td style="padding-top:15px; padding-bottom:15px;">
                    <table style="background-color:#FAFAFA; border-collapse:collapse; border-top:1px solid #EBEBEB; border-bottom:1px solid #EBEBEB;" border="0" cellpadding="0" cellspacing="0" width="100%">
                 <tbody><tr>
                    <td style="padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;" align="center" valign="top">
                    <table style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0">
                    <!-- TEXT //-->
                    <tbody>
                        <tr>
                    <td class="utilityContent" style="color: rgb(102, 102, 102); font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 150%; padding-left: 10px; text-align: left;" pardot-data="" align="left" valign="top">
                        This message was automatically generated.
                    </td>
                 </tr>
                 <!-- // TEXT -->
                 </tbody></table>
                 </td>
                 </tr>
                 </tbody></table>
                 </td>
                 </tr>
                 </tbody></table>
                 </td>
                 </tr>
                 <!-- // FEEDBACK LINK BLOCK -->
                 <!-- END CONTENT BLOCKS -->
                 </tbody></table>
                 </td>
                 </tr>
                    <tr>
                    <td align="center" valign="top">
                 <table id="emailFooter" style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
                 <tbody><tr>
                 <td align="center" valign="top">
                 <table class="flexibleFooterContainer" style="border-collapse:collapse;" border="0" cellpadding="0" cellspacing="0" width="640">
                 <tbody>
                 <tr>
                    <td style="padding-bottom:20px;" class="" align="center" valign="top">
                        <br />
                        <!--
                        <a href="http://go.pardot.com/e/20822/2014-09-23/lstr4/123037095" style="border:0; outline:none; text-decoration:none;" target="_blank">
                            <img src="#" style="border:0; outline:none; text-decoration:none;" height="25" width="100"></a>
                            -->
                    </td>
                 </tr>
                             <tr>
                                <td class="utilityLinks" style="border-top-width: 1px; border-top-style: solid; border-top-color: rgb(217, 217, 217); color: rgb(166, 166, 166); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 150%; padding-top: 20px; padding-bottom: 60px; text-align: center;" pardot-data="" align="center" valign="top"><span class="blockIt">
                                    Contact Support: <a href="mailto:support@cosmointeractive.co" style="color:#358FB2; text-decoration:underline;" target="_blank">support@cosmointeractive.co</a></span>
                                    <span class="mobileHide"></span>
                                </td>
                             </tr>
                 </tbody></table>
                 </td>
                 </tr>
                 </tbody></table>
                 </td>
                 </tr>
                 </tbody></table>
                 </td>
                 </tr>
                 </tbody></table>
                 </center>
                </div>
            </body>
            </html>
        ';
        
        return $template;
    }
}