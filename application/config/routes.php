<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "login";
$route['404_override'] = 'login/error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['noaccess'] = 'login/noaccess';
$route['userListing'] = 'admin/userListing';
$route['userListing/(:num)'] = "admin/userListing/$1";
$route['addNew'] = "admin/addNew";
$route['addNewUser'] = "admin/addNewUser";
$route['editOld'] = "admin/editOld";
$route['editOld/(:num)'] = "admin/editOld/$1";
$route['editUser'] = "admin/editUser";
$route['deleteUser'] = "admin/deleteUser";
$route['log-history'] = "admin/logHistory";
$route['log-history-backup'] = "admin/logHistoryBackup";
$route['log-history/(:num)'] = "admin/logHistorysingle/$1";
$route['log-history/(:num)/(:num)'] = "admin/logHistorysingle/$1/$2";
$route['backupLogTable'] = "admin/backupLogTable";
$route['backupLogTableDelete'] = "admin/backupLogTableDelete";
$route['log-history-upload'] = "admin/logHistoryUpload";
$route['logHistoryUploadFile'] = "admin/logHistoryUploadFile";

/*********** MANAGER CONTROLLER ROUTES *******************/
$route['tasks'] = "manager/tasks";
$route['addNewTask'] = "manager/addNewTask";
$route['addNewTasks'] = "manager/addNewTasks";
$route['editOldTask/(:num)'] = "manager/editOldTask/$1";
$route['editTask'] = "manager/editTask";
$route['deleteTask/(:num)'] = "manager/deleteTask/$1";

/*********** USER CONTROLLER ROUTES *******************/
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['endTask/(:num)'] = "user/endTask/$1";
$route['etasks'] = "user/etasks";
$route['userEdit'] = "user/loadUserEdit";
$route['updateUser'] = "user/updateUser";


/*********** LOGIN CONTROLLER ROUTES *******************/
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";


/*********** COMPANY MASTER ROUTES *******************/
$route['companymaster'] = "admin/companymaster";
$route['updateCompanyInfo'] = "admin/updateCompanyInfo";

/*********** BASIC MASTER ROUTES *******************/
$route['suppliermaster'] = "admin/suppliermaster";
$route['fetchSupplier'] = "admin/fetchSupplier";
$route['addnewSupplier'] = "admin/addnewSupplier";
$route['updateSupplier/(:any)'] = "admin/updateSupplier/$1";
$route['deleteSupplier'] = "admin/deleteSupplier";
$route['rowmaterialmaster'] = "admin/rowmaterialmaster";
$route['fetchRowmaterial'] = "admin/fetchRowmaterial";
$route['addnewmaterialdata'] = "admin/addnewmaterialdata";
$route['updateRawmaterial/(:any)'] = "admin/updateRawmaterial/$1";
$route['deleteRawmaterial'] = "admin/deleteRawmaterial";
$route['vendormaster'] = "admin/vendormaster";
$route['fetchVendor'] = "admin/fetchVendor";
$route['addnewVendor'] = "admin/addnewVendor";
$route['updateVendor/(:any)'] = "admin/updateVendor/$1";
$route['deleteVendor'] = "admin/deleteVendor";
$route['uspmaster'] = "admin/uspmaster";
$route['fetchUSP'] = "admin/fetchUSP";
$route['addnewUSP'] = "admin/addnewUSP";
$route['updateUSP/(:any)'] = "admin/updateUSP/$1";
$route['deleteUSP'] = "admin/deleteUSP";
$route['finishedgoodsmaster'] = "admin/finishedgoodsmaster";
$route['fetchfinishedgoods'] = "admin/fetchfinishedgoods";
$route['addnewFinishedgoods'] = "admin/addnewFinishedgoods";
$route['updateFinishedgoods/(:any)'] = "admin/updateFinishedgoods/$1";
$route['deletefinishedgoods'] = "admin/deletefinishedgoods";
$route['plattingmaster'] = "admin/plattingmaster";
$route['fetchplattinglist'] = "admin/fetchplattinglist";
$route['addnewPlatting'] = "admin/addnewPlatting";
$route['updatePlattingmaster/(:any)'] = "admin/updatePlattingmaster/$1";
$route['deleteplatting'] = "admin/deleteplatting";
$route['rejectionmaster'] = "admin/rejectionmaster";
$route['fetchrRjectionglist'] = "admin/fetchrRjectionglist";
$route['addnewRejection'] = "admin/addnewRejection";
$route['updateRejectionmaster/(:any)'] = "admin/updateRejectionmaster/$1";
$route['deleteRejection'] = "admin/deleteRejection";


$route['buyermaster'] = "admin/buyermaster";
$route['fetchrBuyerlist'] = "admin/fetchrBuyerlist";
$route['addnewBuyer'] = "admin/addnewBuyer";
$route['updateBuyer/(:any)'] = "admin/updateBuyer/$1";
$route['deleteBuyer'] = "admin/deleteBuyer";
















/* End of file routes.php */
/* Location: ./application/config/routes.php */