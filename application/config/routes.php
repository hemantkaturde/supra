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
$route['buyerpo'] = "admin/buyerpo";
$route['addnewBuyerpo'] = "admin/addnewBuyerpo";
$route['fetchrBuyerpolist'] = "admin/fetchrBuyerpolist";
$route['deleteBuyerpo'] = "admin/deleteBuyerpo";
$route['supplierpo'] = "admin/supplierpo";
$route['addnewSupplierpo'] = "admin/addnewSupplierpo";
$route['fetchSupplierpolist'] = "admin/fetchSupplierpolist";
$route['deleteSupplierpo'] = "admin/deleteSupplierpo";
$route['addbuyeritem'] = "admin/addbuyeritem";
$route['deleteBuyerpoitem'] = "admin/deleteBuyerpoitem";
$route['getBuyerCurrency'] = "admin/getBuyerCurrency";
$route['viewBuyerpo/(:any)'] = "admin/viewBuyerpo/$1";
$route['getPartnumberByid'] = "admin/getPartnumberByid";
$route['addSuplieritem'] = "admin/addSuplieritem";
$route['viewSupplierpo/(:any)'] = "admin/viewSupplierpo/$1";
$route['deleteSupplierpoitem'] = "admin/deleteSupplierpoitem";
$route['getBuyerPonumberbyBuyerid'] = "admin/getBuyerPonumberbyBuyerid";
$route['getBuyerItemsforDisplay'] = "admin/getBuyerItemsforDisplay";
$route['getBuyerItemsforDisplayBybuyerid'] = "admin/getBuyerItemsforDisplayBybuyerid";
$route['vendorpo'] = "admin/vendorpo";
$route['fetchVendorpolist'] = "admin/fetchVendorpolist";
$route['addnewVendorpo'] = "admin/addnewVendorpo";
$route['getfinishedgoodsPartnumberByid'] = "admin/getfinishedgoodsPartnumberByid";
$route['addVendoritem'] = "admin/addVendoritem";
$route['deleteVendorpo'] = "admin/deleteVendorpo";
$route['deleteVendorpoitem'] = "admin/deleteVendorpoitem";
$route['viewVendorpo/(:any)'] = "admin/viewVendorpo/$1";
$route['viewVendorpo'] = "admin/viewVendorpo";
$route['getSuppliritemonly'] = "admin/getSuppliritemonly";
$route['supplierpoconfirmation'] = "admin/supplierpoconfirmation";
$route['addSupplierpoconfirmation'] = "admin/addSupplierpoconfirmation";
$route['fetchSupplierpoconfirmationlist'] = "admin/fetchSupplierpoconfirmationlist";
$route['getSupplierPonumberbySupplierid'] = "admin/getSupplierPonumberbySupplierid";
$route['getSupplierItemsforDisplay'] = "admin/getSupplierItemsforDisplay";
$route['deleteSupplierPoconfirmation'] = "admin/deleteSupplierPoconfirmation";
$route['getRowmaterialPartnumberByid'] = "admin/getRowmaterialPartnumberByid";
$route['addSupplierpoConfirmationitem'] = "admin/addSupplierpoConfirmationitem";
$route['getfinishedgoodsPartnumberByidvendor'] = "admin/getfinishedgoodsPartnumberByidvendor";
$route['getVendorDetailsBysupplierponumber'] = "admin/getVendorDetailsBysupplierponumber";
$route['getBuyerDetailsBysupplierponumberforbuyer'] = "admin/getBuyerDetailsBysupplierponumberforbuyer";
$route['getBuyerDetailsBysupplierponumberforbuyerpo'] = "admin/getBuyerDetailsBysupplierponumberforbuyerpo";
$route['getbuyerpoidforshowinitems'] = "admin/getbuyerpoidforshowinitems";
$route['deleteSupplierpoconfirmationitem'] = "admin/deleteSupplierpoconfirmationitem";
$route['viewSupplierpoconfirmation/(:any)'] = "admin/viewSupplierpoconfirmation/$1";
$route['getSupplirbuyernamesupplierpo'] = "admin/getSupplirbuyernamesupplierpo";
$route['getBuyerDetailsBysupplierponumber'] = "admin/getBuyerDetailsBysupplierponumber";
$route['vendorpoconfirmation'] = "admin/vendorpoconfirmation";
$route['addVendorpoconfirmation'] = "admin/addVendorpoconfirmation";
$route['fetchVendorrpoconfirmationlist'] = "admin/fetchVendorrpoconfirmationlist";
$route['getVendorPonumberbySupplierid'] = "admin/getVendorPonumberbySupplierid";
$route['getBuyerNamebySupplierid'] = "admin/getBuyerNamebySupplierid";
$route['addvendorpoconfirmation'] = "admin/addvendorpoconfirmation";
$route['getVendoritemonly'] = "admin/getVendoritemonly";
$route['getSuppliergoodsPartnumberByid'] = "admin/getSuppliergoodsPartnumberByid";
$route['saveVendorconfromationpoitem'] = "admin/saveVendorconfromationpoitem";
$route['deleteVendorpoconfirmatuionitem'] = "admin/deleteVendorpoconfirmatuionitem";
$route['deleteVendorPoconfirmation'] = "admin/deleteVendorPoconfirmation";
$route['jobWork'] = "admin/jobWork";
$route['addjobwork'] = "admin/addjobwork";
$route['fetchJobworklist'] = "admin/fetchJobworklist";
$route['getSuppliernamebyvendorpo'] = "admin/getSuppliernamebyvendorpo";
$route['getSuppliergoodsPartnumberByidjobwork'] = "admin/getSuppliergoodsPartnumberByidjobwork";
$route['saveJobworktem'] = "admin/saveJobworktem";
$route['deleteJobwork'] = "admin/deleteJobwork";
$route['editBuyerpo/(:any)'] = "admin/editBuyerpo/$1";
$route['editSupplierpo/(:any)'] = "admin/editSupplierpo/$1";
$route['editVendorpo/(:any)'] = "admin/editVendorpo/$1";
$route['deleteVendorpoitemedit'] = "admin/deleteVendorpoitemedit";
$route['billofmaterial'] = "admin/billofmaterial";
$route['fetchBillofmaterial'] = "admin/fetchBillofmaterial";
$route['addnewBillofmaterial'] = "admin/addnewBillofmaterial";
$route['saveBillofmaterialtem'] = "admin/saveBillofmaterialtem";
$route['deleteBillofmaterial'] = "admin/deleteBillofmaterial";
$route['vendorbillofmaterial'] = "admin/vendorbillofmaterial";
$route['fetchvendorBillofmaterial'] = "admin/fetchvendorBillofmaterial";
$route['addvendorBillofmaterial'] = "admin/addvendorBillofmaterial";
$route['deletevendorBillofmaterial'] = "admin/deletevendorBillofmaterial";
$route['getBuyerItemsforDisplaybyvendorpo'] = "admin/getBuyerItemsforDisplaybyvendorpo";
$route['getbuyerdetialsbybuyerponumber'] = "admin/getbuyerdetialsbybuyerponumber";
$route['getVendoritemsonlyvendorBillofmaterial'] = "admin/getVendoritemsonlyvendorBillofmaterial";
$route['getSuppliergoodsPartnumberByidforvendorbillofmaetrial'] = "admin/getSuppliergoodsPartnumberByidforvendorbillofmaetrial";
$route['saveVendorbilloamaterialitems'] = "admin/saveVendorbilloamaterialitems";
$route['deleteVendorbillofmaterialpoitem'] = "admin/deleteVendorbillofmaterialpoitem";
$route['viewVendorbillofmaterial/(:any)'] = "admin/viewVendorbillofmaterial/$1";
$route['getVendorDetailsBybuyerPOnumber'] = "admin/getVendorDetailsBybuyerPOnumber";
$route['getSupplierdetailsbyvendorponumber'] = "admin/getSupplierdetailsbyvendorponumber";
$route['getItemdetailsdependonvendorpobom'] = "admin/getItemdetailsdependonvendorpobom";
$route['packinginstaruction'] = "admin/packinginstaruction";
$route['addnewpackinginstruction'] = "admin/addnewpackinginstruction";
$route['fetchpackinginstartion'] = "admin/fetchpackinginstartion";
$route['addnewPackinginstruction'] = "admin/addnewPackinginstruction";
$route['deletepackinginstraction'] = "admin/deletepackinginstraction";
$route['addpackinginstractiondetails/(:any)'] = "admin/addpackinginstractiondetails/$1";
$route['editpackinginstraction/(:any)'] = "admin/editpackinginstraction/$1";
$route['updatepackinginstraction'] = "admin/updatepackinginstraction";
$route['addpackinginstractiondetailsaction'] = "admin/addpackinginstractiondetailsaction";
$route['deletepackinginstractionsubitem'] = "admin/deletepackinginstractionsubitem";
$route['getBuyerpoitemonly'] = "admin/getBuyerpoitemonly";
$route['exportdetails'] = "admin/exportdetails";
$route['fetchexportdetails'] = "admin/fetchexportdetails";
$route['addnewExportDetails'] = "admin/addnewExportDetails";
$route['editexportdetails/(:any)'] = "admin/editexportdetails/$1";
$route['updatexportdetails'] = "admin/updatexportdetails";
$route['deleteexportdetailsmain'] = "admin/deleteexportdetailsmain";
$route['addExportdetailsitems/(:any)'] = "admin/addExportdetailsitems/$1";
$route['getbuyeramdpackgindetails'] = "admin/getbuyeramdpackgindetails";
$route['challanform'] = "admin/challanform";
$route['packagingform'] = "admin/packagingform";
$route['rrchallan'] = "admin/rrchallan";
$route['incomingdetails'] = "admin/incomingdetails";
$route['getVendorpoitems'] = "admin/getVendorpoitems";
$route['getVendorPonumberbyVendorid'] = "admin/getVendorPonumberbyVendorid";
$route['addnewencomingdetails'] = "admin/addnewencomingdetails";
$route['fetchincomingdeatils'] = "admin/fetchincomingdeatils";
$route['editincomingdetails/(:any)'] = "admin/editincomingdetails/$1";
$route['deleteIncomingDetails'] = "admin/deleteIncomingDetails";
$route['saveincomingitem'] = "admin/saveincomingitem";
$route['deleteIncomingDetailsitem'] = "admin/deleteIncomingDetailsitem";
$route['getVendorsItemsforDisplay'] = "admin/getVendorsItemsforDisplay";
$route['getincomingListforDisplay'] = "admin/getincomingListforDisplay";
$route['viewexportdetails/(:any)'] = "admin/viewexportdetails/$1";
$route['editjobwork/(:any)'] = "admin/editjobwork/$1";
$route['scrapreturn'] = "admin/scrapreturn";
$route['addnewScrapreturn'] = "admin/addnewScrapreturn";
$route['fetchscrapreturn'] = "admin/fetchscrapreturn";
$route['deletescrapreturn'] = "admin/deletescrapreturn";
$route['savescrapreturnitem'] = "admin/savescrapreturnitem";
$route['deletescrapreturnitem'] = "admin/deletescrapreturnitem";
$route['editscrapreturn/(:any)'] = "admin/editscrapreturn/$1";
$route['currentorderstatus'] = "admin/currentorderstatus";
$route['reworkrejectionreturn'] = "admin/reworkrejectionreturn";
$route['addneworkrejection'] = "admin/addneworkrejection";
$route['fetchreworkrejection'] = "admin/fetchreworkrejection";
$route['deletereworkrejection'] = "admin/deletereworkrejection";
$route['editreworkrejection/(:any)'] = "admin/editreworkrejection/$1";
$route['getbuyerpodetailsforvendorbillofmaterial'] = "admin/getbuyerpodetailsforvendorbillofmaterial";
$route['getBuyerDetailsByvendorpoautofill'] = "admin/getBuyerDetailsByvendorpoautofill";
$route['getIncomingDetailsofbillofmaterial'] = "admin/getIncomingDetailsofbillofmaterial";
$route['getSuppliergoodsreworkrejectionvendor'] = "admin/getSuppliergoodsreworkrejectionvendor";
$route['getSuppliergoodsreworkrejectionsupplier'] = "admin/getSuppliergoodsreworkrejectionsupplier";
$route['savereworkrejectiontem'] = "admin/savereworkrejectiontem";
$route['deleteReworkRejectionitem'] = "admin/deleteReworkRejectionitem";
$route['addchallanform'] = "admin/addchallanform";
$route['fetchchallanform'] = "admin/fetchchallanform";
$route['deletechallanform'] = "admin/deletechallanform";
$route['editchallanform/(:any)'] = "admin/editchallanform/$1";
$route['saveChallanformitem'] = "admin/saveChallanformitem";
$route['deleteChallanformitem'] = "admin/deleteChallanformitem";


$route['debitnote'] = "admin/debitnote";
$route['paymentdetails'] = "admin/paymentdetails";
$route['poddetails'] = "admin/poddetails";











































































































































/* End of file routes.php */
/* Location: ./application/config/routes.php */