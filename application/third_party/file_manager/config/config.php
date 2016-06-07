<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 * 
 * PHP version 5
 * 
 * LICENSE: 
 * 
 * @category   
 * @package    
 * @author     Cosmo Mathieu cosmo@cimwebdesigns.com
 * @author     
 * @copyright  CIM Web Designs (c) 2011 http://www.cimwebdesigns.com/
 * @license    
 * @link       
 * @see        
 * @since      
 * @deprecated 
 * @date       
 * @version    
 * @modified   
 */ 
session_start();
mb_internal_encoding('UTF-8');
define('WEBSITE_ABS_PATH' , realpath(__DIR__ . '/../../../') . '/');

$app_base_path = str_replace( '/application', '', 
	str_replace("\\", "/", WEBSITE_ABS_PATH)
);

// include_once $app_base_path . '/index.php';

//------------------------------------------------------------------------------
// DON'T COPY THIS VARIABLES IN FOLDERS config.php FILES
//------------------------------------------------------------------------------

//**********************
//Path configuration
//**********************
// In this configuration the folder tree is
// root
//    |- source <- upload folder
//    |- thumbs <- thumbnail folder [must have write permission (755)]
//    |- filemanager
//    |- js
//    |   |- tinymce
//    |   |   |- plugins
//    |   |   |   |- responsivefilemanager
//    |   |   |   |   |- plugin.min.js

$base_url		= $app_base_path;  // base url (only domain) of site (without final /). If you prefer relative urls leave empty
$upload_dir 	= '/assets/cms/uploads/images/'; // path from base_url to base of upload folder (with start and final /)
$current_path 	= '../../../assets/cms/uploads/images/'; // relative path from filemanager folder to upload folder (with final /)
//thumbs folder can't be put inside upload folder
$thumbs_base_path = '../../../assets/cms/uploads/.thumbs/images/'; // relative path from filemanager folder to thumbs folder (with final /)


//------------------------------------------------------------------------------
// YOU CAN COPY AND CHANGE THESE VARIABLES IN FOLDERS config.php FILES
//------------------------------------------------------------------------------

$MaxSizeUpload	= 100; //Mb

$default_language 	= "en_EN"; //default language file name
$icon_theme 		= "ico"; //ico or ico_dark you can customize just putting a folder inside filemanager/img
$show_folder_size 	= true; //Show or not show folder size in list view feature in filemanager (is possible, if there is a large folder, to greatly increase the calculations)
$show_sorting_bar 	= true; //Show or not show sorting feature in filemanager
$loading_bar	  	= true; //Show or not show loading bar

//*******************************************
//Images limit and resizing configuration
//*******************************************

/**
 * Long description of the function 
 * set maximum pixel width and/or maximum pixel height for all images
 * If you set a maximum width or height, oversized images are converted 
 * to those limits. Images smaller than the limit(s) are unaffected.
 * If you don't need a limit set both to 0
 * 
 * @param      string $image_max_width
 * @param      string $image_max_height
 * @return     $param;
 */ 
$image_max_width	= 0;
$image_max_height	= 0;

/**
 * Automatic resizing 
 * 
 * If you set $image_resizing to true the script converts all uploaded 
 * images exactly to image_resizing_width x image_resizing_height dimension.
 * If you set width or height to 0 the script automatically calculates 
 * the other dimension.
 * Is possible that if you upload very big images the script not work 
 * to overcome this increase the php configuration of memory and time limit.
 *
 * @param      bool $image_resizing       
 * @param      bool $image_resizing_width 
 * @param      bool $image_resizing_height
 */ 
$image_resizing         = false;
$image_resizing_width   = 0;
$image_resizing_height  = 0;

//******************
// Default layout setting
//
// 0 => boxes
// 1 => detailed list (1 column)
// 2 => columns list (multiple columns depending on the width of the page)
// YOU CAN ALSO PASS THIS PARAMETERS USING SESSION VAR => $_SESSION["VIEW"]=
//
//******************
$default_view   = 0;

//set if the filename is truncated when overflow first row 
$ellipsis_title_after_first_row=true;

//*************************
//Permissions configuration
//******************
$delete_files       = true;
$create_folders     = true;
$delete_folders     = true;
$upload_files       = true;
$rename_files       = true;
$rename_folders     = true;
$duplicate_files    = true;

//**********************
//Allowed extensions (lowercase insert)
//**********************
$ext_img    = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg'); //Images

/**
 * Allowed Files
 */ 
$ext_file   = array(
    'doc', 'docx','rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv',
    'html','xhtml','psd','sql','log','fla','xml','ade','adp',
    'mdb','accdb','ppt','pptx','odt','ots','ott','odb','odg',
    'otp','otg','odf','ods','odp','css','ai'
); 

$ext_video  = array('mov', 'mpeg', 'mp4', 'avi', 'mpg','wma',"flv","webm"); //Video 
$ext_music  = array('mp3', 'm4a', 'ac3', 'aiff', 'mid','ogg','wav'); //Audio
$ext_misc   = array('zip', 'rar','gz','tar','iso','dmg'); //Archives

// Merger all of our allowed extensions into one single array
$ext        = array_merge($ext_img, $ext_file, $ext_misc, $ext_video,$ext_music); 


/******************
 * AVIARY config
*******************/
$aviary_active      = true;
$aviary_key         = "dvh8qudbp6yx2bnp";
$aviary_secret      = "m6xaym5q42rpw433";
$aviary_version     = 3;
$aviary_language    = 'en';

/**
 * FILE SORTER SETTINGS
 *
 * The filter and sorter are managed through both javascript and php 
 * scripts because if you have a lot of file in a folder the javascript 
 * script can't sort all or filter all, so the filemanager switch to php 
 * script. The plugin automatic switch javascript to php when the 
 * current folder exceeds the below limit of files number
 *
 * @param      string $file_number_limit_js
 */ 
$file_number_limit_js = 500;

//**********************
// Hidden files and folders
//**********************
// set the names of any folders you want hidden (eg "hidden_folder1", "hidden_folder2" ) Remember all folders with these names will be hidden (you can set any exceptions in config.php files on folders)
$hidden_folders = array();
// set the names of any files you want hidden. Remember these names will be hidden in all folders (eg "this_document.pdf", "that_image.jpg" )
$hidden_files = array('config.php');

/**
 * JAVA upload 
 *
 * @param      bool $java_upload=true
 * @param      var $JAVAMaxSizeUpload Size in Gigabyte
 */ 
$java_upload        = true;
$JAVAMaxSizeUpload  = 200; //Gb

/**
 *---------------------------------------------------------------
 * Thumbnail creation for external use | Fixed path
 *---------------------------------------------------------------
 *
 * New image resized creation with fixed path from filemanager 
 * folder after uploading (thumbnails in fixed mode). If you want 
 * to create images resized out of upload folder for use with 
 * external script you can choose this method. You can also create 
 * more than one image at a time just simply add a value in the array. 
 * Remember than the image creation respect the folder hierarchy so 
 * if you are inside source/test/test1/ the new image will create 
 * at path_from_filemanager/test/test1/
 * PS if there isn't write permission in your destination folder you must set it.
 */
 
/**
 * Activate or not the creation of one or more image resized with 
 * fixed path from filemanager folder
 *
 * @param      bool $fixed_image_creation True or False
 */  
$fixed_image_creation                   = false;

/**
 * Fixed path of the image folder from the current position on upload folder
 *
 * @param      array $fixed_path_from_filemanager array of directories
 */ 
$fixed_path_from_filemanager            = array('../test/','../test1/');

$fixed_image_creation_name_to_prepend   = array('','test_'); //name to prepend on filename
$fixed_image_creation_to_append         = array('_test',''); //name to appendon filename
$fixed_image_creation_width             = array(300,400); //width of image (you can leave empty if you set height)
$fixed_image_creation_height            = array(200,''); //height of image (you can leave empty if you set width)

/**
 *---------------------------------------------------------------
 * Thumbnail creation for external use | Relative path
 *---------------------------------------------------------------
 * 
 * New image resized creation with relative path inside to upload 
 * folder after uploading (thumbnails in relative mode). With 
 * Responsive filemanager you can create automatically resized 
 * image inside the upload folder, also more than one at a time 
 * just simply add a value in the array. The image creation path 
 * is always relative so if i'm inside source/test/test1 and I 
 * upload an image, the path start from here.
 */
$relative_image_creation                = false; //activate or not the creation of one or more image resized with relative path from upload folder
$relative_path_from_current_pos         = array('thumb/','thumb/'); //relative path of the image folder from the current position on upload folder
$relative_image_creation_name_to_prepend= array('','test_'); //name to prepend on filename
$relative_image_creation_name_to_append = array('_test',''); //name to append on filename
$relative_image_creation_width          = array(300,400); //width of image (you can leave empty if you set height)
$relative_image_creation_height         = array(200,''); //height of image (you can leave empty if you set width)

