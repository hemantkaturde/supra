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
$route['getBuyerPonumberbyBuyeridvendorpo'] = "admin/getBuyerPonumberbyBuyeridvendorpo";
$route['getBuyerPonumberbyBuyeridforsupplierandvendorpo'] = "admin/getBuyerPonumberbyBuyeridforsupplierandvendorpo";
$route['getSuppliritemonlyforgetbuyeritemonly'] = "admin/getSuppliritemonlyforgetbuyeritemonly";
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
$route['editSupplierpoconfirmation/(:any)'] = "admin/editSupplierpoconfirmation/$1";
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
$route['addnewdebitnote'] = "admin/addnewdebitnote";
$route['fetchdebitnotedetails'] = "admin/fetchdebitnotedetails";
$route['editdebitnoteform/(:any)'] = "admin/editdebitnoteform/$1";
$route['deletedebitnote'] = "admin/deletedebitnote";
$route['saveDebitnoteitem'] = "admin/saveDebitnoteitem";
$route['deleteDebitnoteitem'] = "admin/deleteDebitnoteitem";
$route['paymentdetails'] = "admin/paymentdetails";
$route['addnewpaymentdetails'] = "admin/addnewpaymentdetails";
$route['fetchPaymentdetails'] = "admin/fetchPaymentdetails";
$route['deletepaymentdetails'] = "admin/deletepaymentdetails";
$route['editpaymentdetails/(:any)'] = "admin/editpaymentdetails/$1";
$route['addpaymentdetailsdata/(:any)'] = "admin/addpaymentdetailsdata/$1";
$route['get_vendorpodata'] = "admin/get_vendorpodata";
$route['get_supplierpodata'] = "admin/get_supplierpodata";
$route['poddetails'] = "admin/poddetails";
$route['fetchpoddetails'] = "admin/fetchpoddetails";
$route['addNewPODdetails'] = "admin/addNewPODdetails";
$route['savepoditem'] = "admin/savepoditem";
$route['deletepoddetails'] = "admin/deletepoddetails";
$route['deletePODitem'] = "admin/deletePODitem";
$route['addpaymentdetailsdata/(:any)'] = "admin/addpaymentdetailsdata/$1";
$route['get_vendorpodata_with_debit_data'] = "admin/get_vendorpodata_with_debit_data";
$route['get_supplierpodata_debit_data'] = "admin/get_supplierpodata_debit_data";
$route['qualityrecord'] = "admin/qualityrecord";
$route['addNewqualityrecord'] = "admin/addNewqualityrecord";
$route['fetchqulityrecords'] = "admin/fetchqulityrecords";
$route['savequlityrecorditem'] = "admin/savequlityrecorditem";
$route['stockform'] = "admin/stockform";
$route['getbuyerpodetailsforvendorstockform'] = "admin/getbuyerpodetailsforvendorstockform";
$route['getItemdetailsdependonvendorpoforstockform'] = "admin/getItemdetailsdependonvendorpoforstockform";
$route['addNewstockform'] = "admin/addNewstockform";
$route['fetchstockformrecords'] = "admin/fetchstockformrecords";
$route['saveStockformitem'] = "admin/saveStockformitem";
$route['deleteStockformitem'] = "admin/deleteStockformitem";
$route['deletestockform'] = "admin/deletestockform";
$route['editstcokformdetails/(:any)'] = "admin/editstcokformdetails/$1";
$route['searchstock'] = "admin/searchstock";
$route['fetchsearchstockrecords'] = "admin/fetchsearchstockrecords";
$route['getincominglotnumberbyvendor'] = "admin/getincominglotnumberbyvendor";
$route['getinvoiceqtybyLotnumber'] = "admin/getinvoiceqtybyLotnumber";
$route['getalltotalcalculationstockform'] = "admin/getalltotalcalculationstockform";
$route['fetchexportrecordsitem'] = "admin/fetchexportrecordsitem";
$route['fetchrejecteditem'] = "admin/fetchrejecteditem";
$route['omschallan'] = "admin/omschallan";
$route['fetchomschallan'] = "admin/fetchomschallan";
$route['addNewOMSChallan'] = "admin/addNewOMSChallan";
$route['deleteomschallan'] = "admin/deleteomschallan";
$route['saveomschallanitem'] = "admin/saveomschallanitem";
$route['deleteOmschallnitem'] = "admin/deleteOmschallnitem";
$route['editomschallan/(:any)'] = "admin/editomschallan/$1";
$route['enquiryform'] = "admin/enquiryform";
$route['fetchenquiryform'] = "admin/fetchenquiryform";
$route['addnewenquiryform'] = "admin/addnewenquiryform";
$route['saveenquiryformitem'] = "admin/saveenquiryformitem";
$route['editeqnuiryformdatabyid/(:any)'] = "admin/editeqnuiryformdatabyid/$1";
$route['editvendorpoconfirmation/(:any)'] = "admin/editvendorpoconfirmation/$1";
$route['deleteBillofmaterialitem'] = "admin/deleteBillofmaterialitem";
$route['checkvendorpoandvendornumber'] = "admin/checkvendorpoandvendornumber";
$route['checkvendorpoandvendornumberinbillofmaterial'] = "admin/checkvendorpoandvendornumberinbillofmaterial";
$route['checkvendorpoandvendornumberinvendorbillofmaterial'] = "admin/checkvendorpoandvendornumberinvendorbillofmaterial";
$route['fetchincomingdeatilsitemlistadd/(:any)'] = "admin/fetchincomingdeatilsitemlistadd/$1";
$route['editbillofmaterial/(:any)'] = "admin/editbillofmaterial/$1";
$route['editvendorbillofmaterial/(:any)'] = "admin/editvendorbillofmaterial/$1";
$route['stockrejectionform'] = "admin/stockrejectionform";
$route['fetchenstockrejectionform'] = "admin/fetchenstockrejectionform";
$route['addnewrejectionform'] = "admin/addnewrejectionform";
$route['editrejetionform/(:any)'] = "admin/editrejetionform/$1";
$route['deleterejectionform'] = "admin/deleterejectionform";
$route['addrejectionformitemsdata/(:any)'] = "admin/addrejectionformitemsdata/$1";
$route['fetchenstockrejectionformitemdata/(:any)'] = "admin/fetchenstockrejectionformitemdata/$1";
$route['fetchenstockrejectionformitemdata/(:any)'] = "admin/fetchenstockrejectionformitemdata/$1";
$route['addrejectionformitemsdatamultientries'] = "admin/addrejectionformitemsdatamultientries";
$route['saverejectedformitemdata'] = "admin/saverejectedformitemdata";
$route['viewrejectionformitemdetails'] = "admin/viewrejectionformitemdetails";
$route['fetch_stock_rejection_form_ttem_details'] = "admin/fetch_stock_rejection_form_ttem_details";
$route['deleterejectionformitem'] = "admin/deleterejectionformitem";
$route['getStockdatadependsonvendorpo'] = "admin/getStockdatadependsonvendorpo";
$route['getbuyerorderqtyfrompartnumber'] = "admin/getbuyerorderqtyfrompartnumber";
$route['vendorponumberforviewitemstockform_display'] = "admin/vendorponumberforviewitemstockform_display";
$route['getallcalculationrejecteditems'] = "admin/getallcalculationrejecteditems";
$route['deletequlityrecords'] = "admin/deletequlityrecords";
$route['deletequalityrecordsitem'] = "admin/deletequalityrecordsitem";
$route['editqulityrecordform/(:any)'] = "admin/editqulityrecordform/$1";
$route['getallcalculationexportitems'] = "admin/getallcalculationexportitems";
$route['getallbalencecalculationexportitems'] = "admin/getallbalencecalculationexportitems";
$route['deletejobworkitem'] = "admin/deletejobworkitem";
$route['editpoddetails/(:any)'] = "admin/editpoddetails/$1";
$route['getexportdetailsforqulityrecord'] = "admin/getexportdetailsforqulityrecord";
$route['deleteenquiryformdata'] = "admin/deleteenquiryformdata";
$route['deleteenquiryformitemdata'] = "admin/deleteenquiryformitemdata";
$route['geteditenquiryformitemdata'] = "admin/geteditenquiryformitemdata";
$route['getVendorPoconfirmationvendorlist'] = "admin/getVendorPoconfirmationvendorlist";



/* ALL Downlaod Forms */
$route['downlaodsupplierpo/(:any)'] = "admin/downlaodsupplierpo/$1";
$route['downloadvendorpo/(:any)'] = "admin/downloadvendorpo/$1";
$route['downloadvendorpowithoutsupplier/(:any)'] = "admin/downloadvendorpowithoutsupplier/$1";
$route['downloadreworkrejection/(:any)'] = "admin/downloadreworkrejection/$1";
$route['downloadpackinginstraction/(:any)'] = "admin/downloadpackinginstraction/$1";
$route['downloadreworkrejectionvendor/(:any)'] = "admin/downloadreworkrejectionvendor/$1";
$route['downloadchallanform/(:any)'] = "admin/downloadchallanform/$1";
$route['downloadchallanformvendor/(:any)'] = "admin/downloadchallanformvendor/$1";
$route['downlaoddebitnote/(:any)'] = "admin/downlaoddebitnote/$1";
$route['downlaoddebitnotevendor/(:any)'] = "admin/downlaoddebitnotevendor/$1";
$route['downlaodjobworkchllan/(:any)'] = "admin/downlaodjobworkchllan/$1";
$route['getdownloadscrapreturn/(:any)'] = "admin/downloadscrapreturn/$1";
$route['downloadomsblasting/(:any)'] = "admin/downloadomsblasting/$1";
$route['downloadomsmachinary/(:any)'] = "admin/downloadomsmachinary/$1";
$route['downloadcomplainform/(:any)'] = "admin/downloadcomplainform/$1";
$route['downloadpreexportform/(:any)'] = "admin/downloadpreexportform/$1";
$route['downloadenquiryformdata/(:any)'] = "admin/downloadenquiryformdata/$1";




/* ALL Edit Forms*/
$route['getbuyeritemdataforitemedit'] = "admin/getbuyeritemdataforitemedit";
$route['getSupplieritemdataforitemedit'] = "admin/getSupplieritemdataforitemedit";
$route['getVendoritemdataforitemedit'] = "admin/getVendoritemdataforitemedit";
$route['getSupplierpoconfimationitemedit'] = "admin/getSupplierpoconfimationitemedit";
$route['getvendorpoconfirmationitemedit'] = "admin/getvendorpoconfirmationitemedit";
$route['getIncomingDetailitemedit'] = "admin/getIncomingDetailitemedit";
$route['geteditBillofmaterialitem'] = "admin/geteditBillofmaterialitem";
$route['geteditVendorbillofmaterialpoitem'] = "admin/geteditVendorbillofmaterialpoitem";
$route['geteditDebitnoteitemedit'] = "admin/geteditDebitnoteitemedit";
$route['geteditjobworkitem'] = "admin/geteditjobworkitem";
$route['geteditReworkRejectionitem'] = "admin/geteditReworkRejectionitem";
$route['geteditqualityrecordsitem'] = "admin/geteditqualityrecordsitem";
$route['geteditrejectionformitem'] = "admin/geteditrejectionformitem";
$route['geteditpackinginstractionsubitem'] = "admin/geteditpackinginstractionsubitem";
$route['geteditStockformitem'] = "admin/geteditStockformitem";
$route['editrejectedformitemdata'] = "admin/editrejectedformitemdata";
$route['geteditChallanformitem'] = "admin/geteditChallanformitem";
$route['geteditScrpareturnid'] = "admin/geteditScrpareturnid";
$route['geteditPODitem'] = "admin/geteditPODitem";
$route['getVendoritemonlyforpod'] = "admin/getVendoritemonlyforpod";
$route['getSuppliergoodsreworkrejectionvendorpod'] = "admin/getSuppliergoodsreworkrejectionvendorpod";
$route['geteditChallanformitemforedititem'] = "admin/geteditChallanformitemforedititem";
$route['getVendorPonumberbySupplieridvendorbillofmaterial'] = "admin/getVendorPonumberbySupplieridvendorbillofmaterial";
$route['getVendoritemonlyforchallan'] = "admin/getVendoritemonlyforchallan";
$route['getdebitnotepartnumberdetails_byvendor'] = "admin/getdebitnotepartnumberdetails_byvendor";
$route['getSuppliergoodsreworkrejectionvendorchallan'] = "admin/getSuppliergoodsreworkrejectionvendorchallan";
$route['getSuppliergoodsreworkrejectionvendorreworkrejection'] = "admin/getSuppliergoodsreworkrejectionvendorreworkrejection";
$route['getVendoritemonlyforreworkrejection'] = "admin/getVendoritemonlyforreworkrejection";
$route['getpreviousshortexcess'] = "admin/getpreviousshortexcess";
$route['getSupplierPonumberbySupplieridvendorponew'] = "admin/getSupplierPonumberbySupplieridvendorponew";
$route['buyerpodetailsreport'] = "admin/buyerpodetailsreport";
$route['complaintform'] = "admin/complaintform";
$route['addcomplaintform'] = "admin/addcomplaintform";
$route['fetchcompalintrecords'] = "admin/fetchcompalintrecords";
$route['deletecomplainform'] = "admin/deletecomplainform";
$route['editcomplainform/(:any)'] = "admin/editcomplainform/$1";
$route['itcreport'] = "admin/itcreport";
$route['getPartDetailsbypartnumber'] = "admin/getPartDetailsbypartnumber";
$route['addcreditnote'] = "admin/addcreditnote";
$route['getBuyerPonumbercreditnote'] = "admin/getBuyerPonumbercreditnote";
$route['getPartnumberBypartnumberforcreitnote'] = "admin/getPartnumberBypartnumberforcreitnote";
$route['getexportInvoicebybyerpo'] = "admin/getexportInvoicebybyerpo";
$route['getInvoicedateforcreditdate'] = "admin/getInvoicedateforcreditdate";
$route['fetchcreditnoterecords'] = "admin/fetchcreditnoterecords";
$route['creditnote'] = "admin/creditnote";
$route['saveCreditnoteitem'] = "admin/saveCreditnoteitem";
$route['deletecreditnote'] = "admin/deletecreditnote";
$route['deletecreditnoteitem'] = "admin/deletecreditnoteitem";
$route['editcreditnote/(:any)'] = "admin/editcreditnote/$1";
$route['getbuyeritemonly'] = "admin/getbuyeritemonly";
$route['checkvendorpoandvendornumberinvendorpoconfirmation'] = "admin/checkvendorpoandvendornumberinvendorpoconfirmation";
$route['checkvendorpoandvendornumberinsupplierpoconfirmation'] = "admin/checkvendorpoandvendornumberinsupplierpoconfirmation";
$route['geteditcreditnoteitem'] = "admin/geteditcreditnoteitem";
$route['checkvendorpoandvendornumberinpoddetails'] = "admin/checkvendorpoandvendornumberinpoddetails";
$route['checksupplierandvendornumberinpoddetails'] = "admin/checksupplierandvendornumberinpoddetails";
$route['preexport'] = "admin/preexport";
$route['fetchpreexportdetails'] = "admin/fetchpreexportdetails";
$route['addnewfreexport'] = "admin/addnewfreexport";
$route['deletepreexport'] = "admin/deletepreexport";
$route['editpreexport/(:any)'] = "admin/editpreexport/$1";
$route['exportdetailsitemdetails/(:any)'] = "admin/exportdetailsitemdetails/$1";
$route['fetchpreexportitemdetails/(:any)'] = "admin/fetchpreexportitemdetails/$1";
$route['addpreexportitemdetails/(:any)'] = "admin/addpreexportitemdetails/$1";
$route['get_preexport_item_details'] = "admin/get_preexport_item_details";
$route['deletepreexportitemdetails'] = "admin/deletepreexportitemdetails";
$route['editaddpreexportitemdetails/(:any)'] = "admin/editaddpreexportitemdetails/$1";
$route['addexportitemdetailswithattributes/(:any)'] = "admin/addexportitemdetailswithattributes/$1";
$route['fetchpreexportitemdetailsattribute/(:any)'] = "admin/fetchpreexportitemdetailsattribute/$1";
$route['addexportitemdetailswithattributesvalues/(:any)'] = "admin/addexportitemdetailswithattributesvalues/$1";
$route['deletepreexportitemattributes'] = "admin/deletepreexportitemattributes";
$route['editexportitemdetailswithattributesvalues/(:any)'] = "admin/editexportitemdetailswithattributesvalues/$1";
$route['chamaster'] = "admin/chamaster";
$route['fetchCHA'] = "admin/fetchCHA";
$route['addnewCha'] = "admin/addnewCha";
$route['updatecha/(:any)'] = "admin/updatecha/$1";
$route['deletecha'] = "admin/deletecha";
$route['salestrackingreport'] = "admin/salestrackingreport";
$route['fetchsalestrackingReport'] = "admin/fetchsalestrackingReport";
$route['addsalestrackingreport'] = "admin/addsalestrackingreport";
$route['getinvoicedetilsbyinvoiceid'] = "admin/getinvoicedetilsbyinvoiceid";
$route['deletesalestracking'] = "admin/deletesalestracking";
$route['getcreditnotedetailsbycreditnoteid'] = "admin/getcreditnotedetailsbycreditnoteid";



$route['getdebitnotedetailsbydebitenoteeid'] = "admin/getdebitnotedetailsbydebitenoteeid";
$route['getnumberofcartoonsfrompreexport'] = "admin/getnumberofcartoonsfrompreexport";
$route['editsalestrackingreport/(:any)'] = "admin/editsalestrackingreport/$1";
$route['checkifpartnumberisalreadyexists'] = "admin/checkifpartnumberisalreadyexists";


$route['chadebitnote'] = "admin/chadebitnote";
$route['addchadebitnote'] = "admin/addchadebitnote";















































































































/* End of file routes.php */
/* Location: ./application/config/routes.php */