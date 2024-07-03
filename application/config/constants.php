<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broNameconventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/**** USER DEFINED CONSTANTS **********/

define('ROLE_ADMIN',                            '1');
define('ROLE_MANAGER',                         	'2');
define('ROLE_EMPLOYEE',                         '3');

define('SEGMENT',								2);

/************************** EMAIL CONSTANTS *****************************/

define('EMAIL_FROM',                            'Your from email');		// e.g. email@example.com
define('EMAIL_BCC',                            	'Your bcc email');		// e.g. email@example.com
define('FROM_NAME',                             'CIAS Admin System');	// Your system name
define('EMAIL_PASS',                            'Your email password');	// Your email password
define('PROTOCOL',                             	'smtp');				// mail, sendmail, smtp
define('SMTP_HOST',                             'Your smtp host');		// your smtp host e.g. smtp.gmail.com
define('SMTP_PORT',                             '25');					// your smtp port e.g. 25, 587
define('SMTP_USER',                             'Your smtp user');		// your smtp user
define('SMTP_PASS',                             'Your smtp password');	// your smtp password
define('MAIL_PATH',                             '/usr/sbin/sendmail');



/* Application Tables*/

define('TBL_COMPANY','tbl_compnayinfo');
define('TBL_SUPPLIER','tbl_supplier');
define('TBL_RAWMATERIAL','tbl_rawmaterial');
define('TBL_VENDOR','tbl_vendor');
define('TBL_USP','tbl_usp');
define('TBL_FINISHED_GOODS','tbl_finished_goods');
define('TBL_PLATTING_MASTER','tbl_platting_master');
define('TBL_REJECTION_MASTER','tbl_rejection_master');
define('TBL_BUYER_MASTER','tbl_buyer');
define('TBL_BUYER_PO_MASTER','tbl_buyer_po');
define('TBL_BUYER_PO_MASTER_ITEM','tbl_buyerpo_item');
define('TBL_SUPPLIER_PO_MASTER','tbl_supplier_po');
define('TBL_SUPPLIER_PO_MASTER_ITEM','tbl_supplierpo_item');
define('TBL_VENDOR_PO_MASTER','tbl_vendor_po');
define('TBL_VENDOR_PO_MASTER_ITEM','tbl_vendorpo_item');
define('TBL_SUPPLIER_PO_CONFIRMATION','tbl_supplier_poconfirmation');
define('TBL_SUPPLIER_PO_CONFIRMATION_ITEM','tbl_supplierpoconfirmation_item');
define('TBL_VENDOR_PO_CONFIRMATION','tbl_vendor_poconfirmation');
define('TBL_VENDOR_PO_CONFIRMATION_ITEM','tbl_vendorpoconfirmation_item');
define('TBL_JOB_WORK','tbl_jobwork');
define('TBL_JOB_WORK_ITEM','tbl_jobwork_item');
define('TBL_BILL_OF_MATERIAL','tbl_bill_of_material');
define('TBL_BILL_OF_MATERIAL_ITEM','tbl_bill_of_materail_item');
define('TBL_BILL_OF_MATERIAL_VENDOR','tbl_vendor_bill_of_material');
define('TBL_BILL_OF_MATERIAL_VENDOR_ITEM','tbl_vendor_bill_of_materail_item');
define('TBL_INCOMING_DETAILS','tbl_incoming_details');
define('TBL_INCOMING_DETAILS_ITEM','tbl_incomingdetails_item');
define('TBL_PACKING_INSTRACTION','tbl_packing_instrauction');
define('TBL_PACKING_INSTRACTION_DETAILS','tbl_packing_instrauction_details');
define('TBL_EXPORT_DETAILS','tbl_export_details');
define('TBL_SCRAP_RETURN','tbl_scrapreturn');
define('TBL_SCRAP_RETURN_ITEM','tbl_scrapreturn_item');
define('TBL_REWORK_REJECTION','tbl_rework_rejection');
define('TBL_REWORK_REJECTION_ITEM','tbl_rework_rejection_item');
define('TBL_CHALLAN_FORM','tbl_challan_form');
define('TBL_CHALLAN_FORM_ITEM','tbl_challanform_item');
define('TBL_DEBIT_NOTE','tbl_debit_note');
define('TBL_DEBIT_NOTE_ITEM','tbl_debit_note_item');
define('TBL_PAYMENT_DETAILS','tbl_payment_details');
define('TBL_POD_DETAILS','tbl_pod_details');
define('TBL_POD_ITEM','tbl_pod_item');
define('TBL_QUALITY_RECORDS','tbl_quality_records');
define('TBL_QUALITY_RECORDS_ITEM','tbl_quality_records_item');
define('TBL_STOCKS','tbl_stock_form');
define('TBL_STOCKS_ITEM','tbl_stock_form_item');
define('TBL_OMS_CHALLAN','tbl_oms_challan');
define('TBL_OMS_CHALLAN_ITEM','tbl_oms_challan_item');
define('TBL_ENAUIRY_FORM','tbl_enquiry_form');
define('TBL_ENAUIRY_FORM_ITEM','tbl_enuiry_form_item');
define('TBL_REJECTION_FORM','tbl_rejection_form');
define('TBL_REJECTION_FORM_REJECTED_ITEM','tbl_tbl_rejection_form_rejected_item');
define('TBL_COMPLAIN_FORM','tbl_complainform');
define('TBL_CREDIT_NOTE','tbl_credit_note');
define('TBL_CREDIT_NOTE_ITEM','tbl_credit_note_item');
define('TBL_PREEXPORT','tbl_preexport');
define('TBL_PREEXPORT_ITEM_DETAILS','tbl_preexport_item_details');
define('TBL_PREEXPORT_ITEM_ATTRIBUTES','tbl_pre_export_item_attribute');
define('TBL_CHA_MASTER','tbl_cha');
define('TBL_SALES_TRACKING_REPORT','tbl_sales_tracking_report');
define('TBL_CHA_DEBIT_NOTE','tbl_cha_debit_note');
define('TBL_CHA_DEBIT_NOTE_TRANSACTION','tbl_cha_debitnote_transaction');
define('TBL_CUSTMOR_COMPALINT','tbl_coustomer_complaint');