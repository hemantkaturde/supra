<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function saveCompanydata($id,$data){
            $this->db->where('id', $id);
            if($this->db->update(TBL_COMPANY, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
    }

    public function getSupplierCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".phone1 LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".email LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_SUPPLIER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getSupplierdata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".phone1 LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".email LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_SUPPLIER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_SUPPLIER.'.sup_id','DESC');
        $query = $this->db->get(TBL_SUPPLIER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['supplier_name'] = $value['supplier_name'];
                $data[$counter]['address'] =  $value['address'];
                $data[$counter]['email'] =  $value['email'];
                $data[$counter]['landline'] = $value['landline'];
                $data[$counter]['phone1'] =  $value['phone1'];
                $data[$counter]['contact_person'] =  $value['contact_person'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateSupplier/".$value['sup_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['sup_id']."' class='fa fa-trash-o deletesupplier' aria-hidden='true'></i>"; 
 
                $counter++; 
            }
        }

        return $data;
    }

    public function saveSupplierdata($id,$data){
        if($id != '') {
            $this->db->where('sup_id', $id);
            if($this->db->update(TBL_SUPPLIER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_SUPPLIER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function deleteSupplier($id){
         $this->db->where('sup_id', $id);
         //$this->db->delete(TBL_SUPPLIER);
         if($this->db->delete(TBL_SUPPLIER)){
            return TRUE;
         }else{
            return FALSE;
         }
    }
 
    public function checkifexits($supplier_name){

        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER.'.supplier_name', $supplier_name);
        $this->db->where(TBL_SUPPLIER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getSuplierdetails($id){
        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER.'.sup_id', $id);
        $this->db->where(TBL_SUPPLIER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER);
        $data = $query->result_array();
        return $data;
    }

    public function checkifexitsupdate($id,$supplier){
        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER.'.sup_id', $id);
        $this->db->where(TBL_SUPPLIER.'.supplier_name', $supplier);
        $this->db->where(TBL_SUPPLIER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER);
        $data = $query->num_rows();
        return $data;

    }

    public function getRowmaterialCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_RAWMATERIAL.".part_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".type_of_raw_material LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".HSN_code LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".length LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".gross_weight LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".hex_a_f LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_RAWMATERIAL.'.status', 1);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    
    public function getRowmaterialdata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_RAWMATERIAL.".part_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".type_of_raw_material LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".HSN_code LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".length LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".gross_weight LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_RAWMATERIAL.".hex_a_f LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_RAWMATERIAL.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_RAWMATERIAL.'.raw_id','DESC');
        $query = $this->db->get(TBL_RAWMATERIAL);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['part_number'] = $value['part_number'];
                $data[$counter]['type_of_raw_material'] =  $value['type_of_raw_material'];
                $data[$counter]['sitting_size'] =  $value['sitting_size'];
                $data[$counter]['HSN_code'] =  $value['HSN_code'];
                $data[$counter]['length'] = $value['length'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateRawmaterial/".$value['raw_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['raw_id']."' class='fa fa-trash-o deleteRawmaterial' aria-hidden='true'></i>"; 
 
                $counter++; 
            }
        }

        return $data;
    }

    public function saveMaterialdata($id,$data){
        if($id != '') {
            $this->db->where('raw_id', $id);
            if($this->db->update(TBL_RAWMATERIAL, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_RAWMATERIAL, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function checkifexitsrawmaterial($part_num,$type_of_good){

        $this->db->select('*');
        $this->db->where(TBL_RAWMATERIAL.'.part_number', trim($part_num));
        $this->db->where(TBL_RAWMATERIAL.'.type_of_raw_material', trim($type_of_good));
        $this->db->where(TBL_RAWMATERIAL.'.status', 1);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getRawmateraildetails($id){
        $this->db->select('*');
        $this->db->where(TBL_RAWMATERIAL.'.raw_id', $id);
        $this->db->where(TBL_RAWMATERIAL.'.status', 1);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $data = $query->result_array();
        return $data;
    }

    public function checkifexitsupdaterawmaterial($id,$part_num,$type_of_good){
        $this->db->select('*');
        $this->db->where(TBL_RAWMATERIAL.'.raw_id', trim($id));
        $this->db->where(TBL_RAWMATERIAL.'.part_number', trim($part_num));
        $this->db->where(TBL_RAWMATERIAL.'.type_of_raw_material', trim($type_of_good));
        $this->db->where(TBL_RAWMATERIAL.'.status', 1);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $data = $query->num_rows();
        return $data;

    }

    public function deleteRawmaterial($id){
        $this->db->where('raw_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_RAWMATERIAL)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getVedorCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".phone1 LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".email LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_VENDOR.'.status', 1);
        $query = $this->db->get(TBL_VENDOR);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getVendordata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".phone1 LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".email LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_VENDOR.'.ven_id','DESC');
        $query = $this->db->get(TBL_VENDOR);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['vendor_name'] = $value['vendor_name'];
                $data[$counter]['address'] =  $value['address'];
                $data[$counter]['email'] =  $value['email'];
                $data[$counter]['landline'] = $value['landline'];
                $data[$counter]['phone1'] =  $value['phone1'];
                $data[$counter]['contact_person'] =  $value['contact_person'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateVendor/".$value['ven_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['ven_id']."' class='fa fa-trash-o deletevendor' aria-hidden='true'></i>"; 
 
                $counter++; 
            }
        }

        return $data;
    }

    public function checkifexitsvendor($vendor_name){

        $this->db->select('*');
        $this->db->where(TBL_VENDOR.'.vendor_name', $vendor_name);
        $this->db->where(TBL_VENDOR.'.status', 1);
        $query = $this->db->get(TBL_VENDOR);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function saveVendordata($id,$data){
        if($id != '') {
            $this->db->where('ven_id', $id);
            if($this->db->update(TBL_VENDOR, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_VENDOR, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function getVendordetails($id){
        $this->db->select('*');
        $this->db->where(TBL_VENDOR.'.ven_id', $id);
        $this->db->where(TBL_VENDOR.'.status', 1);
        $query = $this->db->get(TBL_VENDOR);
        $data = $query->result_array();
        return $data;
    }

    public function checkifexitvendorsupdate($id,$vendor){
        $this->db->select('*');
        $this->db->where(TBL_VENDOR.'.ven_id', $id);
        $this->db->where(TBL_VENDOR.'.vendor_name', $vendor);
        $this->db->where(TBL_VENDOR.'.status', 1);
        $query = $this->db->get(TBL_VENDOR);
        $data = $query->num_rows();
        return $data;

    }

    public function deleteVendor($id){
        $this->db->where('ven_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_VENDOR)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getUspCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USP.".usp_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".phone1 LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".email LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_USP.'.status', 1);
        $query = $this->db->get(TBL_USP);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getUspdata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USP.".usp_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".phone1 LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USP.".email LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USP.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_USP.'.usp_id','DESC');
        $query = $this->db->get(TBL_USP);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['usp_name'] = $value['usp_name'];
                $data[$counter]['address'] =  $value['address'];
                $data[$counter]['email'] =  $value['email'];
                $data[$counter]['landline'] = $value['landline'];
                $data[$counter]['phone1'] =  $value['phone1'];
                $data[$counter]['contact_person'] =  $value['contact_person'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateUSP/".$value['usp_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['usp_id']."' class='fa fa-trash-o deletesusp' aria-hidden='true'></i>"; 
 
                $counter++; 
            }
        }

        return $data;
    }

    public function checkIfexitsusp($vendor_name){

        $this->db->select('*');
        $this->db->where(TBL_USP.'.usp_name', $vendor_name);
        $this->db->where(TBL_USP.'.status', 1);
        $query = $this->db->get(TBL_USP);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function saveUSPdata($id,$data){
        if($id != '') {
            $this->db->where('usp_id', $id);
            if($this->db->update(TBL_USP, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_USP, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function deleteUSP($id){
        $this->db->where('usp_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_USP)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getUSPdetails($id){

        $this->db->select('*');
        $this->db->where(TBL_USP.'.usp_id', $id);
        $this->db->where(TBL_USP.'.status', 1);
        $query = $this->db->get(TBL_USP);
        $data = $query->result_array();
        return $data;

    }

    public function checkifexituspdate($id,$usp_name){

        $this->db->select('*');
        $this->db->where(TBL_USP.'.usp_id', $id);
        $this->db->where(TBL_USP.'.usp_name', $usp_name);
        $this->db->where(TBL_USP.'.status', 1);
        $query = $this->db->get(TBL_USP);
        $data = $query->num_rows();
        return $data;


    }

    public function getfinishedCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_FINISHED_GOODS.".part_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".hsn_code LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".groass_weight LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".net_weight LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".drawing_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".sac LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getfinisheddata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_FINISHED_GOODS.".part_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".hsn_code LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".groass_weight LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".net_weight LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".drawing_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_FINISHED_GOODS.".sac LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_FINISHED_GOODS.'.fin_id','DESC');
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['part_number'] = $value['part_number'];
                $data[$counter]['name'] =  $value['name'];
                $data[$counter]['hsn_code'] =  $value['hsn_code'];
                $data[$counter]['groass_weight'] = $value['groass_weight'];
                $data[$counter]['net_weight'] =  $value['net_weight'];
                $data[$counter]['sac'] =  $value['sac'];
                $data[$counter]['drawing_number'] =  $value['drawing_number'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateFinishedgoods/".$value['fin_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['fin_id']."' class='fa fa-trash-o deletefinishedgoodsdata' aria-hidden='true'></i>"; 
 
                $counter++; 
            }
        }

        return $data;
    }

    public function checkIfexitsFinishedgoods($name){

        $this->db->select('*');
        $this->db->where(TBL_FINISHED_GOODS.'.name', $name);
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function saveFinishedgoodsdata($id,$data){
        if($id != '') {
            $this->db->where('fin_id', $id);
            if($this->db->update(TBL_FINISHED_GOODS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_FINISHED_GOODS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function deletefinishedgoods($id){
        $this->db->where('fin_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_FINISHED_GOODS)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getFinishedgoodsdata($id){
        $this->db->select('*');
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id', $id);
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
    }

    public function checkifexitfinishedgoodsupdate($id,$name){
        $this->db->select('*');
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id', $id);
        $this->db->where(TBL_FINISHED_GOODS.'.name', $name);
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->num_rows();
        return $data;

    }

    public function getPlattingCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PLATTING_MASTER.".type_of_raw_material LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PLATTING_MASTER.".type_of_platting LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_PLATTING_MASTER.'.status', 1);
        $query = $this->db->get(TBL_PLATTING_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getPlattingdata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PLATTING_MASTER.".type_of_raw_material LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PLATTING_MASTER.".type_of_platting LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_PLATTING_MASTER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_PLATTING_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_PLATTING_MASTER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['type_of_raw_material'] = $value['type_of_raw_material'];
                $data[$counter]['type_of_platting'] =  $value['type_of_platting'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updatePlattingmaster/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['id']."' class='fa fa-trash-o deleteplattingmaster' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function checkifexitsplatting($type_of_raw_material){

        $this->db->select('*');
        $this->db->where(TBL_PLATTING_MASTER.'.type_of_raw_material', $type_of_raw_material);
        $this->db->where(TBL_PLATTING_MASTER.'.status', 1);
        $query = $this->db->get(TBL_PLATTING_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveplattingdata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_PLATTING_MASTER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_PLATTING_MASTER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }


    }

    public function deleteplatting($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_PLATTING_MASTER)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getPlattingmasterdata($id){
        $this->db->select('*');
        $this->db->where(TBL_PLATTING_MASTER.'.id', $id);
        $this->db->where(TBL_PLATTING_MASTER.'.status', 1);
        $query = $this->db->get(TBL_PLATTING_MASTER);
        $data = $query->result_array();
        return $data;

    }


    public function checkifexitplattingupdate($id,$name){

        $this->db->select('*');
        $this->db->where(TBL_PLATTING_MASTER.'.id', $id);
        $this->db->where(TBL_PLATTING_MASTER.'.type_of_raw_material', $name);
        $this->db->where(TBL_PLATTING_MASTER.'.status', 1);
        $query = $this->db->get(TBL_PLATTING_MASTER);
        $data = $query->num_rows();
        return $data;


    }


}

?>