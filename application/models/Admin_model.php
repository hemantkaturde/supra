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

    public function getRejectionCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_REJECTION_MASTER.".rejection_reason LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REJECTION_MASTER.".rejection_reason LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_REJECTION_MASTER.'.status', 1);
        $query = $this->db->get(TBL_REJECTION_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getRejectiondata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_REJECTION_MASTER.".rejection_reason LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REJECTION_MASTER.".rejection_reason LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_REJECTION_MASTER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_REJECTION_MASTER.'.rejec_id','DESC');
        $query = $this->db->get(TBL_REJECTION_MASTER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['rejection_reason'] = $value['rejection_reason'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateRejectionmaster/".$value['rejec_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['rejec_id']."' class='fa fa-trash-o deleteRejection' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function checkifexitrejection($reason){
        $this->db->select('*');
        $this->db->where(TBL_REJECTION_MASTER.'.rejection_reason', $reason);
        $this->db->where(TBL_REJECTION_MASTER.'.status', 1);
        $query = $this->db->get(TBL_REJECTION_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function savRejectiongdata($id,$data){
        if($id != '') {
            $this->db->where('rejec_id', $id);
            if($this->db->update(TBL_REJECTION_MASTER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_REJECTION_MASTER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function deleteRejection($id){
        $this->db->where('rejec_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_REJECTION_MASTER)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getRejectiongmasterdata($id){
        $this->db->select('*');
        $this->db->where(TBL_REJECTION_MASTER.'.rejec_id', $id);
        $this->db->where(TBL_REJECTION_MASTER.'.status', 1);
        $query = $this->db->get(TBL_REJECTION_MASTER);
        $data = $query->result_array();
        return $data;

    }

    public function checkifexitRejectionupdate($id,$name){

        $this->db->select('*');
        $this->db->where(TBL_REJECTION_MASTER.'.rejec_id', $id);
        $this->db->where(TBL_REJECTION_MASTER.'.rejection_reason', trim($name));
        $this->db->where(TBL_REJECTION_MASTER.'.status', 1);
        $query = $this->db->get(TBL_REJECTION_MASTER);
        $data = $query->num_rows();
        return $data;


    }

    public function getBuyerCount($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".GSTIN LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_BUYER_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getBuyerdata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".address LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".landline LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".contact_person LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".GSTIN LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BUYER_MASTER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_BUYER_MASTER.'.buyer_id','DESC');
        $query = $this->db->get(TBL_BUYER_MASTER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['buyer_name'] = $value['buyer_name'];
                $data[$counter]['address'] = $value['address'];
                $data[$counter]['email'] = $value['email'];
                $data[$counter]['landline'] = $value['landline'];
                $data[$counter]['mobile'] = $value['mobile'];
                $data[$counter]['contact_person'] = $value['contact_person'];
                $data[$counter]['GSTIN'] = $value['GSTIN'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."updateBuyer/".$value['buyer_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['buyer_id']."' class='fa fa-trash-o deleteBuyer' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function checkIfexitsbuyer($buyer_name){

        $this->db->select('*');
        $this->db->where(TBL_BUYER_MASTER.'.buyer_name', $buyer_name);
        $this->db->where(TBL_BUYER_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveBuyerdata($id,$data){
        if($id != '') {
            $this->db->where('buyer_id', $id);
            if($this->db->update(TBL_BUYER_MASTER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_BUYER_MASTER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function deleteBuyer($id){
        $this->db->where('buyer_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BUYER_MASTER)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getBuyergmasterdata($id){
        $this->db->select('*');
        $this->db->where(TBL_BUYER_MASTER.'.buyer_id', $id);
        $this->db->where(TBL_BUYER_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_MASTER);
        $data = $query->result_array();
        return $data;

    }

    public function checkifexitBuyerupdate($id,$name){

        $this->db->select('*');
        $this->db->where(TBL_BUYER_MASTER.'.buyer_id', $id);
        $this->db->where(TBL_BUYER_MASTER.'.buyer_name', trim($name));
        $this->db->where(TBL_BUYER_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_MASTER);
        $data = $query->num_rows();
        return $data;

    }

    public function fetchAllbuyerList(){
        $this->db->select('*');
        $this->db->where(TBL_BUYER_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function fetchALLrowMaterialList(){
        $this->db->select('*');
        $this->db->where(TBL_RAWMATERIAL.'.status', 1);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $data = $query->result_array();
        return $data;

    }

    public function getBuyerpoCount($params){

        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_BUYER_PO_MASTER.'.buyer_name_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".buyer_po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".buyer_po_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".currency LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_BUYER_PO_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getBuyerpodata($params){

        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_BUYER_PO_MASTER.'.buyer_name_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".buyer_po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".buyer_po_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".currency LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BUYER_PO_MASTER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_BUYER_PO_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['sales_order_number'] = $value['sales_order_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['buyer_po_number'] = $value['buyer_po_number'];
                $data[$counter]['buyer_po_date'] = $value['buyer_po_date'];
                $data[$counter]['buyer_name'] = $value['buyer_name'];
                $data[$counter]['currency'] = $value['currency'];
                $data[$counter]['action'] = '';
                //$data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewBuyerpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>    &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editBuyerpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>    &nbsp";
                // $data[$counter]['action'] .= "<a href='".ADMIN_PATH."downloadbuyerpo/".$value['id']."' style='cursor: pointer;' target='_blank'><i style='font-size: 21px;cursor: pointer;' class='fa fa-file-pdf-o' aria-hidden='true'></i></a>    &nbsp";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['id']."' class='fa fa-trash-o deleteBuyerpo' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function checkIfexitsbuyerpo($sales_order_number){

        $this->db->select('*');
        $this->db->where(TBL_BUYER_PO_MASTER.'.sales_order_number', $sales_order_number);
        $this->db->where(TBL_BUYER_PO_MASTER.'.status', 1);
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveBuyerpodata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_BUYER_PO_MASTER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_BUYER_PO_MASTER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }


    }

    public function deleteBuyerpo($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BUYER_PO_MASTER)){

            $this->db->where('buyer_po_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_BUYER_PO_MASTER_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        //    return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getPreviousSalesOrderNumber(){

        $this->db->select('sales_order_number');
        $this->db->where(TBL_BUYER_PO_MASTER.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_BUYER_PO_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function fetchALLsupplierList(){

        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER);
        $data = $query->result_array();
        return $data;


    }

    public function fetchALLvendorList(){

        $this->db->select('*');
        $this->db->where(TBL_VENDOR.'.status', 1);
        $query = $this->db->get(TBL_VENDOR);
        $data = $query->result_array();
        return $data;
    }

    public function checkIfexitssupplierrpo($po_number){

        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.po_number', $po_number);
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveSupplierpodata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_SUPPLIER_PO_MASTER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_SUPPLIER_PO_MASTER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }


    }

    public function getSupplierpoCount($params){

        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_SUPPLIER_PO_MASTER.'.buyer_name');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id  = '.TBL_SUPPLIER_PO_MASTER.'.supplier_name');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_SUPPLIER_PO_MASTER.'.vendor_name');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".quatation_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getSupplierpodata($params){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as sup_name');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_SUPPLIER_PO_MASTER.'.buyer_name');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id  = '.TBL_SUPPLIER_PO_MASTER.'.supplier_name');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_SUPPLIER_PO_MASTER.'.vendor_name');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".quatation_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_SUPPLIER_PO_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['po_number'] = $value['po_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['sup_name'] = $value['sup_name'];
                $data[$counter]['buyer_name'] = $value['buyer_name'];
                $data[$counter]['vendor_name'] = $value['vendor_name'];
                $data[$counter]['quatation_ref_no'] = $value['quatation_ref_no'];
                $data[$counter]['quatation_date'] = $value['quatation_date'];
                $data[$counter]['action'] = '';
               // $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editSupplierpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>  &nbsp";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."downlaodsupplierpo/".$value['id']."' style='cursor: pointer;' target='_blank'><i style='font-size: x-large;cursor: pointer;' class='fa fa-file-pdf-o' aria-hidden='true'></i></a>  &nbsp";

                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['id']."' class='fa fa-trash-o deleteSupplierpo' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function deleteSupplierpo($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_SUPPLIER_PO_MASTER)){
            $this->db->where('supplier_po_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_SUPPLIER_PO_MASTER_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        }else{
           return FALSE;
        }
    }

    public function saveBuyerpoitemdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_BUYER_PO_MASTER_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }

            // if($this->db->insert(TBL_BUYER_PO_MASTER_ITEM, $data)) {
            //     return $this->db->insert_id();;
            // } else {
            //     return FALSE;
            // }


        } else {
            if($this->db->insert(TBL_BUYER_PO_MASTER_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function fetchALLitemList(){

        $this->db->select('*');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_BUYER_PO_MASTER_ITEM.'.pre_buyer_name','left');
        $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id IS NULL');
        $this->db->order_by(TBL_BUYER_PO_MASTER_ITEM.'.id','desc');
        $query = $this->db->get(TBL_BUYER_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function update_last_inserted_id($last_inserted_id){
        $data = array(
            'buyer_po_id' => $last_inserted_id
        );
        $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id IS NULL');
        if($this->db->update(TBL_BUYER_PO_MASTER_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function deleteBuyerpoitem($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BUYER_PO_MASTER_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getBuyerCurrency($buyer_id){

        $this->db->select('currency');
        $this->db->where(TBL_BUYER_MASTER.'.status',1);
        $this->db->where(TBL_BUYER_MASTER.'.buyer_id',$buyer_id);
        $query = $this->db->get(TBL_BUYER_MASTER);
        $data = $query->result_array();
        return $data;

    } 
    
    public function getbuyerpodetails($buyerpoid){
        $this->db->select('*');
        $this->db->where(TBL_BUYER_PO_MASTER.'.status',1);
        $this->db->where(TBL_BUYER_PO_MASTER.'.id',$buyerpoid);
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $data = $query->result_array();
        return $data;

    }

    public function fetchALLBuyeritemList($buyerpoid){
        $this->db->select('*');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id');
        $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyerpoid);
        $query = $this->db->get(TBL_BUYER_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getPartnumberBypartnumber($part_number){
        $this->db->select('*');
        $this->db->where(TBL_RAWMATERIAL.'.status',1);
        $this->db->where(TBL_RAWMATERIAL.'.raw_id ',$part_number);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $data = $query->result_array();
        return $data;

    }

    public function getPreviousPONumber(){

        $this->db->select('po_number');
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_SUPPLIER_PO_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function saveSupplierpoitemdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_SUPPLIER_PO_MASTER_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }

            // if($this->db->insert(TBL_SUPPLIER_PO_MASTER_ITEM, $data)) {
            //     return $this->db->insert_id();;
            // } else {
            //     return FALSE;
            // }

        } else {
            if($this->db->insert(TBL_SUPPLIER_PO_MASTER_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function fetchALLpresupplieritemList(){

        $this->db->select('*,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.id as supplirid');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_buyer_po_number');
        $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id IS NULL');
        $this->db->order_by(TBL_SUPPLIER_PO_MASTER_ITEM.'.id','desc');
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function update_last_inserted_id_supplier_po($last_inserted_id){
        $data = array(
            'supplier_po_id' => $last_inserted_id
        );
        $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id IS NULL');
        if($this->db->update(TBL_SUPPLIER_PO_MASTER_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function deleteSupplierpoitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_SUPPLIER_PO_MASTER_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }


    public function deleteSupplierpoconfirmationitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_SUPPLIER_PO_CONFIRMATION_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getAllBuyerpoNUmber($buyer_name){

        $this->db->select('*');
		$this->db->where('buyer_name_id', $buyer_name);
        $this->db->where('status', 1);
        $this->db->order_by('sales_order_number','ASC');
        $query_result = $this->db->get(TBL_BUYER_PO_MASTER)->result_array();
		
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
		
        return $query_result;
    }

    public function getBuyerDeatilsbyid($buyer_po_id){


        $this->db->select('*');
		$this->db->where('id', $buyer_po_id);
        $this->db->where('status', 1);
        // $this->db->order_by('sales_order_number','ASC');
        $query_result = $this->db->get(TBL_BUYER_PO_MASTER)->result_array();
		
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
		
        return $query_result;

    }

    public function getSuplierpodetails($supplierpoid){
        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status',1);
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.id',$supplierpoid);
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $data = $query->result_array();
        return $data;

    }

    public function fetchALLsupplieritemlistforview($supplierpoid){
        $this->db->select('*,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.id as suppliritemid');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id');
        $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplierpoid);
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getVendorpoCount($params){

        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id  = '.TBL_VENDOR_PO_MASTER.'.supplier_name','left');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_VENDOR_PO_MASTER.'.vendor_name');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".quatation_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getVendorpodata($params){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as sup_name,'.TBL_VENDOR_PO_MASTER.'.id  as vendor_po_master_id');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id  = '.TBL_VENDOR_PO_MASTER.'.supplier_name','left');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_VENDOR_PO_MASTER.'.vendor_name');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".quatation_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_VENDOR_PO_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['po_number'] = $value['po_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['sup_name'] = $value['sup_name'];
                $data[$counter]['buyer_name'] = $value['buyer_name'];
                $data[$counter]['vendor_name'] = $value['vendor_name'];
                $data[$counter]['quatation_ref_no'] = $value['quatation_ref_no'];
                $data[$counter]['quatation_date'] = $value['quatation_date'];
                $data[$counter]['action'] = '';
                //$data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewVendorpo/".$value['vendor_po_master_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
              
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editVendorpo/".$value['vendor_po_master_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>  &nbsp";
              
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['vendor_po_master_id']."' class='fa fa-trash-o deleteVendorpo' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function checkIfexitsvendorrpo($po_number){

        $this->db->select('*');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.po_number', $po_number);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveVensorpodata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_VENDOR_PO_MASTER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_VENDOR_PO_MASTER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function update_last_inserted_id_vendor_po($last_inserted_id){
        $data = array(
            'vendor_po_id' => $last_inserted_id
        );
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id IS NULL');
        if($this->db->update(TBL_VENDOR_PO_MASTER_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function fetchALLFinishgoodList(){
        $this->db->select('*');
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
    }

    public function getfinishedgoodsPartnumberByid($part_number,$flag){


        if($flag=='Supplier'){

            // $this->db->select('*,'.TBL_RAWMATERIAL.'.net_weight as supplier_goods_net_weight,'.TBL_RAWMATERIAL.'.sac as supplier_goods_sac,'.TBL_RAWMATERIAL.'.type_of_raw_material as name,'.TBL_RAWMATERIAL.'.HSN_code as hsn_code,'.TBL_RAWMATERIAL.'.gross_weight as groass_weight,'.TBL_RAWMATERIAL.'.net_weight as supplier_goods_net_weight');
            // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            // $this->db->where(TBL_RAWMATERIAL.'.status',1);
            // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            // $query = $this->db->get(TBL_RAWMATERIAL);
            // $data = $query->result_array();
            // return $data;


            $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as supplier_goods_net_weight,'.TBL_FINISHED_GOODS.'.sac as supplier_goods_sac');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            $query = $this->db->get(TBL_FINISHED_GOODS);
            $data = $query->result_array();
            return $data;


        }else{
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as supplier_goods_net_weight,'.TBL_FINISHED_GOODS.'.sac as supplier_goods_sac');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            $query = $this->db->get(TBL_FINISHED_GOODS);
            $data = $query->result_array();
            return $data;

        }
    }


    public function getfinishedgoodsPartnumberByidforbuyer($part_number){
        $this->db->select('*');
        //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        //$this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;

    }


    public function saveVendorpoitemdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_VENDOR_PO_MASTER_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_VENDOR_PO_MASTER_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function getPreviousvendorPONumber(){

        $this->db->select('po_number');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_VENDOR_PO_MASTER.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function fetchALLpreVendoritemList(){

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER_ITEM.'.id as vendoritemid,'.TBL_VENDOR_PO_MASTER_ITEM.'.vendor_qty as vendorpoitem_qty');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_supplier_po_number','left');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_buyer_po_number');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id IS NULL');
        $this->db->order_by(TBL_VENDOR_PO_MASTER_ITEM.'.id','desc');
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function deleteVendorpo($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_VENDOR_PO_MASTER)){
            $this->db->where('vendor_po_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_VENDOR_PO_MASTER_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        }else{
           return FALSE;
        }

    }

    public function deleteVendorpoitem($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_VENDOR_PO_MASTER_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getVendorpodetails($vendorpoid){
        $this->db->select('*');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status',1);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id',$vendorpoid);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;

    }


    public function getVendorpodetailsedit($vendorpoid){
        $this->db->select(TBL_VENDOR_PO_MASTER.'.*,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_BUYER_PO_MASTER.'.sales_order_number as buyer_po_number_po');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_VENDOR_PO_MASTER.'.buyer_po_number = '.TBL_BUYER_PO_MASTER.'.id','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_VENDOR_PO_MASTER.'.supplier_po_number = '.TBL_SUPPLIER_PO_MASTER.'.id','left');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status',1);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id',$vendorpoid);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;

    }

    public function fetchALLVendoritemlistforview($vendorpoid){
        $this->db->select('*,'.TBL_VENDOR_PO_MASTER_ITEM.'.id as vendor_po_item');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendorpoid);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getSupplierpoconfirmationCount($params){

        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_SUPPLIER_PO_CONFIRMATION.'.buyer_po_id');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id  = '.TBL_SUPPLIER_PO_CONFIRMATION.'.supplier_po_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SUPPLIER_PO_CONFIRMATION.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".confirmed_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".po_confirmed LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
    
    public function getSupplierpoconfirmationdata($params){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as sup_name,'.TBL_BUYER_MASTER.'.buyer_name as bu_name');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_SUPPLIER_PO_CONFIRMATION.'.buyer_po_id');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id  = '.TBL_SUPPLIER_PO_CONFIRMATION.'.supplier_po_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SUPPLIER_PO_CONFIRMATION.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".confirmed_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".po_confirmed LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_CONFIRMATION.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_SUPPLIER_PO_CONFIRMATION.'.id','DESC');
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['po_number'] = $value['po_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['sup_name'] = $value['sup_name'];
                $data[$counter]['buyer_name'] = $value['bu_name'];
                $data[$counter]['po_confirmed'] = $value['po_confirmed'];
                $data[$counter]['confirmed_date'] = $value['confirmed_date'];
                $data[$counter]['confirmed_with'] = $value['confirmed_with'];
                $data[$counter]['action'] = '';
               // $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpoconfirmation/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editSupplierpoconfirmation/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";

                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['id']."' class='fa fa-trash-o deleteSupplierPoconfirmation' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
        
    }

    public function getSupplierDeatilsbyid($supplier_name){

        $this->db->select('*');
		$this->db->where('supplier_name', $supplier_name);
        $this->db->where('status', 1);

        $query_result = $this->db->get(TBL_SUPPLIER_PO_MASTER)->result_array();
		
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
		
        return $query_result;

    }

    public function getPreviousSupplierPoconfirmationNumber(){

        $this->db->select('po_number');
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_SUPPLIER_PO_CONFIRMATION.'.id','DESC');
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION);
        $rowcount = $query->result_array();
        return $rowcount;


    }

    public function getSupplieritemsonly($supplier_po_number,$flag){

      if($flag=='Supplier'){
            // $this->db->select('*');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $this->db->group_by(TBL_FINISHED_GOODS.'.part_number');
            // $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
            // $query = $this->db->get(TBL_FINISHED_GOODS);
            // $data = $query->result_array();
            // return $data;


            $this->db->select('*,'.TBL_RAWMATERIAL.'.raw_id as item_id');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $this->db->group_by(TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
            $query = $this->db->get(TBL_RAWMATERIAL);
            $data = $query->result_array();
            return $data;



      }else{

            // $this->db->select('*');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$supplier_po_number);
            // $query = $this->db->get(TBL_FINISHED_GOODS);
            // $data = $query->result_array();
            // return $data;


            $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as item_id');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$supplier_po_number);
            $query = $this->db->get(TBL_FINISHED_GOODS);
            $data = $query->result_array();
            return $data;

      }

    }

    public function checkIfexitsSupplierpoconfirmation($po_number){

        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.po_number', $po_number);
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.status', 1);
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveSupplierpoconfirmationdata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_SUPPLIER_PO_CONFIRMATION, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_SUPPLIER_PO_CONFIRMATION, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function deleteSupplierPoconfirmation($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_SUPPLIER_PO_CONFIRMATION)){
           //return TRUE;
           $this->db->where('supplier_po_confirmation_id', $id);
           //$this->db->delete(TBL_SUPPLIER);
           if($this->db->delete(TBL_SUPPLIER_PO_CONFIRMATION_ITEM)){
              return TRUE;
           }else{
              return FALSE;
           }
        }else{
           return FALSE;
        }
    }

    public function getRowmaterialPartnumberByid($part_number){
        $this->db->select('*');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_RAWMATERIAL.'.status',1);
        $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        $query = $this->db->get(TBL_RAWMATERIAL);
        $data = $query->result_array();
        return $data;
    }

    public function saveSupplierpoconfirmationitemdata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_SUPPLIER_PO_CONFIRMATION_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_SUPPLIER_PO_CONFIRMATION_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }


    }

    public function fetchALLpresupplierpoconfirmationitemList(){

        $this->db->select('*,'.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id as supplierpoitemid');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.part_number_id');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.pre_supplier_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.pre_buyer_po_number','left');

        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.supplier_po_confirmation_id IS NULL');
        $this->db->order_by(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id','desc');
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getVendorDetailsBysupplierponumber($supplier_po_number){

        $this->db->select(TBL_VENDOR.'.*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER.'.vendor_name');
        // $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.buyer_name_id = '.TBL_BUYER_MASTER.'.buyer_id');
		$this->db->where(TBL_SUPPLIER_PO_MASTER.'.id', $supplier_po_number);
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $query_result = $this->db->get(TBL_SUPPLIER_PO_MASTER)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }

    public function update_last_inserted_id_supplier_po_confirmation($saveSupplierpoconfirmationdata){

        $data = array(
            'supplier_po_confirmation_id' => $saveSupplierpoconfirmationdata
        );
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.supplier_po_confirmation_id IS NULL');
        if($this->db->update(TBL_SUPPLIER_PO_CONFIRMATION_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function fetchALLSupplierPOitemsforview($supplierpoconfirmationid){

        $this->db->select('*,'.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id as supplier_po_itemid');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.part_number_id');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.pre_supplier_po_number');
        //$this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.pre_buyer_po_number');
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.supplier_po_confirmation_id',$supplierpoconfirmationid);
        $this->db->order_by(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id','desc');
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function getVendorpoconfirmationCount($params){
        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as bu_name');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_VENDOR_PO_CONFIRMATION.'.buyer_name');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_VENDOR_PO_CONFIRMATION.'.vendor_name');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_CONFIRMATION.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".confirmed_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".po_confirmed LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION.'.status', 1);
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION);
        $rowcount = $query->num_rows();
        return $rowcount;


    }

    public function getVendorpoconfirmationdata($params){
        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as bu_name');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id  = '.TBL_VENDOR_PO_CONFIRMATION.'.buyer_name');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_VENDOR_PO_CONFIRMATION.'.vendor_name');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_CONFIRMATION.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".confirmed_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".po_confirmed LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_CONFIRMATION.".quatation_ref_no LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_VENDOR_PO_CONFIRMATION.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['po_number'] = $value['po_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['vendor_name'] = $value['vendor_name'];
                $data[$counter]['buyer_name'] = $value['bu_name'];
                $data[$counter]['po_confirmed'] = $value['po_confirmed'];
                $data[$counter]['confirmed_date'] = $value['confirmed_date'];
                $data[$counter]['confirmed_with'] = $value['confirmed_with'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editvendorpoconfirmation/".$value['id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['id']."' class='fa fa-trash-o deleteVendorPoconfirmation' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
    }

    public function getBuyerDetailsBysupplierponumber($supplier_po_number){

        $this->db->select(TBL_BUYER_MASTER.'.*');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER.'.vendor_name');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_SUPPLIER_PO_MASTER.'.buyer_name');
		$this->db->where(TBL_SUPPLIER_PO_MASTER.'.id', $supplier_po_number);
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $query_result = $this->db->get(TBL_SUPPLIER_PO_MASTER)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }

    public function getSupplierpoconfirmationdetails($supplierpoconfirmationid){

        $this->db->select('*,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_SUPPLIER_PO_CONFIRMATION.'.buyer_po_id as buyerpoid');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION.'.supplier_po_number');
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.id', $supplierpoconfirmationid);
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION);
        $data = $query->result_array();
        return $data;

    }

    public function getVendorPonumberbySupplierid($supplier_name){
        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.vendor_name', $supplier_name);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number !=',"");
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function getVendorPoconfirmationvendorlist($supplier_name){
        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.vendor_name', $supplier_name);
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number !=',"");
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }


    public function getVendorPonumberbySupplieridvendorbillofmaterial($supplier_name){
        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.vendor_name', $supplier_name);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name =',"");
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number =',"");
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function getBuyerNamebySupplierid($supplier_name){

    
        $this->db->select(TBL_BUYER_MASTER.'.*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $supplier_name);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function checkIfexitsVendorpoconfirmation($po_number){

        $this->db->select('*');
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION.'.po_number', $po_number);
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION.'.status', 1);
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function saveVendorpoconfirmationdata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_VENDOR_PO_CONFIRMATION, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_VENDOR_PO_CONFIRMATION, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function getVendoritemsonly($vendor_po_number,$flag){

        $this->db->select('*');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;

    }


     public function chekc_if_supplie_name_exits($vendor_po_number){

        $this->db->select('supplier_po_number,supplier_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->row_array();
        return $data;

     }


    public function getSuppliergoodsPartnumberByid($part_number,$flag){

        if($flag=='Supplier'){

            $this->db->select('*,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty,'.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.order_oty as supplier_order_qty,'.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.sent_qty as supplier_sent_qty');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->join(TBL_SUPPLIER_PO_CONFIRMATION_ITEM, TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
    
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            $query = $this->db->get(TBL_FINISHED_GOODS);
            $data = $query->result_array();
            return $data;

        }else{
            $this->db->select('*,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty,0 as supplier_order_qty,0 as supplier_sent_qty');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->join(TBL_SUPPLIER_PO_CONFIRMATION_ITEM, TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.vendor_id = '.TBL_VENDOR.'.ven_id');
    
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            $query = $this->db->get(TBL_FINISHED_GOODS);
            $data = $query->result_array();
            return $data;
        }

        
    }

    public function saveVendorpoconfirmationitemdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_VENDOR_PO_CONFIRMATION_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_VENDOR_PO_CONFIRMATION_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
        
    }

    public function fetchALLpreVendorpoconfirmationitemList(){

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id as vendoritemid,'.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.pre_remark as remark_vendor_po_confrimation');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.part_number_id');
        //$this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.pre_supplier_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.pre_buyer_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.pre_vendor_po_number');

        $this->db->where(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.vendor_po_confirmation_id IS NULL');
        $this->db->order_by(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id','desc');
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION_ITEM);
        $data = $query->result_array();
        return $data;

    }


    public function fetchALLpreVendorpoconfirmationitemListedit($vendor_po_confirmation_id){

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id as vendoritemid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.part_number_id');
        //$this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.pre_supplier_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.pre_buyer_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.vendor_po_confirmation_id',$vendor_po_confirmation_id);
        $this->db->order_by(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id','desc');
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getPreviousVendorPoconfirmationNumber(){

        $this->db->select('po_number');
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_VENDOR_PO_CONFIRMATION.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION);
        $rowcount = $query->result_array();
        return $rowcount;


    }
    
    public function update_last_inserted_id_vendor_po_confirmation($saveVendorpoconfirmationdata){

        $data = array(
            'vendor_po_confirmation_id' => $saveVendorpoconfirmationdata
        );
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.vendor_po_confirmation_id IS NULL');
        if($this->db->update(TBL_VENDOR_PO_CONFIRMATION_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function deleteVendorpoconfirmatuionitem($id){

        
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_VENDOR_PO_CONFIRMATION_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function deleteVendorPoconfirmation($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_VENDOR_PO_CONFIRMATION)){
           //return TRUE;
           $this->db->where('vendor_po_confirmation_id', $id);
           //$this->db->delete(TBL_SUPPLIER);
           if($this->db->delete(TBL_VENDOR_PO_CONFIRMATION_ITEM)){
              return TRUE;
           }else{
              return FALSE;
           }
        }else{
           return FALSE;
        }

    }

    public function getPreviousjobworkponumber(){

        $this->db->select('po_number');
        $this->db->where(TBL_JOB_WORK.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_JOB_WORK.'.id','DESC');
        $query = $this->db->get(TBL_JOB_WORK);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function fetchALLprejobworkitemList(){

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER.'.supplier_name as rowmaterialsuppliername,'.TBL_JOB_WORK_ITEM.'.id as jobworkitemid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_JOB_WORK_ITEM.'.part_number_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_JOB_WORK_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_JOB_WORK_ITEM.'.pre_raw_material_supplier_name','left');
        $this->db->where(TBL_JOB_WORK_ITEM.'.jobwork_id IS NULL');
        $this->db->order_by(TBL_JOB_WORK_ITEM.'.id','desc');
        $query = $this->db->get(TBL_JOB_WORK_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getJobworkCount($params){

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendorpo,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_SUPPLIER.'.supplier_name as 	suppliername');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_JOB_WORK.'.vendor_name');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id= '.TBL_JOB_WORK.'.raw_material_supplier','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_JOB_WORK.'.vendor_po_number');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_JOB_WORK.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_JOB_WORK.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_JOB_WORK.".raw_material_supplier LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_JOB_WORK.'.status', 1);
        $query = $this->db->get(TBL_JOB_WORK);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getJobworkdata($params){

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendorpo,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_SUPPLIER.'.supplier_name as 	suppliername,'.TBL_JOB_WORK.'.id as jobworkid,'.TBL_JOB_WORK.'.po_number as jobworkponumber');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_JOB_WORK.'.vendor_name');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id= '.TBL_JOB_WORK.'.raw_material_supplier','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_JOB_WORK.'.vendor_po_number');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_JOB_WORK.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_JOB_WORK.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_JOB_WORK.".raw_material_supplier LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_JOB_WORK.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_JOB_WORK.'.id','DESC');
        $query = $this->db->get(TBL_JOB_WORK);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['po_number'] = $value['jobworkponumber'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po'] = $value['vendorpo'];
                $data[$counter]['raw_material_supplier'] = $value['suppliername'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editjobwork/".$value['jobworkid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['jobworkid']."' class='fa fa-trash-o deleteJobwork' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
    }

    public function checkIfexitsJobwork($po_number){

        $this->db->select('*');
        $this->db->where(TBL_JOB_WORK.'.po_number', $po_number);
        $this->db->where(TBL_JOB_WORK.'.status', 1);
        $query = $this->db->get(TBL_JOB_WORK);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function saveJobworkdata($id,$data){

        if($id != '') {


            $this->db->where('id', $id);
            if($this->db->update(TBL_JOB_WORK, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_JOB_WORK, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function getSuppliernamebyvendorpo($vendor_po_number){
        $this->db->select('*');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_VENDOR_PO_MASTER.'.supplier_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function update_last_inserted_id_job_work($saveJobworkdata){
        $data = array(
            'jobwork_id' => $saveJobworkdata
        );
        $this->db->where(TBL_JOB_WORK_ITEM.'.jobwork_id IS NULL');
        if($this->db->update(TBL_JOB_WORK_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function getSuppliergoodsPartnumberByidjobwork($part_number,$vendor_po_number,$supplier_po_number){
        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        

        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.rate as supplierrate');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');

        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_supplier_name',$supplier_po_number);
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;


    }

    public function deleteJobwork($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_JOB_WORK)){
            $this->db->where('jobwork_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_JOB_WORK_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        }else{
           return FALSE;
        }

    }

    public function saveJobworkitemdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_JOB_WORK_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_JOB_WORK_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function getBillofmaterialCount($params){

        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL.'.vendor_po_number');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".part_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BILL_OF_MATERIAL.'.status', 1);        
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getBillofmaterialdata($params){

        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_BILL_OF_MATERIAL.'.id as billofmaterialid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL.'.vendor_po_number');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".part_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BILL_OF_MATERIAL.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_BILL_OF_MATERIAL.'.id','DESC');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['bom_number'] = $value['bom_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['vendor_po_number'] = $value['po_number'];
                //$data[$counter]['vendor_number'] = $value['vendor_number'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['bom_status'] = $value['bom_status'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editbillofmaterial/".$value['billofmaterialid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['billofmaterialid']."' class='fa fa-trash-o deleteBillofmaterial' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;

    }

    public function getbillofmaterialdataforedit($billofmaterialid){

        $this->db->select(TBL_BILL_OF_MATERIAL.'.bom_number,'.TBL_BILL_OF_MATERIAL.'.id as bomidedit,'.TBL_BILL_OF_MATERIAL.'.date as bomdate,'
        .TBL_BILL_OF_MATERIAL.'.supplier_name,'
        .TBL_BILL_OF_MATERIAL.'.supplier_po_number,'
        .TBL_BILL_OF_MATERIAL.'.vendor_name as bomvendor,'
        .TBL_VENDOR_PO_MASTER.'.po_number,'
        .TBL_VENDOR_PO_MASTER.'.id as vendor_po_id,'
        .TBL_BILL_OF_MATERIAL.'.buyer_name as bill_of_buyer_id,'
        .TBL_BUYER_PO_MASTER.'.sales_order_number,'
        .TBL_BILL_OF_MATERIAL.'.buyer_po_number,'
        .TBL_BILL_OF_MATERIAL.'.buyer_po_date,'
        .TBL_BILL_OF_MATERIAL.'.buyer_delivery_date,'
        .TBL_BILL_OF_MATERIAL.'.bom_status,'
        .TBL_BILL_OF_MATERIAL.'.incoming_details,'
        .TBL_BILL_OF_MATERIAL.'.remark,'
        .TBL_BILL_OF_MATERIAL.'.supplier_po_date'
        
         );

        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL.'.vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL.'.buyer_po_number');
        // $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $this->db->where(TBL_BILL_OF_MATERIAL.'.id', $billofmaterialid);
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        $row_data = $query->row_array();
        return $row_data;

    }

    public function getAllitemdetailsforfilteredit($id){
        
        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$id);
        $this->db->group_by(TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function getPreviousBomnumber(){

        $this->db->select('bom_number');
        $this->db->where(TBL_BILL_OF_MATERIAL.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_BILL_OF_MATERIAL.'.id','DESC');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function checkIfexitsBillofmaterial($bom_number){

        $this->db->select('*');
        $this->db->where(TBL_BILL_OF_MATERIAL.'.bom_number', $bom_number);
        $this->db->where(TBL_BILL_OF_MATERIAL.'.status', 1);
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function saveBillofmaterial($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_BILL_OF_MATERIAL, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_BILL_OF_MATERIAL, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function deleteBillofmaterial($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BILL_OF_MATERIAL)){
            $this->db->where('bom_id', $id);
            if($this->db->delete(TBL_BILL_OF_MATERIAL_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
            return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getvendorBillofmaterialCount($params){

        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL_VENDOR.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".part_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);        
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $rowcount = $query->num_rows();
        return $rowcount;
        

    }

    public function getvendorBillofmaterialdata($params){

        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_BILL_OF_MATERIAL_VENDOR.'.id as billofmaterialid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL_VENDOR.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".part_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR.'.id','DESC');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['bom_number'] = $value['bom_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['vendor_po_number'] = $value['po_number'];
                //$data[$counter]['vendor_number'] = $value['vendor_number'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['bom_status'] = $value['bom_status'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editvendorbillofmaterial/".$value['billofmaterialid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['billofmaterialid']."' class='fa fa-trash-o deletevendorBillofmaterial' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;

    }

    public function checkIfexitsvendorBillofmaterial($bom_number){

        $this->db->select('*');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.bom_number', $bom_number);
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function savevendorBillofmaterial($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_BILL_OF_MATERIAL_VENDOR, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_BILL_OF_MATERIAL_VENDOR, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function deletevendorBillofmaterial($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BILL_OF_MATERIAL_VENDOR)){
            $this->db->where('vendor_bill_of_material_id', $id);
            if($this->db->delete(TBL_BILL_OF_MATERIAL_VENDOR_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
            return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getbuyerdetialsbybuyerponumber($buyer_po_number){
        $this->db->select('buyer_po_date,delivery_date');
        $this->db->where(TBL_BUYER_PO_MASTER.'.status',1);
        $this->db->where(TBL_BUYER_PO_MASTER.'.id',$buyer_po_number);
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function getVendoritemsonlyvendorBillofmaterial($vendor_po_number){

        // $this->db->select('*');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // //$this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
        // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        
        $this->db->select('*');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;


    }

    public function getSuppliergoodsPartnumberByidforvendorbillofmaetrial($part_number,$vendor_po_number){
        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        $this->db->select(TBL_FINISHED_GOODS.'.name,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty as buyer_po_qty,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id' .' and '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id='.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
    }

    public function saveVendorbillofmaterilitemdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_BILL_OF_MATERIAL_VENDOR_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_BILL_OF_MATERIAL_VENDOR_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
        
    }

    public function fetchALLpreVendorpoitemList(){

        $this->db->select('*,'.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id as vendoritmid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.pre_buyer_po_number');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id IS NULL');
        $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id','desc');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function update_last_inserted_id_vendor_bill_of_materil($savevendorBillofmaterial){
        $data = array(
            'vendor_bill_of_material_id' => $savevendorBillofmaterial
        );
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id IS NULL');
        if($this->db->update(TBL_BILL_OF_MATERIAL_VENDOR_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function getPreviousBomnumbervendor(){

        $this->db->select('bom_number');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR.'.id','DESC');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function deleteVendorbillofmaterialpoitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BILL_OF_MATERIAL_VENDOR_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }


    }

    public function getVendorbillofmaterialDetails($id){
        $this->db->select('*');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $data = $query->result_array();
        return $data;
    }

    public function getVendorbillofmaterialitem($id){

        $this->db->select('*,'.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id as vendoritmid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.pre_buyer_po_number');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id',$id);
        $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id','desc');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR_ITEM);
        $data = $query->result_array();
        return $data;


    }

    public function fetchAllbuyerpoList($buyer_po_id){

        $this->db->select('*');
        $this->db->where(TBL_BUYER_PO_MASTER.'.buyer_name_id',$buyer_po_id);
        $this->db->where(TBL_BUYER_PO_MASTER.'.status',1);
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $data = $query->result_array();
        return $data;

    }

    public function getVendorDetailsBybuyerPOnumber($supplier_po_number){

        $this->db->select(TBL_VENDOR.'.*');
        $query_result = $this->db->get(TBL_VENDOR)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }


    public function getSupplierdetailsbyvendorponumber($vendor_po_number){
        
        $this->db->select(TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplierpo,'.TBL_SUPPLIER_PO_MASTER.'.date as supplierdate');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id= '.TBL_VENDOR_PO_MASTER.'.supplier_po_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id= '.TBL_SUPPLIER_PO_MASTER.'.supplier_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status',1);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function getItemdetailsdependonvendorpobom($part_number,$vendor_po_number,$vendor_name){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as supplierrate,'.TBL_FINISHED_GOODS.'.groass_weight as fg_gross_weight,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as ram_supplier_order_qty');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        // $this->db->join(TBL_VENDOR_PO_CONFIRMATION_ITEM, TBL_VENDOR_PO_CONFIRMATION_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
    }

    public function getincomingdeatilscount(){

        $this->db->select('*,'.TBL_INCOMING_DETAILS.'.vendor_name as vendorname');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_INCOMING_DETAILS.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_INCOMING_DETAILS.'.vendor_po_number');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_INCOMING_DETAILS.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_INCOMING_DETAILS.".reported_by LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_INCOMING_DETAILS.".reported_date LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);        
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getincomingdeatilsdata(){

        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_INCOMING_DETAILS.'.id as incomigid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_INCOMING_DETAILS.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_INCOMING_DETAILS.'.vendor_po_number');
        
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_INCOMING_DETAILS.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_INCOMING_DETAILS.".reported_by LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_INCOMING_DETAILS.".reported_date LIKE '%".$params['search']['value']."%')");
        }
   
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_INCOMING_DETAILS.'.id','DESC');
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                if($value['reported_date']=='0000-00-00'){
                    $reported_date = '';
                }else{
                    $reported_date = $value['reported_date'];
                }

                $data[$counter]['incoming_details_id'] = $value['incoming_details_id'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['po_number'];
                $data[$counter]['reported_by'] = $value['reported_by'];
                $data[$counter]['reported_date'] = $reported_date;
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editincomingdetails/".$value['incomigid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['incomigid']."' class='fa fa-trash-o deleteIncomingDetails' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;


    }

    public function getVendorpoitems($part_number,$vendor_po_number){
    
        $this->db->select(TBL_FINISHED_GOODS.'.name,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_qty,'.TBL_FINISHED_GOODS.'.net_weight as net_weightfg');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
    }

    public function getVendorPonumberbyVendorid($supplier_name){
        $this->db->select('*');
        // $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.vendor_name', $supplier_name);
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number !=',"");
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function getPreviousincomingdetails(){
        $this->db->select('incoming_details_id');
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_INCOMING_DETAILS.'.id','DESC');
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $rowcount = $query->result_array();
        return $rowcount;

    }

    public function getPreviousincomingdetailsforedit($id){
        $this->db->select('*,'.TBL_INCOMING_DETAILS.'.remark as incomig_remark,'.TBL_INCOMING_DETAILS.'.vendor_po_number as venpo');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS.'.vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $this->db->where(TBL_INCOMING_DETAILS.'.id', $id);
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $rowcount = $query->result_array();
        return $rowcount;

    }

    public function checkIfexitsincomingdetails($incoming_no){

        $this->db->select('*');
        $this->db->where(TBL_INCOMING_DETAILS.'.incoming_details_id', $incoming_no);
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function saveIncomingdetails($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_INCOMING_DETAILS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_INCOMING_DETAILS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function deleteIncomingDetails($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_INCOMING_DETAILS)){

            $this->db->where('incoming_details_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_INCOMING_DETAILS_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        //    return TRUE;
        }else{
           return FALSE;
        }

    }

    public function saveIncomingdetailsitem($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_INCOMING_DETAILS_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_INCOMING_DETAILS_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function getAllitemdetails(){

        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id is NULL');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;
    }


    public function getAllitemdetailsforfilter(){

        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id is NULL');
        $this->db->group_by(TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function fetchincomingdeatilsitemlistaddcount($params,$part_number_serach){
        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id is NULL');
        
        if($part_number_serach != 'NA'){
            $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number_serach);
        }

        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function fetchincomingdeatilsitemlistadddata($params,$part_number_serach){
        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id is NULL');
        if($part_number_serach != 'NA'){
          $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number_serach);
        }
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                $data[$counter]['count'] = $counter+1;
                $data[$counter]['part_number'] = $value['part_number'];
                $data[$counter]['name'] = $value['name'];
                $data[$counter]['part_number_with_lot'] = $value['part_number'].' - '.$value['lot_no'];
                $data[$counter]['p_o_qty'] = $value['p_o_qty'];
                $data[$counter]['invoice_qty'] = $value['invoice_qty'];
                $data[$counter]['balance_qty'] = $value['balance_qty'];

                $data[$counter]['invoice_qty_in_kgs'] = $value['invoice_qty_in_kgs'];
                $data[$counter]['invoice_no'] = $value['invoice_no'];
                $data[$counter]['invoice_date'] = $value['invoice_date'];
                
                $data[$counter]['net_weight'] = $value['net_weight'];
                $data[$counter]['challan_no'] = $value['challan_no'];
                $data[$counter]['challan_date'] = $value['challan_date'];
                $data[$counter]['received_date'] = $value['received_date'];
                $data[$counter]['fg_material_gross_weight'] = $value['fg_material_gross_weight'];

                
                $data[$counter]['units'] = $value['units'];
                $data[$counter]['boxex_goni_bundle'] = $value['boxex_goni_bundle'];
                $data[$counter]['remarks'] = $value['remarks'];

                $data[$counter]['action'] = '';

                $data[$counter]['action'] .="<i style='font-size: x-large;cursor: pointer' data-id='".$value['incoming_details_item_id']."' class='fa fa-pencil-square-o editIncomingDetailsitem'  aria-hidden='true'></i>  &nbsp";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer' data-id='".$value['incoming_details_item_id']."' class='fa fa-trash-o deleteIncomingDetailsitem' aria-hidden='true'></i>   &nbsp ";
              
                $counter++; 
            }
        }

        return $data;
    }


    public function getAllitemdetailsforedit($id){

        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id,'.TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id as mainincoming');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$id);
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getPreviousrecordforbalenceqtyedit($incoming_details_item_id,$mainincoming,$part_number){
        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.balance_qty as balance_qty');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id < ',$incoming_details_item_id);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$mainincoming);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number);
        $this->db->order_by(TBL_INCOMING_DETAILS_ITEM.'.id','DESC');
        $this->db->limit('1');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;


    }

    public function getPreviousrecordforbalenceqtyadd($incoming_details_item_id,$part_number){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.balance_qty as balance_qty');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id is NULL');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number);
        //$this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id < ',$incoming_details_item_id);

        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id',$incoming_details_item_id);
        $this->db->order_by(TBL_INCOMING_DETAILS_ITEM.'.id','DESC');
        $this->db->limit('1');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function  get_previous_item_balenace_qty_add($part_number){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.balance_qty as balance_qty');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id is NULL');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number);
        $this->db->order_by(TBL_INCOMING_DETAILS_ITEM.'.id','DESC');
        $this->db->limit('1');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function  get_previous_item_balenace_qty_edit($part_number,$incomingdetail_editid){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.balance_qty as balance_qty');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$incomingdetail_editid);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number);
        $this->db->order_by(TBL_INCOMING_DETAILS_ITEM.'.id','DESC');
        $this->db->limit('1');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function deleteIncomingDetailsitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_INCOMING_DETAILS_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function update_last_inserted_id_incoming_details($last_inserted_id){

        $data = array(
            'incoming_details_id' => $last_inserted_id
        );
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id IS NULL');
        if($this->db->update(TBL_INCOMING_DETAILS_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getPackinginstractionCount(){

        $this->db->select('*');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PACKING_INSTRACTION.".packing_instrauction_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PACKING_INSTRACTION.".buyer_po_date LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);        
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getPackinginstractiondata(){

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_PACKING_INSTRACTION.'.id as packinginstarctionid,'.TBL_BUYER_PO_MASTER.'.id as buyerpoid'); 
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_PACKING_INSTRACTION.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_PACKING_INSTRACTION.'.buyer_po_number');
      
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PACKING_INSTRACTION.".packing_instrauction_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PACKING_INSTRACTION.".buyer_po_date LIKE '%".$params['search']['value']."%')");
        }
      
        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_PACKING_INSTRACTION.'.id','DESC');
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['packing_instrauction_id'] = $value['packing_instrauction_id'];
                $data[$counter]['buyer_name'] = $value['buyer_name_master'];
                $data[$counter]['buyer_po'] = $value['sales_order_number'].' - '.$value['buyer_po_number'];
                $data[$counter]['buyer_po_date'] = $value['buyer_po_date'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editpackinginstraction/".$value['packinginstarctionid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addpackinginstractiondetails/".$value['packinginstarctionid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-plus-circle' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['packinginstarctionid']."' class='fa fa-trash-o deletepackinginstraction' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;


    }

    public function checkIpackinginstraction($packing_instrauction_id){

        $this->db->select('*');
        $this->db->where(TBL_PACKING_INSTRACTION.'.packing_instrauction_id', $packing_instrauction_id);
        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getpreviouspackinginstarction(){

        $this->db->select('packing_instrauction_id,export_id');
        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_PACKING_INSTRACTION.'.id','DESC');
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $rowcount = $query->result_array();
        return $rowcount;


    }

    public function savePackinginstarction($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_PACKING_INSTRACTION, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_PACKING_INSTRACTION, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }


    public function deletepackinginstraction($id){

        // $this->db->where('id', $id);

        // if($this->db->delete(TBL_PACKING_INSTRACTION)){
        //    return TRUE;
        // }else{
        //    return FALSE;
        // }

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_PACKING_INSTRACTION)){

            $this->db->where('packing_instract_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_PACKING_INSTRACTION_DETAILS)){
               return TRUE;
            }else{
               return FALSE;
            }
        //    return TRUE;
        }else{
           return FALSE;
        }

    }


    public function getbuyeritemdetails($buyer_po_number){
        
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as item_details,'.TBL_BUYER_PO_MASTER_ITEM.'.id as poitemid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id');
        $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
        $query = $this->db->get(TBL_BUYER_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;


    }


    public function getdetailsofpackinginsraction($packinginstractionid){

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_PACKING_INSTRACTION.'.id as packinginstarctionid,'.TBL_BUYER_PO_MASTER.'.id as buyerpoid,'.TBL_PACKING_INSTRACTION.'.buyer_po_number,'.TBL_BUYER_PO_MASTER.'.buyer_po_number as buyerponumber'); 
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_PACKING_INSTRACTION.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.buyer_name_id = '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->where(TBL_PACKING_INSTRACTION.'.id', $packinginstractionid);
        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $fetch_result = $query->result_array();

        return $fetch_result;


    }


    public function getpackinginstarction_data_by_id($packinginstarctionid){

        $this->db->select(TBL_PACKING_INSTRACTION.'.id as main_id,'.TBL_BUYER_PO_MASTER.'.id as buyerpoid'); 
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_PACKING_INSTRACTION.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.buyer_name_id = '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->where(TBL_PACKING_INSTRACTION.'.id', $packinginstarctionid);
        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $fetch_result = $query->result_array();

        return $fetch_result;
    }


    public function savePackinginstarctiondetails($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_PACKING_INSTRACTION_DETAILS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_PACKING_INSTRACTION_DETAILS, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
        
    }


    public function getpackingdetails_itemdetails($main_id){

        $this->db->select('*,'.TBL_PACKING_INSTRACTION_DETAILS.'.id as packing_instaction_details'); 
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_PACKING_INSTRACTION_DETAILS.'.part_number');
        $this->db->where(TBL_PACKING_INSTRACTION_DETAILS.'.packing_instract_id', $main_id);
        $this->db->where(TBL_PACKING_INSTRACTION_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_PACKING_INSTRACTION_DETAILS);
        $fetch_result = $query->result_array();

        return $fetch_result;

    }
    


    public function deletepackinginstractionsubitem($id){
       
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_PACKING_INSTRACTION_DETAILS)){
           return TRUE;
        }else{
           return FALSE;
        }
    }


    public function fetchAllincomingdetailsList(){

        $this->db->select('*');
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $data = $query->result_array();
        return $data;

    }


    public function saveBillofmaterialitamdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_BILL_OF_MATERIAL_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_BILL_OF_MATERIAL_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function update_last_inserted_Bill_of_material($saveBillofmaterial){

        $data = array(
            'bom_id' => $saveBillofmaterial
        );
        $this->db->where(TBL_BILL_OF_MATERIAL_ITEM.'.bom_id IS NULL');
        if($this->db->update(TBL_BILL_OF_MATERIAL_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }


    public function fetchALLpreBillofmaterailist(){


        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as supplierrate,'.TBL_FINISHED_GOODS.'.groass_weight as fg_gross_weight,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;



        $this->db->select('*,'.TBL_FINISHED_GOODS.'.part_number,'.TBL_FINISHED_GOODS.'.name as description,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as order_oty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.rm_actual_aty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_supplier_name,'
        .TBL_RAWMATERIAL.'.sitting_size,'
        .TBL_RAWMATERIAL.'.diameter,'
        .TBL_RAWMATERIAL.'.thickness,'
        .TBL_RAWMATERIAL.'.hex_a_f,'
        .TBL_FINISHED_GOODS.'.groass_weight,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.expected_qty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.vendor_actual_recived_qty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.net_weight_per_pcs,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.total_neight_weight,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.short_excess,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.scrap_in_kgs,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.actual_scrap_received_in_kgs,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.remark,'
        .TBL_VENDOR_PO_MASTER.'.po_number as vendorponumnber,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_supplier_po_number,'
        .TBL_BUYER_PO_MASTER.'.sales_order_number,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_remark as bom_remark,'
        .TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as rmsupplier_order_qty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.id as biil_of_material_id,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_vendor_name as vendor_biil_of_materil,'
        
        .TBL_RAWMATERIAL.'.type_of_raw_material');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_ITEM.'.pre_buyer_po_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->where(TBL_BILL_OF_MATERIAL_ITEM.'.bom_id is NULL');
        $this->db->group_by(TBL_BILL_OF_MATERIAL_ITEM.'.id');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_ITEM);
        $data = $query->result_array();
        return $data;


    }


    public function fetchALLpreBillofmaterailistedit($billofmaterialid){


        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as supplierrate,'.TBL_FINISHED_GOODS.'.groass_weight as fg_gross_weight,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;



        $this->db->select('*,'.TBL_FINISHED_GOODS.'.part_number,'.TBL_FINISHED_GOODS.'.name as description,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as order_oty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.rm_actual_aty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_supplier_name,'
        .TBL_RAWMATERIAL.'.sitting_size,'
        .TBL_RAWMATERIAL.'.diameter,'
        .TBL_RAWMATERIAL.'.thickness,'
        .TBL_RAWMATERIAL.'.hex_a_f,'
        .TBL_FINISHED_GOODS.'.groass_weight,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.expected_qty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.vendor_actual_recived_qty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.net_weight_per_pcs,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.total_neight_weight,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.short_excess,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.scrap_in_kgs,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.actual_scrap_received_in_kgs,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.remark,'
        .TBL_VENDOR_PO_MASTER.'.po_number as vendorponumnber,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_supplier_po_number,'
        .TBL_BUYER_PO_MASTER.'.sales_order_number,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_remark as bom_remark,'
        .TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as rmsupplier_order_qty,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.id as biil_of_material_id,'
        .TBL_BILL_OF_MATERIAL_ITEM.'.pre_vendor_name as vendor_biil_of_materil,'
        
        .TBL_RAWMATERIAL.'.type_of_raw_material');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_ITEM.'.pre_buyer_po_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->where(TBL_BILL_OF_MATERIAL_ITEM.'.bom_id',$billofmaterialid);
        $this->db->group_by(TBL_BILL_OF_MATERIAL_ITEM.'.id');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_ITEM);
        $data = $query->result_array();
        return $data;


    }



    // public function getExportdetailsCount(){

    //     $this->db->select('*');
    //     $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_EXPORT_DETAILS.'.buyer_name');
    //     $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_EXPORT_DETAILS.'.buyer_po_number');

    //     if($params['search']['value'] != "") 
    //     {
    //         $this->db->where("(".TBL_EXPORT_DETAILS.".export_details_id LIKE '%".$params['search']['value']."%'");
    //         $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
    //         $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
    //         $this->db->or_where(TBL_EXPORT_DETAILS.".buyer_po_date LIKE '%".$params['search']['value']."%')");
    //     }

    //     $this->db->where(TBL_EXPORT_DETAILS.'.status', 1);
    //     $query = $this->db->get(TBL_EXPORT_DETAILS);
    //     $rowcount = $query->num_rows();
    //     return $rowcount;

    // }

    // public function getExportdetailsdata(){

    //     $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_BUYER_PO_MASTER.'.delivery_date,'.TBL_EXPORT_DETAILS.'.id  as export_details_idauto'); 
    //     $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_EXPORT_DETAILS.'.buyer_name');
    //     $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_EXPORT_DETAILS.'.buyer_po_number');

    //     if($params['search']['value'] != "") 
    //     {
    //         $this->db->where("(".TBL_EXPORT_DETAILS.".export_details_id LIKE '%".$params['search']['value']."%'");
    //         $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
    //         $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
    //         $this->db->or_where(TBL_EXPORT_DETAILS.".buyer_po_date LIKE '%".$params['search']['value']."%')");
    //     }

    //     $this->db->where(TBL_EXPORT_DETAILS.'.status', 1);
    //     $this->db->limit($params['length'],$params['start']);
    //     $this->db->order_by(TBL_EXPORT_DETAILS.'.id','DESC');
    //     $query = $this->db->get(TBL_EXPORT_DETAILS);
    //     $fetch_result = $query->result_array();

    //     $data = array();
    //     $counter = 0;
    //     if(count($fetch_result) > 0)
    //     {
    //         foreach ($fetch_result as $key => $value)
    //         {
    //             $data[$counter]['export_details_id'] = $value['export_details_id'];
    //             $data[$counter]['buyer_name'] = $value['buyer_name_master'];
    //             $data[$counter]['buyer_po'] = $value['sales_order_number'];
    //             $data[$counter]['buyer_po_date'] = $value['buyer_po_date'];
    //             $data[$counter]['delivery_date'] = $value['delivery_date'];
    //             $data[$counter]['action'] = '';
    //             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editexportdetails/".$value['export_details_idauto']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
    //             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addExportdetailsitems/".$value['export_details_idauto']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-plus-circle' aria-hidden='true'></i></a>   &nbsp ";
    //             $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['export_details_idauto']."' class='fa fa-trash-o deleteexportdetailsmain' aria-hidden='true'></i>"; 
    //             $counter++; 
    //         }
    //     }

    //     return $data;


    // }



    public function getExportdetailsCount($params){

        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_PACKING_INSTRACTION.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_PACKING_INSTRACTION.'.buyer_po_number');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PACKING_INSTRACTION.".packing_instrauction_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PACKING_INSTRACTION.".buyer_po_date LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);        
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getExportdetailsdata($params){

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_PACKING_INSTRACTION.'.id as packinginstarctionid,'.TBL_BUYER_PO_MASTER.'.id as buyerpoid'); 
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_PACKING_INSTRACTION.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_PACKING_INSTRACTION.'.buyer_po_number');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PACKING_INSTRACTION.".packing_instrauction_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PACKING_INSTRACTION.".buyer_po_date LIKE '%".$params['search']['value']."%')");
        }
      
        $this->db->where(TBL_PACKING_INSTRACTION.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_PACKING_INSTRACTION.'.id','DESC');
        $query = $this->db->get(TBL_PACKING_INSTRACTION);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                // if($value['packing_instrauction_id']){
                  //  $arr = str_split($value['packing_instrauction_id']);
                  
                   // $inrno= "SQID2324".str_pad((int)$counter+1, 4, 0, STR_PAD_LEFT);    
                   // $export_id = $inrno;
                // }else{
                //     $export_id = 'SQID23240001';
                // }

                $data[$counter]['packing_instrauction_id'] =  $value['export_id'];
                $data[$counter]['buyer_name'] = $value['buyer_name_master'];
                $data[$counter]['buyer_po'] = $value['sales_order_number'].' - '.$value['buyer_po_number'];
                $data[$counter]['buyer_po_date'] = $value['buyer_po_date'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewexportdetails/".$value['packinginstarctionid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
                $counter++; 
            }
        }

        return $data;


    }


    public function getpreviousexportdetailsinstarction(){

        $this->db->select('export_details_id');
        $this->db->where(TBL_EXPORT_DETAILS.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_EXPORT_DETAILS.'.id','DESC');
        $query = $this->db->get(TBL_EXPORT_DETAILS);
        $rowcount = $query->result_array();
        return $rowcount;


    }


    public function checkExportdetailsalredayexits($export_id_number){

        $this->db->select('*');
        $this->db->where(TBL_EXPORT_DETAILS.'.export_details_id', $export_id_number);
        $this->db->where(TBL_EXPORT_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_EXPORT_DETAILS);
        $rowcount = $query->num_rows();
        return $rowcount;

    }


    public function saveExportdetails($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_EXPORT_DETAILS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_EXPORT_DETAILS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    
    }


    public function getexportdetailsforedit($export_details_id){

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_EXPORT_DETAILS.'.id as exportdetails_id,'.TBL_BUYER_PO_MASTER.'.id as buyerpoid'); 
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_EXPORT_DETAILS.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.buyer_name_id = '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->where(TBL_EXPORT_DETAILS.'.id', $export_details_id);
        $this->db->where(TBL_EXPORT_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_EXPORT_DETAILS);
        $fetch_result = $query->result_array();

        return $fetch_result;

    }


    public function deleteexportdetailsmain($id){

        

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_EXPORT_DETAILS)){

            // $this->db->where('incoming_details_id', $id);
            // //$this->db->delete(TBL_SUPPLIER);
            // if($this->db->delete(TBL_INCOMING_DETAILS_ITEM)){
            //    return TRUE;
            // }else{
            //    return FALSE;
            // }
        return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getexportdetailsbyid($main_id){

        $this->db->select(TBL_EXPORT_DETAILS.'.id as main_id,'.TBL_BUYER_PO_MASTER.'.id as buyerpoid'); 
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_EXPORT_DETAILS.'.buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.buyer_name_id = '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->where(TBL_EXPORT_DETAILS.'.id', $main_id);
        $this->db->where(TBL_EXPORT_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_EXPORT_DETAILS);
        $fetch_result = $query->result_array();

        return $fetch_result;
    }

    public function getbuyeramdpackgindetails($exportdetailsid,$part_number){
        // $this->db->select('buyer_po_date,delivery_date');
        // $this->db->where(TBL_BUYER_PO_MASTER.'.status',1);
        // $this->db->where(TBL_BUYER_PO_MASTER.'.id',$buyer_po_number);
        // $query = $this->db->get(TBL_BUYER_PO_MASTER);
        // $data = $query->result_array();
        // return $data;

        $this->db->select('buyer_po_date,delivery_date');
        $this->db->where(TBL_BUYER_PO_MASTER.'.status',1);
        $this->db->where(TBL_BUYER_PO_MASTER.'.id',$buyer_po_number);
        $query = $this->db->get(TBL_BUYER_PO_MASTER);
        $data = $query->result_array();
        return $data;


    }


    public function deleteVendorpoitemedit($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_VENDOR_PO_MASTER_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }


    public function getBuyerDetailsBysupplierponumberforbuyer($supplier_po_number){

        $this->db->select(TBL_BUYER_MASTER.'.*,'.TBL_BUYER_MASTER.'.buyer_name as buyer,'.TBL_SUPPLIER_PO_MASTER.'.*,'.TBL_BUYER_PO_MASTER.'.*');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_MASTER.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_SUPPLIER_PO_MASTER.'.buyer_name');
		$this->db->where(TBL_SUPPLIER_PO_MASTER.'.id', $supplier_po_number);
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.status', 1);
        $query_result = $this->db->get(TBL_SUPPLIER_PO_MASTER)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }


    public function getalljobworkdetails($jobworkid){
        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER.'.supplier_name as supplier_name_sup,'.TBL_JOB_WORK.'.vendor_po_number as pre_vendor_po,'.TBL_JOB_WORK.'.remark as jobwork_remark,'.TBL_JOB_WORK.'.date as job_work_date');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_JOB_WORK.'.vendor_po_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_JOB_WORK.'.raw_material_supplier');
        $this->db->where(TBL_JOB_WORK.'.status',1);
        $this->db->where(TBL_JOB_WORK.'.id',$jobworkid);
        $query = $this->db->get(TBL_JOB_WORK);
        $data = $query->result_array();
        return $data;
    }


    public function fetchALLprejobworkitemListedit($jobworkid){
        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER.'.supplier_name as rowmaterialsuppliername,'.TBL_JOB_WORK_ITEM.'.id as jobworkid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_JOB_WORK_ITEM.'.part_number_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_JOB_WORK_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_JOB_WORK_ITEM.'.pre_raw_material_supplier_name','left');
        $this->db->where(TBL_JOB_WORK_ITEM.'.jobwork_id', $jobworkid);
        $this->db->order_by(TBL_JOB_WORK_ITEM.'.id','desc');
        $query = $this->db->get(TBL_JOB_WORK_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function saveScrapreturn($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_SCRAP_RETURN, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_SCRAP_RETURN, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function getScrapreturncount($params){

        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SCRAP_RETURN.'.vendor_id');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_SCRAP_RETURN.'.supplier_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SCRAP_RETURN.".challan_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SCRAP_RETURN.".challan_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_SCRAP_RETURN.'.status', 1);        
        $query = $this->db->get(TBL_SCRAP_RETURN);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getScrapreturndata($params){

        $this->db->select('*,'.TBL_SCRAP_RETURN.'.id as scrapretrunid'); 
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SCRAP_RETURN.'.vendor_id');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_SCRAP_RETURN.'.supplier_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_SCRAP_RETURN.".challan_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SCRAP_RETURN.".challan_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%')");
        }
      
        $this->db->where(TBL_SCRAP_RETURN.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_SCRAP_RETURN.'.id','DESC');
        $query = $this->db->get(TBL_SCRAP_RETURN);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['challan_id'] = $value['challan_id'];
                $data[$counter]['challan_date'] = $value['challan_date'];
                $data[$counter]['vendor_name'] = $value['vendor_name'];
                $data[$counter]['supplier_name'] = $value['supplier_name'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editscrapreturn/".$value['scrapretrunid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['scrapretrunid']."' class='fa fa-trash-o deletescrapreturn' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

        return $data;
    }

    public function deletescrapreturn($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_SCRAP_RETURN)){

            $this->db->where('scrap_return_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_SCRAP_RETURN_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        //    return TRUE;
        }else{
           return FALSE;
        }
    }

    public function  saveNewscrapreturn($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_SCRAP_RETURN_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_SCRAP_RETURN_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function fetchALLprescrapreturndetails(){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supliername,'.TBL_VENDOR.'.vendor_name vendorname,'.TBL_SCRAP_RETURN_ITEM.'.id as scrapreturnid');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_SCRAP_RETURN_ITEM.'.pre_supplier_name','left');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SCRAP_RETURN_ITEM.'.pre_vendor_name','left');
        $this->db->where(TBL_SCRAP_RETURN_ITEM.'.scrap_return_id Is NULL');
        $this->db->order_by(TBL_SCRAP_RETURN_ITEM.'.id','desc');
        $query = $this->db->get(TBL_SCRAP_RETURN_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function deletescrapreturnitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_SCRAP_RETURN_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function update_last_inserted_id_scarp_retuns($last_inserted_id){

            $data = array(
                'scrap_return_id' => $last_inserted_id
            );
            $this->db->where(TBL_SCRAP_RETURN_ITEM.'.scrap_return_id IS NULL');
            if($this->db->update(TBL_SCRAP_RETURN_ITEM,$data)){
                return TRUE;
            }else{
                return FALSE;
            }
        
    }

    public function getScrapreturndetails($scrapreturnid){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supliername,'.TBL_VENDOR.'.vendor_name vendorname');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_SCRAP_RETURN.'.supplier_id','left');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SCRAP_RETURN.'.vendor_id','left');
        $this->db->where(TBL_SCRAP_RETURN.'.status',1);
        $this->db->where(TBL_SCRAP_RETURN.'.id',$scrapreturnid);
        $query = $this->db->get(TBL_SCRAP_RETURN);
        $data = $query->result_array();
        return $data;

    }

    public function fetchALLprescrapreturndetailsforview($scrapreturnid){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supliername,'.TBL_VENDOR.'.vendor_name vendorname,'.TBL_SCRAP_RETURN_ITEM.'.id as scrapreturnid');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_SCRAP_RETURN_ITEM.'.pre_supplier_name','left');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SCRAP_RETURN_ITEM.'.pre_vendor_name','left');
        $this->db->where(TBL_SCRAP_RETURN_ITEM.'.scrap_return_id',$scrapreturnid);
        $this->db->order_by(TBL_SCRAP_RETURN_ITEM.'.id','desc');
        $query = $this->db->get(TBL_SCRAP_RETURN_ITEM);
        $data = $query->result_array();
        return $data;

    }
    
    public function getpriviousscrpareturn(){
        $this->db->select('challan_id');
        $this->db->where(TBL_SCRAP_RETURN.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_SCRAP_RETURN.'.id','DESC');
        $query = $this->db->get(TBL_SCRAP_RETURN);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function getallcurrentstatusorder($vendor_name,$status){

        $this->db->select(array('bom_number', 
        TBL_BUYER_MASTER.'.buyer_name', 
        TBL_BUYER_PO_MASTER.'.sales_order_number',
        TBL_BUYER_PO_MASTER.'.buyer_po_date',
        TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.buyer_order_qty as buyer_order_qty',
        TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_delivery_date as buyer_delivery_date',
        '"NA" as raw_material_supplier,
         "NA" as type_of_raw_material,
         "NA" as gross_weight_per_pcs_in_Kgs,
         "Vendor Bill Of Material" as form_name,
         "NA" as raw_material_order_qty,
         "NA" as raw_material_actual_recd_qty,
         "NA" as expected_qty,'.
         TBL_VENDOR.'.vendor_name as vendor',
         TBL_VENDOR_PO_MASTER.'.po_number as vendor_po',
         TBL_VENDOR_PO_MASTER.'.date as vendor_po_date',
         TBL_FINISHED_GOODS.'.part_number as part_number',
         TBL_FINISHED_GOODS.'.name as part_decription',
         TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_order_qty as vendor_order_qty',
         TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_received_qty as vendor_received_qty',   
         TBL_FINISHED_GOODS.'.net_weight as net_Weight_per_pcs_in_kgs',
         TBL_BILL_OF_MATERIAL_VENDOR.'.date as vendor_delivery_date',
         TBL_BILL_OF_MATERIAL_VENDOR.'.bom_status as bom_status',
         TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.item_remark as item_remark'));

        if($vendor_name!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name', $vendor_name); 
        }
                        
        if($status!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.bom_status', $status); 
        }

        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_po_number= '.TBL_BUYER_PO_MASTER.'.id');
        $this->db->join(TBL_BUYER_MASTER, TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_name= '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->join(TBL_BILL_OF_MATERIAL_VENDOR_ITEM, TBL_BILL_OF_MATERIAL_VENDOR.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id= '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->from(TBL_BILL_OF_MATERIAL_VENDOR);
        $query_1 = $this->db->get();
        $result_1 = $query_1->result_array();


        $this->db->select(array('bom_number', 
           TBL_BUYER_MASTER.'.buyer_name', 
           TBL_BUYER_PO_MASTER.'.sales_order_number',
           TBL_BUYER_PO_MASTER.'.buyer_po_date', 
           TBL_BUYER_PO_MASTER_ITEM.'.order_oty as buyer_order_qty', 
        //    '" " as buyer_order_qty',
           TBL_BILL_OF_MATERIAL.'.buyer_delivery_date as buyer_delivery_date',
           TBL_SUPPLIER.'.supplier_name as raw_material_supplier',
           TBL_FINISHED_GOODS.'.name as type_of_raw_material',
           TBL_FINISHED_GOODS.'.groass_weight as gross_weight_per_pcs_in_Kgs',
           '"Bill Of Material" as form_name,'.
           TBL_VENDOR.'.vendor_name as vendor',
           TBL_VENDOR_PO_MASTER.'.po_number as vendor_po',
           TBL_VENDOR_PO_MASTER.'.date as vendor_po_date',
           TBL_FINISHED_GOODS.'.part_number as part_number',
           TBL_FINISHED_GOODS.'.name as part_decription',
            TBL_BILL_OF_MATERIAL_ITEM.'.rm_actual_aty as vendor_order_qty',
           TBL_BILL_OF_MATERIAL_ITEM.'.vendor_actual_recived_qty as vendor_received_qty',   
           TBL_FINISHED_GOODS.'.net_weight as net_Weight_per_pcs_in_kgs',
           TBL_BILL_OF_MATERIAL.'.date as vendor_delivery_date',
           TBL_BILL_OF_MATERIAL.'.bom_status as bom_status',
           TBL_BILL_OF_MATERIAL_ITEM.'.remark as item_remark',
           TBL_BILL_OF_MATERIAL_ITEM.'.expected_qty as expected_qty',
           TBL_BILL_OF_MATERIAL_ITEM.'.rm_actual_aty as raw_material_actual_recd_qty',
           TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as raw_material_order_qty',
        ));

         if($vendor_name!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL.'.vendor_name', $vendor_name); 
        }
                        
        if($status!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL.'.bom_status', $status); 
        }

        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL.'.vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BILL_OF_MATERIAL.'.buyer_po_number= '.TBL_BUYER_PO_MASTER.'.id');
        $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id= '.TBL_BUYER_PO_MASTER.'.id');
        $this->db->join(TBL_BUYER_MASTER, TBL_BILL_OF_MATERIAL.'.buyer_name= '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id= '.TBL_VENDOR_PO_MASTER.'.supplier_po_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id= '.TBL_SUPPLIER_PO_MASTER.'.supplier_name');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id= '.TBL_VENDOR_PO_MASTER.'.supplier_po_number');
        $this->db->join(TBL_BILL_OF_MATERIAL_ITEM, TBL_BILL_OF_MATERIAL_ITEM.'.bom_id= '.TBL_BILL_OF_MATERIAL.'.id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_BILL_OF_MATERIAL_ITEM.'.part_number= '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->from(TBL_BILL_OF_MATERIAL);
        $query_2 = $this->db->get();
        $result_2 = $query_2->result_array();

        $array_mearge = array_merge($result_1,$result_2);

        return $array_mearge;



    }

    public function fetchcurrentorderstatusreportcount($params,$vendor_name,$status){

        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_name= '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->join(TBL_BILL_OF_MATERIAL_VENDOR_ITEM, TBL_BILL_OF_MATERIAL_VENDOR.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id= '.TBL_FINISHED_GOODS.'.fin_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL_VENDOR.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".part_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1); 
        

        if($vendor_name!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name', $vendor_name); 
        }

        if($status!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.bom_status', $status); 
        }
        
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function fetchcurrentorderstatusreportdata($params,$vendor_name,$status){

        /* Vendor Bill of material Data */
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_BILL_OF_MATERIAL_VENDOR.'.id as billofmaterialid,'.TBL_FINISHED_GOODS.'.part_number as partno,'.TBL_BUYER_MASTER.'.buyer_name as buyer,1 as flag,'.TBL_BILL_OF_MATERIAL_VENDOR.'.bom_status,'.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_order_qty as vendor_order_qty_co,'.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_received_qty as vendor_received_qty_co');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_name= '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->join(TBL_BILL_OF_MATERIAL_VENDOR_ITEM, TBL_BILL_OF_MATERIAL_VENDOR.'.id= '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id= '.TBL_FINISHED_GOODS.'.fin_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL_VENDOR.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL_VENDOR.".part_number LIKE '%".$params['search']['value']."%')");
        }

        if($vendor_name!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name', $vendor_name); 
        }

        if($status!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.bom_status', $status); 
        }

        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR.'.id','DESC');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        // $fetch_result = $query->result_array();
        $query1 = $query->result_array();




        /* Bill of material Data */
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_BILL_OF_MATERIAL.'.id as billofmaterialid,'.TBL_FINISHED_GOODS.'.part_number as partno,'.TBL_BUYER_MASTER.'.buyer_name as buyer, 2 as flag,'.TBL_BILL_OF_MATERIAL.'.bom_status,'.TBL_BILL_OF_MATERIAL_ITEM.'.rm_actual_aty as vendor_order_qty_co,'.TBL_BILL_OF_MATERIAL_ITEM.'.vendor_actual_recived_qty as vendor_received_qty_co');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id= '.TBL_BILL_OF_MATERIAL.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id= '.TBL_BILL_OF_MATERIAL.'.vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BILL_OF_MATERIAL.'.buyer_name= '.TBL_BUYER_MASTER.'.buyer_id');
        $this->db->join(TBL_BILL_OF_MATERIAL_ITEM, TBL_BILL_OF_MATERIAL.'.id= '.TBL_BILL_OF_MATERIAL_ITEM.'.bom_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_BILL_OF_MATERIAL_ITEM.'.part_number= '.TBL_FINISHED_GOODS.'.fin_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_BILL_OF_MATERIAL.".bom_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".bom_status LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BILL_OF_MATERIAL.".part_number LIKE '%".$params['search']['value']."%')");
        }

        if($vendor_name!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL.'.vendor_name', $vendor_name); 
        }

        if($status!='NA'){
            $this->db->where(TBL_BILL_OF_MATERIAL.'.bom_status', $status); 
        }

        $this->db->where(TBL_BILL_OF_MATERIAL.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_BILL_OF_MATERIAL.'.id','DESC');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        // $fetch_result = $query->result_array();
        $query2 = $query->result_array();

        
        $fetch_result =   array_merge($query1, $query2);
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['bom_number'] = $value['bom_number'];
                $data[$counter]['date'] = $value['date'];
                $data[$counter]['fg_part_number'] = $value['partno'];
                $data[$counter]['vendor_order_qty'] = $value['vendor_order_qty_co'];
                $data[$counter]['vendor_received_qty'] = $value['vendor_received_qty_co'];
                $data[$counter]['buyer_name'] = $value['buyer'];
               
                $data[$counter]['status'] = $value['bom_status'];

                  if($value['flag']==1){
                    $flag = 'Vendor Bill of Material';
                   }else{
                    $flag = 'Bill of Material';
                   }
                $data[$counter]['flag'] = $flag;
                $counter++; 
            }
        }

        return $data;
    }

    public function saveNewreworkrejection($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_REWORK_REJECTION, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_REWORK_REJECTION, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function getreworkrejectioncount($params){

        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_REWORK_REJECTION.'.vendor_name','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_REWORK_REJECTION.'.supplier_name','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_REWORK_REJECTION.".challan_no LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REWORK_REJECTION.".challan_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_REWORK_REJECTION.'.status', 1); 
    
        $query = $this->db->get(TBL_REWORK_REJECTION);
        $rowcount = $query->num_rows();
        return $rowcount;


    }

    public function getreworkrejectiondata($params){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_REWORK_REJECTION.'.id as reworkrejectionid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_REWORK_REJECTION.'.vendor_name','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_REWORK_REJECTION.'.supplier_name','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION.'.vendor_po_number','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION.'.supplier_po_number','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_REWORK_REJECTION.".challan_no LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REWORK_REJECTION.".challan_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_REWORK_REJECTION.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_REWORK_REJECTION.'.id','DESC');
        $query = $this->db->get(TBL_REWORK_REJECTION);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['challan_no'] = $value['challan_no'];
                $data[$counter]['challan_date'] = $value['challan_date'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['vendor_pomaster'];
                $data[$counter]['supplier_name'] = $value['supplier'];
                $data[$counter]['supplier_po_number'] = $value['supplier_master'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editreworkrejection/".$value['reworkrejectionid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['reworkrejectionid']."' class='fa fa-trash-o deletereworkrejection' aria-hidden='true'></i>"; 

                $counter++; 
            }
        }

        return $data;

    }

    public function deletereworkrejection($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_REWORK_REJECTION)){

            $this->db->where('rework_rejection_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_REWORK_REJECTION_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
           return TRUE;
        }else{
           return FALSE;
        }


    }

    public function getPreviousReworkreturnnumber(){

        $this->db->select('challan_no');
        $this->db->where(TBL_REWORK_REJECTION.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_REWORK_REJECTION.'.id','DESC');
        $query = $this->db->get(TBL_REWORK_REJECTION);
        $rowcount = $query->result_array();
        return $rowcount;

    }

    public function getReworkrejectiondetails($id){


        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_master,'.TBL_REWORK_REJECTION.'.id as reworkrejectionid,'.TBL_REWORK_REJECTION.'.vendor_po_number as vendor_po_rework,'.TBL_REWORK_REJECTION.'.supplier_po_number as rejection_supplier_po,'.TBL_REWORK_REJECTION.'.supplier_name as reworksupplier,'.TBL_REWORK_REJECTION.'.remark as rejectionremark,'.TBL_REWORK_REJECTION.'.vendor_name as venorselected');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_REWORK_REJECTION.'.vendor_name','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_REWORK_REJECTION.'.supplier_name','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION.'.vendor_po_number','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION.'.supplier_po_number','left');
        $this->db->where(TBL_REWORK_REJECTION.'.status', 1);
        $this->db->where(TBL_REWORK_REJECTION.'.id', $id);
        $query = $this->db->get(TBL_REWORK_REJECTION);
        $fetch_result = $query->result_array();

        return $fetch_result;

    }

    public function getbuyerpodetailsforvendorbillofmaterial($vendor_po_number){

        $this->db->select(TBL_BUYER_MASTER.'.*,'.TBL_BUYER_MASTER.'.buyer_name as buyer');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_number);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $query_result = $this->db->get(TBL_VENDOR_PO_MASTER)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }

    public function getBuyerDetailsByvendorpoautofill($vendor_po_number){

        $this->db->select(TBL_BUYER_PO_MASTER.'.*');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_number);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $query_result = $this->db->get(TBL_VENDOR_PO_MASTER)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }

    public function getIncomingDetailsofbillofmaterial($vendor_po_number){

        $this->db->select(TBL_INCOMING_DETAILS.'.*');
        $this->db->where(TBL_INCOMING_DETAILS.'.vendor_po_number', $vendor_po_number);
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $query_result = $this->db->get(TBL_INCOMING_DETAILS)->result_array();
		foreach($query_result as $key => $value) {
			$query_result[$key]['selected'] = '';
		}
        return $query_result;

    }

    public function getSuppliergoodsreworkrejectionvendor($part_number,$vendor_po_number){


        $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);
        if($check_if_supplier_exist['supplier_po_number']){
    
            // $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->where(TBL_RAWMATERIAL.'.status',1);
            // // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            // $query = $this->db->get(TBL_RAWMATERIAL);
            // $data = $query->result_array();
            // return $data;
    
            // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $query = $this->db->get(TBL_FINISHED_GOODS);
            // $data = $query->result_array();
            // return $data;
    
            
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
          
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
              $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;
    
    
    
        }else{
    
            // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $query = $this->db->get(TBL_FINISHED_GOODS);
            // $data = $query->result_array();
            // return $data;
    
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            //$this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;

        }

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;
        

    }

    public function getSuppliergoodsreworkrejectionsupplier($part_number,$vendor_po_number,$supplier_po_number,$flag){



        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.rate as supplierrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as supplier_order_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

     
            // $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.rate as supplierrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as supplier_order_qty');
            // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
            // $this->db->where(TBL_RAWMATERIAL.'.status',1);
            // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            // $query = $this->db->get(TBL_RAWMATERIAL);
            // $data = $query->result_array();
            // return $data;


            $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.rate as supplierrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as name,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as supplier_order_qty,'.TBL_RAWMATERIAL.'.HSN_code as hsn_code');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id');
           // $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
            $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
            $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            $query = $this->db->get(TBL_SUPPLIER_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;



    }

    public function savereworkrejectionitemdetails($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_REWORK_REJECTION_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_REWORK_REJECTION_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }

    }

    public function getReworkRejectionitemslist(){

        $this->db->select(TBL_VENDOR_PO_MASTER.'.supplier_po_number,'.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_supplier_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id IS NULL');
        $query_vendor_po = $this->db->get(TBL_REWORK_REJECTION_ITEM);
        $query_vendor_data = $query_vendor_po->row_array();

        if($query_vendor_data['pre_vendor_supplier_name']=='vendor'){

                if($query_vendor_data['supplier_po_number']){

                    $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description1,'.TBL_FINISHED_GOODS.'.fin_id as raw_id');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id IS NULL');
                    $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                    $data = $query->result_array();
                    return $data;
                }else{


                    $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description1,'.TBL_FINISHED_GOODS.'.fin_id as raw_id');
                    //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id IS NULL');
                    $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                    $data = $query->result_array();
                    return $data;

                }

        }else{


            $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description1');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
            //$this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
            $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
            $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
            $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id IS NULL');
            $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
            $data = $query->result_array();
            return $data;


        }

    }

    public function deleteReworkRejectionitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_REWORK_REJECTION_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function update_last_inserted_id_rework_rejection($saveNewreworkrejection){

        $data = array(
            'rework_rejection_id' => $saveNewreworkrejection
        );
        $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id IS NULL');
        if($this->db->update(TBL_REWORK_REJECTION_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getReworkRejectionitemslistforedit($id){

        // $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
        // $this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
        // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
        // $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
        // $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id',$id);
        // $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
        // $data = $query->result_array();
        // return $data;

        $this->db->select(TBL_VENDOR_PO_MASTER.'.supplier_po_number,'.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_supplier_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id',$id);
        $query_vendor_po = $this->db->get(TBL_REWORK_REJECTION_ITEM);
        $query_vendor_data = $query_vendor_po->row_array();

        if($query_vendor_data['pre_vendor_supplier_name']=='vendor'){

                if($query_vendor_data['supplier_po_number']){

                    $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description1,'.TBL_FINISHED_GOODS.'.fin_id as raw_id');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id',$id);
                    $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                    $data = $query->result_array();
                    return $data;
                }else{


                    $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description1,'.TBL_FINISHED_GOODS.'.fin_id as raw_id');
                    //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
                    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id',$id);
                    $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                    $data = $query->result_array();
                    return $data;

                }

        }else{


            $this->db->select('*,'.TBL_REWORK_REJECTION_ITEM.'.id as reworkrejectionid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description1');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
            //$this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_vendor_po_number','left');
            $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_REWORK_REJECTION_ITEM.'.pre_supplier_po_number','left');
            $this->db->where(TBL_REWORK_REJECTION_ITEM.'.status',1);
            $this->db->where(TBL_REWORK_REJECTION_ITEM.'.rework_rejection_id',$id);
            $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
            $data = $query->result_array();
            return $data;


        }

    }

    public function getchallanformcount($params){

        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_CHALLAN_FORM.'.vendor_name','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_CHALLAN_FORM.'.supplier_name','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_CHALLAN_FORM.".challan_no LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_CHALLAN_FORM.".challan_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_CHALLAN_FORM.'.status', 1); 
    
        $query = $this->db->get(TBL_CHALLAN_FORM);
        $rowcount = $query->num_rows();
        return $rowcount;


    }

    public function getchallanformdata($params){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_CHALLAN_FORM.'.challan_id  as challan_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_CHALLAN_FORM.'.vendor_name','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_CHALLAN_FORM.'.supplier_name','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM.'.vendor_po_number','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM.'.supplier_po_number','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_CHALLAN_FORM.".challan_no LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_CHALLAN_FORM.".challan_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_CHALLAN_FORM.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_CHALLAN_FORM.'.challan_id','DESC');
        $query = $this->db->get(TBL_CHALLAN_FORM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['challan_no'] = $value['challan_no'];
                $data[$counter]['challan_date'] = $value['challan_date'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['vendor_pomaster'];
                $data[$counter]['supplier_name'] = $value['supplier'];
                $data[$counter]['supplier_po_number'] = $value['supplier_master'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editchallanform/".$value['challan_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['challan_id']."' class='fa fa-trash-o deletechallanform' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function getPreviousChallanform_number(){
        $this->db->select('challan_no');
        $this->db->where(TBL_CHALLAN_FORM.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_CHALLAN_FORM.'.challan_id','DESC');
        $query = $this->db->get(TBL_CHALLAN_FORM);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function savechallanformdetails($id,$data){

        if($id != '') {
            $this->db->where('challan_id', $id);
            if($this->db->update(TBL_CHALLAN_FORM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_CHALLAN_FORM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }

    }

    public function deletechallanform($id){

        $this->db->where('challan_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_CHALLAN_FORM)){

            $this->db->where('challan_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_CHALLAN_FORM)){
               return TRUE;
            }else{
               return FALSE;
            }
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function savechallanformitemdetails($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_CHALLAN_FORM_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_CHALLAN_FORM_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }

    public function getChallanformlist(){

        // $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
        // // $this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');

        // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
        // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
        // $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
        // $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id IS NULL');
        // $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
        // $data = $query->result_array();
      

        // if(count($data) > 0)
        // {
        //     return $data;
        // }else{

        //     $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description');
        //     // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
        //     // $this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        //    // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
        //     $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
        //     $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
        //     $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
        //     $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
        //     $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id IS NULL');
        //     $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
        //     $data2 = $query->result_array();

        //     return $data2;
        
        // }


        
        $this->db->select(TBL_VENDOR_PO_MASTER.'.supplier_po_number,'.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_supplier_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id IS NULL');
        $query_vendor_po = $this->db->get(TBL_CHALLAN_FORM_ITEM);
        $query_vendor_data = $query_vendor_po->row_array();

        if($query_vendor_data['pre_vendor_supplier_name']=='vendor'){

                if($query_vendor_data['supplier_po_number']){

                

                    //$this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description1');
                    $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_FINISHED_GOODS.'.name as description1');

                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    //$this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            
                    // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
                    // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id IS NULL');
                    $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                    $data = $query->result_array();
                    return $data;


                }else{

                
                    $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description1');
                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    //$this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id IS NULL');
                    $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                    $data = $query->result_array();
                    return $data;

                }
            
        }else{

          

            $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description1');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
            // $this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
           // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
            $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
            $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
            $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id',$challan_id);
            $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
            $data2 = $query->result_array();
            return $data2;

        }

    }

    public function update_last_inserted_id_challan_form($saveNewchallan){
        $data = array(
            'challan_id' => $saveNewchallan
        );
        $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id IS NULL');
        if($this->db->update(TBL_CHALLAN_FORM_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getChallanformdetails($id){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_master,'.TBL_CHALLAN_FORM.'.challan_id as challan_id,'.TBL_CHALLAN_FORM.'.vendor_po_number as vendor_po_rework,'.TBL_CHALLAN_FORM.'.supplier_po_number as rejection_supplier_po,'.TBL_CHALLAN_FORM.'.supplier_name as reworksupplier,'.TBL_CHALLAN_FORM.'.remark as rejectionremark,'.TBL_CHALLAN_FORM.'.vendor_name as venorselected');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_CHALLAN_FORM.'.vendor_name','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_CHALLAN_FORM.'.supplier_name','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM.'.vendor_po_number','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM.'.supplier_po_number','left');
        $this->db->where(TBL_CHALLAN_FORM.'.status', 1);
        $this->db->where(TBL_CHALLAN_FORM.'.challan_id', $id);
        $query = $this->db->get(TBL_CHALLAN_FORM);
        $fetch_result = $query->result_array();
        return $fetch_result;

    }

    public function getChallanformlistedit($challan_id){


        $this->db->select(TBL_VENDOR_PO_MASTER.'.supplier_po_number,'.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_supplier_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id',$challan_id);
        $query_vendor_po = $this->db->get(TBL_CHALLAN_FORM_ITEM);
        $query_vendor_data = $query_vendor_po->row_array();

        if($query_vendor_data['pre_vendor_supplier_name']=='vendor'){

                if($query_vendor_data['supplier_po_number']){

                

                    //$this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description1');
                    $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_FINISHED_GOODS.'.name as description1');

                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    //$this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            
                    // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
                    // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id',$challan_id);
                    $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                    $data = $query->result_array();
                    return $data;


                }else{

                
                    $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_FINISHED_GOODS.'.name as description1');
                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    //$this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id',$challan_id);
                    $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                    $data = $query->result_array();
                    return $data;

                }
            
        }else{

          

            $this->db->select('*,'.TBL_CHALLAN_FORM_ITEM.'.id as challanformid,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number,'.TBL_RAWMATERIAL.'.type_of_raw_material as description1');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
            // $this->db->join(TBL_FINISHED_GOODS, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
           // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_vendor_po_number','left');
            $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_CHALLAN_FORM_ITEM.'.pre_supplier_po_number','left');
            $this->db->where(TBL_CHALLAN_FORM_ITEM.'.status',1);
            $this->db->where(TBL_CHALLAN_FORM_ITEM.'.challan_id',$challan_id);
            $query = $this->db->get(TBL_CHALLAN_FORM_ITEM);
            $data2 = $query->result_array();
            return $data2;

        }

    }

    public function deleteChallanformitem($id){

        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_CHALLAN_FORM_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getPreviousDebitnote_number(){
        $this->db->select('debit_note_number');
        $this->db->where(TBL_DEBIT_NOTE.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_DEBIT_NOTE.'.debit_id','DESC');
        $query = $this->db->get(TBL_DEBIT_NOTE);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function saveNewdebitnote($id,$data){

        if($id != '') {
            $this->db->where('debit_id', $id);
            if($this->db->update(TBL_DEBIT_NOTE, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_DEBIT_NOTE, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function getdebitnotecount($params){

       
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_DEBIT_NOTE.'.debit_id  as debit_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_DEBIT_NOTE.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_DEBIT_NOTE.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE.'.supplier_po','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_DEBIT_NOTE.".debit_note_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_DEBIT_NOTE.".debit_note_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_DEBIT_NOTE.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_DEBIT_NOTE.'.debit_id','DESC');
        $query = $this->db->get(TBL_DEBIT_NOTE);
        $rowcount = $query->num_rows();
        return $rowcount;


    }

    public function getdebitnotedata($params){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_DEBIT_NOTE.'.debit_id  as debit_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_DEBIT_NOTE.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_DEBIT_NOTE.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE.'.supplier_po','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_DEBIT_NOTE.".debit_note_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_DEBIT_NOTE.".debit_note_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_DEBIT_NOTE.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_DEBIT_NOTE.'.debit_id','DESC');
        $query = $this->db->get(TBL_DEBIT_NOTE);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['debit_note_number'] = $value['debit_note_number'];
                $data[$counter]['debit_note_date'] = $value['debit_note_date'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['vendor_pomaster'];
                $data[$counter]['supplier_name'] = $value['supplier'];
                $data[$counter]['supplier_po_number'] = $value['supplier_master'];
                $data[$counter]['po_date'] = $value['po_date'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editdebitnoteform/".$value['debit_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['debit_id']."' class='fa fa-trash-o deletedebitnote' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function deletedebitnote($id){
        
        $this->db->where('debit_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_DEBIT_NOTE)){
            $this->db->where('debit_note_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_DEBIT_NOTE_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getdebitnoteditailsdata($id){

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_DEBIT_NOTE.'.debit_id  as debit_id,'.TBL_DEBIT_NOTE.'.po_date as debit_po_date,'.TBL_DEBIT_NOTE.'.remark as debit_remark');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_DEBIT_NOTE.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_DEBIT_NOTE.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE.'.supplier_po','left');
        $this->db->where(TBL_DEBIT_NOTE.'.status', 1);
        $this->db->where(TBL_DEBIT_NOTE.'.debit_id',$id);
        $query = $this->db->get(TBL_DEBIT_NOTE);
        $fetch_result = $query->result_array();
        return $fetch_result;

    }

    public function savedebitnoteitemdetails($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_DEBIT_NOTE_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_DEBIT_NOTE_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function update_last_inserted_id_debit_note($saveNewdebitnote){
        $data = array(
            'debit_note_id' =>$saveNewdebitnote
        );

        $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id IS NULL');
        if($this->db->update(TBL_DEBIT_NOTE_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    
    public function update_last_inqulity_record($saveualitydetails){
        $data = array(
            'quality_records_id' =>$saveualitydetails
        );

        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.quality_records_id IS NULL');
        if($this->db->update(TBL_QUALITY_RECORDS_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }


    public function deleteDebitnoteitem($debit_note_id){

        $this->db->where('id', $debit_note_id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_DEBIT_NOTE_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }


    public function getdebitnoteitemdetails(){

        $this->db->select('*,'.TBL_DEBIT_NOTE_ITEM.'.id as debit_note_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_DEBIT_NOTE_ITEM.'.remark as debit_note_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as part_name');
        //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_vendor_po_number','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_supplier_po_number','left');
        $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id IS NULL');
        $query_1 = $this->db->get(TBL_DEBIT_NOTE_ITEM);
        $data_1 = $query_1->result_array();
        //return $data_1;        
    
        if(count($data_1) > 0)
        {
            return $data_1;

        }else{

            $this->db->select('*,'.TBL_DEBIT_NOTE_ITEM.'.id as debit_note_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_DEBIT_NOTE_ITEM.'.remark as debit_note_remark,'.TBL_FINISHED_GOODS.'.name as part_name');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
            //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_vendor_po_number','left');
            $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_supplier_po_number','left');
            $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id IS NULL');
            $query = $this->db->get(TBL_DEBIT_NOTE_ITEM);
            $data= $query->result_array();
            return $data;

        }       

    }

    public function getdebitnoteitemdetailsedit($id){

        // $this->db->select('*,'.TBL_DEBIT_NOTE_ITEM.'.id as debit_note_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_DEBIT_NOTE_ITEM.'.remark as debit_note_remark');
        // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_vendor_po_number','left');
        // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_supplier_po_number','left');
        // $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id',$id);
        // $query = $this->db->get(TBL_DEBIT_NOTE_ITEM);
        // $data = $query->result_array();
        // return $data;


        $this->db->select('*,'.TBL_DEBIT_NOTE_ITEM.'.id as debit_note_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_DEBIT_NOTE_ITEM.'.remark as debit_note_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as part_name');
        //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_vendor_po_number','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_supplier_po_number','left');
        $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id',$id);
        $query_1 = $this->db->get(TBL_DEBIT_NOTE_ITEM);
        $data_1 = $query_1->result_array();
        //return $data_1;        
    
        if(count($data_1) > 0)
        {
            return $data_1;

        }else{

            $this->db->select('*,'.TBL_DEBIT_NOTE_ITEM.'.id as debit_note_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_DEBIT_NOTE_ITEM.'.remark as debit_note_remark,'.TBL_FINISHED_GOODS.'.name as part_name');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
            //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_vendor_po_number','left');
            $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_DEBIT_NOTE_ITEM.'.pre_supplier_po_number','left');
            $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id',$id);
            $query = $this->db->get(TBL_DEBIT_NOTE_ITEM);
            $data= $query->result_array();

            return $data;

        }       


    }

    public function getTotalDebitAndokQty(){


        $this->db->select('sum(debit_amount) as total_debit_amount, sum(SGST_value) as total_SGST_value, sum(CGST_value) as total_CGST_value, sum(IGST_value) as total_IGST_value , sum(total_amount_of_ok_qty_data) as total_amount_of_ok_qty_data,sum(ok_qty) as total_amount_of_ok_qty,sum(p_and_f_charges) as p_and_f_charges');
        $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id IS NULL');
        $query = $this->db->get(TBL_DEBIT_NOTE_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getTotalDebitAndokQtyedit($id){

        $this->db->select('sum(debit_amount) as total_debit_amount, sum(SGST_value) as total_SGST_value, sum(CGST_value) as total_CGST_value, sum(IGST_value) as total_IGST_value , sum(total_amount_of_ok_qty_data) as total_amount_of_ok_qty_data,sum(ok_qty) as total_amount_of_ok_qty,sum(p_and_f_charges) as p_and_f_charges');
        $this->db->where(TBL_DEBIT_NOTE_ITEM.'.debit_note_id',$id);
        $query = $this->db->get(TBL_DEBIT_NOTE_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function getPaymentcount($params){

       
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_PAYMENT_DETAILS.'.payment_details_id  as debit_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_PAYMENT_DETAILS.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_PAYMENT_DETAILS.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_PAYMENT_DETAILS.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_PAYMENT_DETAILS.'.supplier_po','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PAYMENT_DETAILS.".debit_note_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PAYMENT_DETAILS.".debit_note_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_PAYMENT_DETAILS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_PAYMENT_DETAILS);
        $rowcount = $query->num_rows();
        return $rowcount;


    }

    public function getPaymentdata($params){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_PAYMENT_DETAILS.'.payment_details_id as debit_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_PAYMENT_DETAILS.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_PAYMENT_DETAILS.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_PAYMENT_DETAILS.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_PAYMENT_DETAILS.'.supplier_po','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_PAYMENT_DETAILS.".payment_details_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PAYMENT_DETAILS.".payment_details_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_PAYMENT_DETAILS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_PAYMENT_DETAILS.'.payment_details_id','DESC');
        $query = $this->db->get(TBL_PAYMENT_DETAILS);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['payment_details_number'] = $value['payment_details_number'];
                $data[$counter]['payment_details_date'] = $value['payment_details_date'];
                $data[$counter]['type'] = $value['type'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['vendor_pomaster'];
                $data[$counter]['supplier_name'] = $value['supplier'];
                $data[$counter]['supplier_po_number'] = $value['supplier_master'];
                $data[$counter]['po_date'] = $value['po_date'];
                $data[$counter]['payment_status'] = $value['payment_status'];
                $data[$counter]['action'] = '';
                // $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addpaymentdetailsdata/".$value['payment_details_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-plus-circle' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editpaymentdetails/".$value['payment_details_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['payment_details_id']."' class='fa fa-trash-o deletepaymentdetails' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }


    public function getPreviousPaymentdetails_number(){
        $this->db->select('payment_details_number');
        $this->db->where(TBL_PAYMENT_DETAILS.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_PAYMENT_DETAILS.'.payment_details_id','DESC');
        $query = $this->db->get(TBL_PAYMENT_DETAILS);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function saveNewdPaymentDetails($id,$data){

        if($id != '') {
            $this->db->where('payment_details_id', $id);
            if($this->db->update(TBL_PAYMENT_DETAILS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_PAYMENT_DETAILS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function deletepaymentdetails($id){

        $this->db->where('payment_details_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_PAYMENT_DETAILS)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getPaymentdetails($payment_details_id){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_PAYMENT_DETAILS.'.payment_details_id as debit_id,'.TBL_PAYMENT_DETAILS.'.remark as remarkpayment');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_PAYMENT_DETAILS.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_PAYMENT_DETAILS.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_PAYMENT_DETAILS.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_PAYMENT_DETAILS.'.supplier_po','left');
        $this->db->where(TBL_PAYMENT_DETAILS.'.status', 1);
        $query = $this->db->get(TBL_PAYMENT_DETAILS);
        $fetch_result = $query->result_array();
        return $fetch_result;
    }

    public function getpoddetailscount($params){

       
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_POD_DETAILS.'.pod_details_id   as debit_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_POD_DETAILS.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_POD_DETAILS.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_DETAILS.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_DETAILS.'.supplier_po','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_POD_DETAILS.".pod_details_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_POD_DETAILS.".pod_details_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_POD_DETAILS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_POD_DETAILS);
        $rowcount = $query->num_rows();
        return $rowcount;


    }

    public function getpoddetailsdata($params){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as supplier,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_master,'.TBL_POD_DETAILS.'.pod_details_id as debit_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_POD_DETAILS.'.vendor_id','left');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_POD_DETAILS.'.supplier_id','left');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_DETAILS.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_DETAILS.'.supplier_po','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_POD_DETAILS.".pod_details_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_POD_DETAILS.".pod_details_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_SUPPLIER.".supplier_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_POD_DETAILS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_POD_DETAILS.'.pod_details_id','DESC');
        $query = $this->db->get(TBL_POD_DETAILS);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['pod_details_number'] = $value['pod_details_number'];
                $data[$counter]['pod_details_date'] = $value['pod_details_date'];
                $data[$counter]['type'] = $value['type'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['vendor_pomaster'];
                $data[$counter]['supplier_name'] = $value['supplier'];
                $data[$counter]['supplier_po_number'] = $value['supplier_master'];
                $data[$counter]['po_date'] = $value['po_date'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editpoddetails/".$value['pod_details_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['pod_details_id']."' class='fa fa-trash-o deletepoddetails' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function getpoddetailsforedititem($i){

        $this->db->select('pre_vendor_supplier_name');
        $this->db->where(TBL_POD_ITEM.'.POD_id',$i);
        $query = $this->db->get(TBL_POD_ITEM);
        $pre_vendor_supplier_name = $query->result_array();
       
        foreach ($pre_vendor_supplier_name as $key_vendor_supplier_name => $value_vendor_supplier_name) {

            // print_r($value_vendor_supplier_name);
            // exit;

            if($value_vendor_supplier_name['pre_vendor_supplier_name']=='vendor'){

                if($value_vendor_supplier_name['pre_supplier_po_number']){

                    // $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as name');
                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number','left');
                    // //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.part_number = '.TBL_POD_ITEM.'.part_number');
                    // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                    // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                    // $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
                    // $query = $this->db->get(TBL_POD_ITEM);
                    // $data = $query->result_array();
                    // return $data;

                    $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as name');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number');
                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_POD_ITEM.'.POD_id',$i);
                    $query = $this->db->get(TBL_POD_ITEM);
                    $data = $query->result_array();
                    return $data;

                }else{

                    // $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_FINISHED_GOODS.'.name as name');
                    // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number','left');
                    // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_POD_ITEM.'.part_number');
                    // $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                    // $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                    // $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
                    // $query = $this->db->get(TBL_POD_ITEM);
                    // $data = $query->result_array();
                    // return $data;

                    $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_FINISHED_GOODS.'.name as name');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_POD_ITEM.'.part_number');
                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_POD_ITEM.'.POD_id',$i);
                    $query = $this->db->get(TBL_POD_ITEM);
                    $data = $query->result_array();
                    return $data;
                }
                
                
            }else{

                $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as name');
                $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number');
                // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                $this->db->where(TBL_POD_ITEM.'.POD_id',$i);
                $query = $this->db->get(TBL_POD_ITEM);
                $data = $query->result_array();
                return $data;
            }           
        }


        
      
    }


    public function getpoddetailsforedit($i){
     
     
        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_master,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po_number,'.TBL_POD_DETAILS.'.remark as pod_details,'.TBL_POD_DETAILS.'.pod_details_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_DETAILS.'.vendor_po','left');
        $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_DETAILS.'.supplier_po','left');

        $this->db->where(TBL_POD_DETAILS.'.pod_details_id',$i);
        $query = $this->db->get(TBL_POD_DETAILS);
        $data = $query->result_array();
        return $data;
    }


    public function getPreviousPODdetails_number(){
        $this->db->select('pod_details_number');
        $this->db->where(TBL_POD_DETAILS.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_POD_DETAILS.'.pod_details_id','DESC');
        $query = $this->db->get(TBL_POD_DETAILS);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function saveNewdPODDetails($id,$data){

        if($id != '') {
            $this->db->where('pod_details_id', $id);
            if($this->db->update(TBL_POD_DETAILS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_POD_DETAILS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function get_vendorpodata($vendor_po_id){

        $this->db->select(TBL_VENDOR_PO_MASTER.'.date,'.TBL_VENDOR_PO_MASTER.'.supplier_po_number');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_id);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function get_supplierpodata($supplier_po_id){

        $this->db->select(TBL_SUPPLIER_PO_MASTER.'.date');
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.id', $supplier_po_id);
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }

    public function get_vendorpodata_with_debit_data($vendor_po_id,$vendor_supplier_name,$supplier_po_number){

        if($vendor_supplier_name=='vendor'){
            $this->db->select(TBL_DEBIT_NOTE.'.tds_amount,'.TBL_DEBIT_NOTE.'.total_debit_amount,'.TBL_DEBIT_NOTE.'.debit_note_number');
            $this->db->join(TBL_DEBIT_NOTE, TBL_DEBIT_NOTE.'.vendor_po = '.TBL_VENDOR_PO_MASTER.'.id');
            $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_id);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER);
            $data = $query->result_array();
            return $data;
        }else{

            $this->db->select(TBL_DEBIT_NOTE.'.tds_amount,'.TBL_DEBIT_NOTE.'.total_debit_amount,'.TBL_DEBIT_NOTE.'.debit_note_number');
            $this->db->join(TBL_DEBIT_NOTE, TBL_DEBIT_NOTE.'.supplier_po = '.TBL_SUPPLIER_PO_MASTER.'.id');
            $this->db->where(TBL_SUPPLIER_PO_MASTER.'.id', $supplier_po_number);
            $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
            $data = $query->result_array();
            return $data;
        }

    }

    public function get_supplierpodata_debit_data($supplier_po_id){

        $this->db->select(TBL_DEBIT_NOTE.'.tds_amount,'.TBL_DEBIT_NOTE.'.total_debit_amount,'.TBL_DEBIT_NOTE.'.debit_note_number');
        $this->db->join(TBL_DEBIT_NOTE, TBL_DEBIT_NOTE.'.supplier_id = '.TBL_SUPPLIER_PO_MASTER.'.id');
        $this->db->where(TBL_SUPPLIER_PO_MASTER.'.id', $supplier_po_id);
        $query = $this->db->get(TBL_SUPPLIER_PO_MASTER);
        $data = $query->result_array();
        return $data;
    }
    
    public function savepoitem($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_POD_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_POD_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function update_last_inserted_id_poddetails($saveNewdPODDetails){

        $data = array(
            'POD_id' =>$saveNewdPODDetails
        );

        $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
        if($this->db->update(TBL_POD_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }  
    
    public function deletepoddetails($id){
        $this->db->where('pod_details_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_POD_DETAILS)){
            
            $this->db->where('POD_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_POD_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function getpoddetails(){


        $this->db->select('pre_vendor_supplier_name');
        $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
        $query = $this->db->get(TBL_POD_ITEM);
        $pre_vendor_supplier_name = $query->result_array();
       
        foreach ($pre_vendor_supplier_name as $key_vendor_supplier_name => $value_vendor_supplier_name) {

            // print_r($value_vendor_supplier_name);
            // exit;

            if($value_vendor_supplier_name['pre_vendor_supplier_name']=='vendor'){

                if($value_vendor_supplier_name['pre_supplier_po_number']){

                    $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as name');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number','left');
                    //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.part_number = '.TBL_POD_ITEM.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
                    $query = $this->db->get(TBL_POD_ITEM);
                    $data = $query->result_array();
                    return $data;

                }else{

                    $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_FINISHED_GOODS.'.name as name');
                    // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number','left');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_POD_ITEM.'.part_number');
                    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                    $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                    $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
                    $query = $this->db->get(TBL_POD_ITEM);
                    $data = $query->result_array();
                    return $data;
                }
                
                
            }else{

                $this->db->select('*,'.TBL_POD_ITEM.'.id as pod_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER_PO_MASTER.'.po_number as supplier_po,'.TBL_POD_ITEM.'.remark as pod_remark,'.TBL_RAWMATERIAL.'.type_of_raw_material as name');
                $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number');
                // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.part_number = '.TBL_RAWMATERIAL.'.part_number','left');
                $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_vendor_po_number','left');
                $this->db->join(TBL_SUPPLIER_PO_MASTER, TBL_SUPPLIER_PO_MASTER.'.id = '.TBL_POD_ITEM.'.pre_supplier_po_number','left');
                $this->db->where(TBL_POD_ITEM.'.POD_id IS NULL');
                $query = $this->db->get(TBL_POD_ITEM);
                $data = $query->result_array();
                return $data;

            }           
        }


    }

    public function deletePODitem($id){
        $this->db->where('id', $id);
        if($this->db->delete(TBL_POD_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getqulityformcount($params){
        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_QUALITY_RECORDS.'.vendor_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS.'.vendor_po');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_QUALITY_RECORDS.'.buyer_name','left');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS.'.buyer_po_number','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_QUALITY_RECORDS.".quality_records_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_QUALITY_RECORDS.".quality_records_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_QUALITY_RECORDS.'.status', 1); 
        $query = $this->db->get(TBL_QUALITY_RECORDS);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getqulityformdata($params){
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_pomaster,'.TBL_QUALITY_RECORDS.'.quality_records_id  as quality_records_id,'.TBL_BUYER_PO_MASTER.'.sales_order_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_QUALITY_RECORDS.'.vendor_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS.'.vendor_po');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_QUALITY_RECORDS.'.buyer_name','left');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS.'.buyer_po_number','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_QUALITY_RECORDS.".quality_records_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_QUALITY_RECORDS.".quality_records_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_QUALITY_RECORDS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_QUALITY_RECORDS.'.quality_records_id','DESC');
        $query = $this->db->get(TBL_QUALITY_RECORDS);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['quality_records_number'] = $value['quality_records_number'];
                $data[$counter]['quality_records_date'] = $value['quality_records_date'];
                $data[$counter]['vendor_name'] = $value['vendorname'];
                $data[$counter]['vendor_po_number'] = $value['vendor_pomaster'];
                $data[$counter]['buyer_name'] = $value['buyer_name'];
                $data[$counter]['buyer_po'] = $value['sales_order_number'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editqulityrecordform/".$value['quality_records_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['quality_records_id']."' class='fa fa-trash-o deletequlityrecords' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function saveualitydetails($id,$data){

        if($id != '') {
            $this->db->where('quality_records_id', $id);
            if($this->db->update(TBL_QUALITY_RECORDS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_QUALITY_RECORDS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }


    public function deletequlityrecords($id){
        $this->db->where('quality_records_id', $id);
        if($this->db->delete(TBL_QUALITY_RECORDS)){
    
           $this->db->where('quality_records_id', $id);
           //$this->db->delete(TBL_SUPPLIER);
           if($this->db->delete(TBL_QUALITY_RECORDS_ITEM)){
              return TRUE;
           }else{
              return FALSE;
           }
          return TRUE;

        }else{
           return FALSE;
        }

    }

    public function deletequalityrecordsitem($id){
        $this->db->where('id', $id);
        if($this->db->delete(TBL_QUALITY_RECORDS_ITEM)){
          return TRUE;
        }else{
           return FALSE;
        }
    }

    public function get_prevoius_QR_REcord(){

        $this->db->select('quality_records_number');
        $this->db->where(TBL_QUALITY_RECORDS.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_QUALITY_RECORDS.'.quality_records_id','DESC');
        $query = $this->db->get(TBL_QUALITY_RECORDS);
        $rowcount = $query->result_array();
        return $rowcount;

    }

    public function savequlityrecorditem($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_QUALITY_RECORDS_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_QUALITY_RECORDS_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }

    public function get_qulityrecorditemrecord(){
        $this->db->select('*,'.TBL_QUALITY_RECORDS_ITEM.'.pre_vendor_name as vendor_id_qty_record,'.TBL_VENDOR_PO_MASTER.'.po_number as qtypo_number,'.TBL_QUALITY_RECORDS_ITEM.'.id as qtyid,'.TBL_BUYER_MASTER.'.buyer_name as byuerqty,'.TBL_VENDOR_PO_MASTER.'.date as vendorpodate,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_QUALITY_RECORDS_ITEM.'.remark as remarkitem');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_QUALITY_RECORDS_ITEM.'.part_number');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_buyer_name','left');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_buyer_po_number','left');
        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.status', 1);
        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.quality_records_id IS NULL');
        $query = $this->db->get(TBL_QUALITY_RECORDS_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;
       
    }

    public function get_qulityrecorditemrecord_edit($qulity_record_id){




        $this->db->select('*,'.TBL_QUALITY_RECORDS_ITEM.'.pre_vendor_name as vendor_id_qty_record,'.TBL_VENDOR_PO_MASTER.'.po_number as qtypo_number,'.TBL_QUALITY_RECORDS_ITEM.'.id as qtyid,'.TBL_BUYER_MASTER.'.buyer_name as byuerqty,'.TBL_VENDOR_PO_MASTER.'.date as vendorpodate,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_QUALITY_RECORDS_ITEM.'.remark as remarkitem');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_QUALITY_RECORDS_ITEM.'.part_number');
        //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_buyer_name','left');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS_ITEM.'.pre_buyer_po_number','left');
        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.status', 1);
        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.quality_records_id', $qulity_record_id);
        $query = $this->db->get(TBL_QUALITY_RECORDS_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;




       
    }

    public function getqualityrecords_details($qulity_record_id){

        $this->db->select(TBL_QUALITY_RECORDS.'.quality_records_number,'.TBL_QUALITY_RECORDS.'.quality_records_date,'.TBL_QUALITY_RECORDS.'.vendor_id,'.TBL_VENDOR_PO_MASTER.'.po_number,'.TBL_QUALITY_RECORDS.'.vendor_po as vendor_po_id,'.TBL_VENDOR_PO_MASTER.'.date as po_date,'.TBL_BUYER_MASTER.'.buyer_name,'.TBL_QUALITY_RECORDS.'.buyer_name as buyer_id,'.TBL_QUALITY_RECORDS.'.buyer_po_number as buyer_po_id,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_QUALITY_RECORDS.'.remark,'.TBL_QUALITY_RECORDS.'.quality_records_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS.'.vendor_po');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_QUALITY_RECORDS.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_QUALITY_RECORDS.'.buyer_name');
        $this->db->where(TBL_QUALITY_RECORDS.'.status', 1);
        $this->db->where(TBL_QUALITY_RECORDS.'.quality_records_id', $qulity_record_id);
        $query = $this->db->get(TBL_QUALITY_RECORDS);
        $fetch_result = $query->row_array();
        return $fetch_result;


    }


    public function getPriviousstockid(){

        $this->db->select('stock_id_number');
        $this->db->where(TBL_STOCKS.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_STOCKS.'.stock_id','DESC');
        $query = $this->db->get(TBL_STOCKS);
        $rowcount = $query->result_array();
        return $rowcount;
    }

    public function getbuyerpodetailsforvendorstockform($vendor_po_number){

        $this->db->select(TBL_BUYER_PO_MASTER.'.*,'.TBL_BUYER_PO_MASTER.'.id as buyer_po_id,'.TBL_BUYER_MASTER.'.buyer_name as b_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_number);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.status', 1);
        $query_result = $this->db->get(TBL_VENDOR_PO_MASTER)->result_array();
        return $query_result;
    }

    public function getItemdetailsdependonvendorpoforstockform($part_number,$vendor_po_number,$vendor_name){



        $chekc_if_supplie_name_exits =  $this->chekc_if_supplie_name_exits($vendor_po_number);

    
        if($chekc_if_supplie_name_exits['supplier_po_number']){

         

            $this->db->select(TBL_FINISHED_GOODS.'.name,'.TBL_FINISHED_GOODS.'.net_weight,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty as buyer_order_qty,'.TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id,'.TBL_VENDOR_PO_MASTER_ITEM.'.vendor_qty as vendor_qtyvendor_qty,'.TBL_FINISHED_GOODS.'.hsn_code as finhsn_code,'.TBL_RAWMATERIAL.'.type_of_raw_material');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            $this->db->join(TBL_BUYER_PO_MASTER_ITEM.' as a', 'a.buyer_po_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_buyer_po_number');
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $query = $this->db->get(TBL_FINISHED_GOODS);
            $data = $query->result_array();
            return $data;

        }else{

        

            // $this->db->select(TBL_FINISHED_GOODS.'.name,'.TBL_FINISHED_GOODS.'.net_weight,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty as buyer_order_qty,'.TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id,'.TBL_VENDOR_PO_MASTER_ITEM.'.vendor_qty as vendor_qtyvendor_qty,'.TBL_FINISHED_GOODS.'.hsn_code as finhsn_code');
            // //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->join(TBL_BUYER_PO_MASTER_ITEM.' as a', 'a.buyer_po_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_buyer_po_number');
            // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $query = $this->db->get(TBL_FINISHED_GOODS);
            // $data = $query->result_array();
            // return $data;

            

            $this->db->select(TBL_FINISHED_GOODS.'.name,'.TBL_FINISHED_GOODS.'.net_weight,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty as buyer_order_qty,'.TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id,'.TBL_VENDOR_PO_MASTER_ITEM.'.vendor_qty as vendor_qtyvendor_qty,'.TBL_FINISHED_GOODS.'.hsn_code as finhsn_code');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
             //$this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
             $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
             $this->db->join(TBL_BUYER_PO_MASTER_ITEM.' as a', 'a.buyer_po_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_buyer_po_number');
             $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;


        }
    }

    public function savestockform($id,$data){
        if($id != '') {
            $this->db->where('stock_id', $id);
            if($this->db->update(TBL_STOCKS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_STOCKS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function getstockformcount($params){

        $this->db->select(TBL_STOCKS.'.stock_id_number,'.TBL_STOCKS.'.stock_date,'.TBL_VENDOR_PO_MASTER.'.po_number as venor_po_number,'.TBL_VENDOR_PO_MASTER.'.date as vendor_po_date,'.TBL_VENDOR.'.vendor_name,'.TBL_BUYER_MASTER.'.buyer_name,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_BUYER_PO_MASTER.'.date as buyer_po_date,'.TBL_BUYER_PO_MASTER.'.delivery_date as delivery_date');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_STOCKS.'.vendor_po_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_STOCKS.'.vendor_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_STOCKS.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_STOCKS.'.buyer_name');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_STOCKS.".stock_id_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_STOCKS.".stock_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".delivery_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_STOCKS.'.status', 1);
        $query = $this->db->get(TBL_STOCKS);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getstockformdata($params){
        $this->db->select(TBL_STOCKS.'.stock_id,'.TBL_STOCKS.'.stock_id_number,'.TBL_STOCKS.'.stock_date,'.TBL_VENDOR_PO_MASTER.'.po_number as venor_po_number,'.TBL_VENDOR_PO_MASTER.'.date as vendor_po_date,'.TBL_VENDOR.'.vendor_name,'.TBL_BUYER_MASTER.'.buyer_name,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_BUYER_PO_MASTER.'.date as buyer_po_date,'.TBL_BUYER_PO_MASTER.'.delivery_date as delivery_date');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_STOCKS.'.vendor_po_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_STOCKS.'.vendor_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_STOCKS.'.buyer_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_STOCKS.'.buyer_name');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_STOCKS.".stock_id_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_STOCKS.".stock_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_MASTER.".buyer_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".sales_order_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_BUYER_PO_MASTER.".delivery_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }

        $this->db->where(TBL_STOCKS.'.status', 1);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_STOCKS.'.stock_id ','DESC');
        $query = $this->db->get(TBL_STOCKS);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['stock_id_number'] = $value['stock_id_number'];
                $data[$counter]['stock_date'] = $value['stock_date'];
                $data[$counter]['vendor_name'] = $value['vendor_name'];
                $data[$counter]['venor_po_number'] = $value['venor_po_number'];
                $data[$counter]['vendor_po_date'] = $value['vendor_po_date'];
                $data[$counter]['buyer_name'] = $value['buyer_name'];
                $data[$counter]['buyer_po_number'] = $value['sales_order_number'];
                $data[$counter]['buyer_po_date'] = $value['buyer_po_date'];
                $data[$counter]['buyer_delivery_date'] = $value['delivery_date'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editstcokformdetails/".$value['stock_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."stockrejectionform' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-ban' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."searchstock' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-stack-exchange' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['stock_id']."' class='fa fa-trash-o deletestockform' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function saveStockformitemdetails($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_STOCKS_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_STOCKS_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }

    public function getItemlistStockform(){
        $this->db->select('*,'.TBL_STOCKS_ITEM.'.id as stock_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_STOCKS_ITEM.'.part_number');
       // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id IS NULL');
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $data = $query->result_array();
        return $data;
    }
    
    public function update_last_inserted_id_stock_from($saveStockformitemdetails){

        $data = array(
            'stock_form_id' =>$saveStockformitemdetails
        );

        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id IS NULL');
        if($this->db->update(TBL_STOCKS_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function deleteStockformitem($id){
        $this->db->where('id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_STOCKS_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function deletestockform($id){
        $this->db->where('stock_id', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_STOCKS)){
            
            $this->db->where('stock_form_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_STOCKS_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getStockforminformation(){

        $this->db->select(TBL_STOCKS_ITEM.'.pre_stock_date,'.TBL_STOCKS_ITEM.'.pre_vendor_po_date,'.TBL_STOCKS_ITEM.'.pre_vendor_name,'.TBL_VENDOR_PO_MASTER.'.po_number,'.TBL_STOCKS_ITEM.'.pre_buyer_name,'.TBL_BUYER_MASTER.'.buyer_name,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_STOCKS_ITEM.'.pre_buyer_po_id,'.TBL_STOCKS_ITEM.'.pre_buyer_po_date,'.TBL_STOCKS_ITEM.'.pre_buyer_delivery_date,'.TBL_STOCKS_ITEM.'.pre_vendor_po_number,'.TBL_BUYER_MASTER.'.buyer_id,'.TBL_STOCKS_ITEM.'.pre_remark as pre_remark_item');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_STOCKS_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id  = '.TBL_STOCKS_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_STOCKS_ITEM.'.pre_buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_STOCKS_ITEM.'.pre_buyer_po_id');
        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id IS NULL');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;

    }

    public function getAlltotalcalculation(){
        $this->db->select('sum(invoice_qty_In_pcs) as invoice_qty_In_pcs,sum(invoice_qty_In_kgs) as invoice_qty_In_kgs,sum(actual_received_qty_in_pcs) as actual_received_qty_in_pcs,sum(actual_received_qty_in_kgs) as actual_received_qty_in_kgs');
        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id IS NULL');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $fetch_result = $query->row_array();
        return $fetch_result;
    }

    public function getAlltotalcalculationedit($stock_id){
        $this->db->select('sum(invoice_qty_In_pcs) as invoice_qty_In_pcs,sum(invoice_qty_In_kgs) as invoice_qty_In_kgs,sum(actual_received_qty_in_pcs) as actual_received_qty_in_pcs,sum(actual_received_qty_in_kgs) as actual_received_qty_in_kgs');
        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id',$stock_id);
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $fetch_result = $query->row_array();
        return $fetch_result;
    }

    public function getallitemsfromfgorrawmaterial(){

        $this->db->select(TBL_FINISHED_GOODS.'.fin_id,'.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number  = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $fetch_result = $query->result_array();
        return $fetch_result;

    }

    public function getsearchstockformcount($params){

        $this->db->select(TBL_STOCKS_ITEM.'.id');
        $this->db->join(TBL_STOCKS, TBL_STOCKS.'.stock_id  = '.TBL_STOCKS_ITEM.'.stock_form_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_STOCKS_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_STOCKS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id  = '.TBL_STOCKS_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_STOCKS_ITEM.'.pre_buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_STOCKS_ITEM.'.pre_buyer_po_id');
        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id IS NOT NULL');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $this->db->group_by(TBL_STOCKS_ITEM.'.id');
        $this->db->order_by(TBL_STOCKS_ITEM.'.id ','DESC');
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getsearchstockformdata($params){
        $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_FINISHED_GOODS.'.name,'.TBL_STOCKS_ITEM.'.f_g_order_qty,'.TBL_STOCKS_ITEM.'.invoice_number,'.TBL_STOCKS_ITEM.'.invoice_date,'.TBL_STOCKS_ITEM.'.invoice_qty_In_pcs,'.TBL_STOCKS_ITEM.'.invoice_qty_In_kgs,'.TBL_STOCKS_ITEM.'.lot_number,'.TBL_STOCKS_ITEM.'.actual_received_qty_in_pcs,'.TBL_STOCKS_ITEM.'.actual_received_qty_in_kgs');
        $this->db->join(TBL_STOCKS, TBL_STOCKS.'.stock_id  = '.TBL_STOCKS_ITEM.'.stock_form_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id  = '.TBL_STOCKS_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_STOCKS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id  = '.TBL_STOCKS_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_STOCKS_ITEM.'.pre_buyer_name');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_STOCKS_ITEM.'.pre_buyer_po_id');

        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id IS NOT NULL');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $this->db->group_by(TBL_STOCKS_ITEM.'.id');
        $this->db->order_by(TBL_STOCKS_ITEM.'.id ','DESC');
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['part_number'] =$value['part_number'];
                $data[$counter]['part_description'] =$value['name'];
                $data[$counter]['f_g_order_qty'] =$value['f_g_order_qty'];
                $data[$counter]['invoice_number'] =$value['invoice_number'];
                $data[$counter]['invoice_date'] =$value['invoice_date'];
                $data[$counter]['invoice_qty_In_pcs'] =$value['invoice_qty_In_pcs'];
                $data[$counter]['invoice_qty_In_kgs'] =$value['invoice_qty_In_kgs'];
                $data[$counter]['lot_number'] =$value['lot_number'];
                $data[$counter]['actual_received_qty_in_pcs'] =$value['actual_received_qty_in_pcs'];
                $data[$counter]['actual_received_qty_in_kgs'] =$value['actual_received_qty_in_kgs'];
              
                $counter++; 
            }
        }
        return $data;
    }

    public function checkLotnumberisexitsadd($lot_no,$part_number,$po_number){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.id ');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.lot_no', $lot_no);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number', $po_number);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id IS NULL');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->row_array();
        return $data;

    }


    public function checkLotnumberisexitsaddedititem($lot_no,$part_number,$po_number,$incoiming_detail__item_id){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.id ');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.lot_no', $lot_no);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id', $incoiming_detail__item_id);
        // $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number', $po_number);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id IS NULL');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->row_array();
        return $data;

    }


    public function checkLotnumberisexitsaddedititemedit($lot_no,$part_number,$po_number,$incoiming_detail__item_id){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.id ');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.lot_no', $lot_no);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id', $incoiming_detail__item_id);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number', $po_number);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id IS NOT NULL');
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->row_array();
        return $data;

    }


    public function checkLotnumberisexitsedit($incomingdetail_editid,$lot_no,$part_num){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.id ');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.lot_no', $lot_no);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_num);
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$incomingdetail_editid);
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->row_array();
        return $data;
    }

    public function getincominglotnumberbyvendor($part_number,$vendor_id,$vendor_po_number){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.id,'.TBL_INCOMING_DETAILS_ITEM.'.lot_no,'.TBL_INCOMING_DETAILS.'.incoming_details_id');
        //$this->db->join(TBL_INCOMING_DETAILS_ITEM, TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id = '.TBL_INCOMING_DETAILS.'.id');
        $this->db->join(TBL_INCOMING_DETAILS, TBL_INCOMING_DETAILS.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id');


        //  $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS.'.vendor_po_number');
        //  $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id = '.TBL_VENDOR_PO_MASTER.'.id');
        // // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        //   $this->db->join(TBL_VENDOR_PO_MASTER_ITEM.' as a', 'a.part_number_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        $this->db->where(TBL_INCOMING_DETAILS.'.vendor_name', $vendor_id);
        $this->db->where(TBL_INCOMING_DETAILS.'.vendor_po_number', $vendor_po_number);
        
        $this->db->order_by(TBL_INCOMING_DETAILS.'.id','DESC');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        //$this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        //$this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number !=',"");
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function getinvoiceqtybyLotnumber($lot_id){

        $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.invoice_qty,'.TBL_INCOMING_DETAILS_ITEM.'.invoice_no,'.TBL_INCOMING_DETAILS_ITEM.'.invoice_date');
        //$this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id',trim($lot_id));
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function getalltotalcalculationstockform(){
        // $this->db->select('sum(invoice_qty_In_pcs) as invoice_qty_In_pcs,sum(invoice_qty_In_kgs) as invoice_qty_In_kgs,sum(actual_received_qty_in_pcs) as actual_received_qty_in_pcs,sum(actual_received_qty_in_kgs) as actual_received_qty_in_kgs');

        $this->db->select('sum(invoice_qty_In_pcs) as invoice_qty_In_pcs,sum(invoice_qty_In_kgs) as invoice_qty_In_kgs,sum(actual_received_qty_in_pcs) as actual_received_qty_in_pcss,sum(actual_received_qty_in_kgs) as actual_received_qty_in_kgs');

        //$this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        $this->db->where(TBL_STOCKS_ITEM.'.status',1);
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function getexportrecordsitemcount($params){

        $this->db->select(TBL_STOCKS_ITEM.'.id');
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getexportrecordsitemdata($params){
        $this->db->select(TBL_PACKING_INSTRACTION.'.packing_instrauction_id,'.TBL_PACKING_INSTRACTION_DETAILS.'.buyer_invoice_date,'.TBL_PACKING_INSTRACTION_DETAILS.'.buyer_invoice_qty,'.TBL_PACKING_INSTRACTION.'.buyer_po_date,'.TBL_FINISHED_GOODS.'.net_weight');
        $this->db->join(TBL_PACKING_INSTRACTION, TBL_PACKING_INSTRACTION.'.id = '.TBL_PACKING_INSTRACTION_DETAILS.'.packing_instract_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_PACKING_INSTRACTION_DETAILS.'.part_number');
        $this->db->where(TBL_PACKING_INSTRACTION_DETAILS.'.status', 1);
        $this->db->order_by(TBL_PACKING_INSTRACTION_DETAILS.'.id','DESC');
        $query = $this->db->get(TBL_PACKING_INSTRACTION_DETAILS);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['packing_instrauction_id'] =$value['packing_instrauction_id'];
                $data[$counter]['buyer_invoice_date'] =$value['buyer_invoice_date'];
                $data[$counter]['buyer_invoice_qty'] =$value['buyer_invoice_qty'];
                $data[$counter]['export_qty_in_kgs'] = $value['buyer_invoice_qty'] *  $value['net_weight'];
                $data[$counter]['buyer_po_date'] =$value['buyer_po_date'];
                $counter++; 
            }
        }
        return $data;
    }

    public function getexportrejecteditemcount($params){
        $this->db->select('*');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.id = '.TBL_REJECTION_FORM_REJECTED_ITEM.'.item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        $this->db->join(TBL_REJECTION_FORM, TBL_REJECTION_FORM.'.id = '.TBL_REJECTION_FORM_REJECTED_ITEM.'.rejection_form_id');
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.status', 1);
        $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getexportrejecteditemdata($params){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.id = '.TBL_REJECTION_FORM_REJECTED_ITEM.'.item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        $this->db->join(TBL_REJECTION_FORM, TBL_REJECTION_FORM.'.id = '.TBL_REJECTION_FORM_REJECTED_ITEM.'.rejection_form_id');
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.status', 1);
        $this->db->order_by(TBL_REJECTION_FORM_REJECTED_ITEM.'.id ','DESC');
        $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['rejection_number'] =$value['rejection_number'];
                $data[$counter]['rejected_reason'] =$value['rejected_reason'];
                $data[$counter]['qty_In_pcs'] =$value['qty_In_pcs'];
                $data[$counter]['qty_In_kgs'] =$value['fg_net_weight'] * $value['qty_In_kgs'];
                $counter++; 
            }
        }
        return $data;
    }

    public function checkvendorpoisaredayexits($vendor_po_number){
        $this->db->select('count(*) as vendor_ids');
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $this->db->where(TBL_INCOMING_DETAILS.'.vendor_po_number', $vendor_po_number);
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $fetch_result = $query->row_array();
        return $fetch_result;
    }

    public function checkvendorpoisaredayexitsedit($incomingdetail_editid,$vendor_po_number){
        $this->db->select('count(*) as vendor_ids');
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        $this->db->where(TBL_INCOMING_DETAILS.'.id', $incomingdetail_editid);
        $this->db->where(TBL_INCOMING_DETAILS.'.vendor_po_number', $vendor_po_number);
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $fetch_result = $query->row_array();
        return $fetch_result;

    }

    public function getStockdetailsData($stock_id){

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.id as vendor_po_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_BUYER_MASTER.'.buyer_id,'.TBL_BUYER_MASTER.'.buyer_name,'.TBL_BUYER_PO_MASTER.'.id as buyer_po_id,'.TBL_BUYER_PO_MASTER.'.sales_order_number,'.TBL_BUYER_PO_MASTER.'.buyer_po_date,'.TBL_STOCKS.'.Invoice_qty_in_pcs as total_Invoice_qty_in_pcs,'.TBL_STOCKS.'.Invoice_qty_in_kgs as total_Invoice_qty_in_kgs,'.TBL_STOCKS.'.actual_received_qty_in_pcs as total_actual_received_qty_in_pcs,'.TBL_STOCKS.'.actual_received_qty_in_kgs as total_actual_received_qty_in_kgs,'.TBL_STOCKS.'.remark as stock_remark');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_STOCKS.'.vendor_po_number');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_STOCKS.'.buyer_name');

        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_STOCKS.'.buyer_po_number');

        $this->db->where(TBL_STOCKS.'.status', 1);
        $this->db->where(TBL_STOCKS.'.stock_id', $stock_id);
        $query = $this->db->get(TBL_STOCKS);
        $fetch_result = $query->row_array();
        return $fetch_result;
    }
    
    public function getItemlistStockformedit($stock_id){
        $this->db->select('*,'.TBL_STOCKS_ITEM.'.id as stock_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_STOCKS_ITEM.'.part_number');
        //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $this->db->where(TBL_STOCKS_ITEM.'.stock_form_id',$stock_id);
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $data = $query->result_array();
        return $data;
    }

    public function getomsChallancount($params){
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as ven_name,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_master,'.TBL_OMS_CHALLAN.'.date as oms_chllan_date');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_OMS_CHALLAN.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN.'.vendor_po_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_OMS_CHALLAN.".blasting_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_OMS_CHALLAN.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_OMS_CHALLAN.".remark LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_OMS_CHALLAN.".vendor_po_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_OMS_CHALLAN.'.status', 1);
        $this->db->order_by(TBL_OMS_CHALLAN.'.id','DESC');
        $query = $this->db->get(TBL_OMS_CHALLAN);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getomsChallandata($params){
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as ven_name,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_master,'.TBL_OMS_CHALLAN.'.date as oms_chllan_date,'.TBL_OMS_CHALLAN.'.id as oms_challan_id,'.TBL_OMS_CHALLAN.'.remark as omsremark');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_OMS_CHALLAN.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN.'.vendor_po_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_OMS_CHALLAN.".blasting_id LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_OMS_CHALLAN.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_OMS_CHALLAN.".remark LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_OMS_CHALLAN.".vendor_po_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_OMS_CHALLAN.'.status', 1);
        $this->db->order_by(TBL_OMS_CHALLAN.'.id','DESC');
        $query = $this->db->get(TBL_OMS_CHALLAN);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['blasting_id'] =$value['blasting_id'];
                $data[$counter]['date'] =$value['oms_chllan_date'];
                $data[$counter]['vendor_name'] =$value['ven_name'];
                $data[$counter]['vendor_po_id'] = $value['vendor_po_master'];
                $data[$counter]['vendor_po_date'] =$value['vendor_po_date'];
                $data[$counter]['remark'] =$value['omsremark'];
                $data[$counter]['action'] ='';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editomschallan/".$value['oms_challan_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='#' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-print' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='#' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-print' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['oms_challan_id']."' class='fa fa-trash-o deleteomschallan' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function getpreviuousblasterId(){
        $this->db->select('blasting_id');
        $this->db->where(TBL_OMS_CHALLAN.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_OMS_CHALLAN.'.id','DESC');
        $query = $this->db->get(TBL_OMS_CHALLAN);
        $rowcount = $query->row_array();
        return $rowcount;
    }

    public function saveomschallanform($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_OMS_CHALLAN, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_OMS_CHALLAN, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }
    
    public function deleteomschallan($id){
        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_OMS_CHALLAN)){
            
            $this->db->where('oms_chllan_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_OMS_CHALLAN_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function saveomsChallanformdetails($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_OMS_CHALLAN_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_OMS_CHALLAN_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }

    }

    public function update_oms_challan_from($oms_challan_id){

        $data = array(
            'oms_chllan_id' =>$oms_challan_id
        );

        $this->db->where(TBL_OMS_CHALLAN_ITEM.'.oms_chllan_id IS NULL');
        if($this->db->update(TBL_OMS_CHALLAN_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getomschallanitems(){

        $this->db->select('*,'.TBL_FINISHED_GOODS.'.name as fgdiscription,'.TBL_RAWMATERIAL.'.type_of_raw_material,'.TBL_OMS_CHALLAN_ITEM.'.gross_weight as omsgross_weight,'.TBL_OMS_CHALLAN_ITEM.'.net_weight as omsnet_weight,'.TBL_OMS_CHALLAN_ITEM.'.qty as omsqty,'.TBL_OMS_CHALLAN_ITEM.'.remark as omsremark,'.TBL_OMS_CHALLAN_ITEM.'.id  as omsid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_OMS_CHALLAN_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_OMS_CHALLAN_ITEM.'.status', 1);
        $this->db->where(TBL_OMS_CHALLAN_ITEM.'.oms_chllan_id IS NULL');
        $query = $this->db->get(TBL_OMS_CHALLAN_ITEM);
        $data = $query->result_array();

        if(count($data) > 0)
        {
            return $data;
        }else{

            $this->db->select('*,'.TBL_FINISHED_GOODS.'.name as fgdiscription,'.TBL_FINISHED_GOODS.'.name as type_of_raw_material,'.TBL_OMS_CHALLAN_ITEM.'.gross_weight as omsgross_weight,'.TBL_OMS_CHALLAN_ITEM.'.net_weight as omsnet_weight,'.TBL_OMS_CHALLAN_ITEM.'.qty as omsqty,'.TBL_OMS_CHALLAN_ITEM.'.remark as omsremark,'.TBL_OMS_CHALLAN_ITEM.'.id  as omsid');
            $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_name');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_po_number');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_OMS_CHALLAN_ITEM.'.part_number');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_OMS_CHALLAN_ITEM.'.status', 1);
            $this->db->where(TBL_OMS_CHALLAN_ITEM.'.oms_chllan_id IS NULL');
            $query = $this->db->get(TBL_OMS_CHALLAN_ITEM);
            $data_2 = $query->result_array();

            return $data_2;


        }
    }

    public function deleteOmschallnitem($id){

        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_OMS_CHALLAN_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }

    }

    public function getomsChllanData($id){
        $this->db->select('*,'.TBL_OMS_CHALLAN.'.remark as omsremark,'.TBL_OMS_CHALLAN.'.vendor_po_date as vendor_podate,'.TBL_OMS_CHALLAN.'.date as omsdate,'.TBL_OMS_CHALLAN.'.id as challan_main_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN.'.vendor_po_id');
        $this->db->where(TBL_OMS_CHALLAN.'.status', 1);
        $this->db->where(TBL_OMS_CHALLAN.'.id',$id);
        $query = $this->db->get(TBL_OMS_CHALLAN);
        $rowcount = $query->row_array();
        return $rowcount;
    }
    
    public function getomsitemlistforedit($id){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.name as fgdiscription,'.TBL_RAWMATERIAL.'.type_of_raw_material,'.TBL_OMS_CHALLAN_ITEM.'.gross_weight as omsgross_weight,'.TBL_OMS_CHALLAN_ITEM.'.net_weight as omsnet_weight,'.TBL_OMS_CHALLAN_ITEM.'.qty as omsqty,'.TBL_OMS_CHALLAN_ITEM.'.remark as omsremark,'.TBL_OMS_CHALLAN_ITEM.'.id  as omsid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_OMS_CHALLAN_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_OMS_CHALLAN_ITEM.'.status', 1);
        $this->db->where(TBL_OMS_CHALLAN_ITEM.'.oms_chllan_id',$id);
        $query = $this->db->get(TBL_OMS_CHALLAN_ITEM);
        $data = $query->result_array();
        // return $data;

        if(count($data) > 0)
        {
            return $data;
        }else{

            $this->db->select('*,'.TBL_FINISHED_GOODS.'.name as fgdiscription,'.TBL_FINISHED_GOODS.'.name as type_of_raw_material,'.TBL_OMS_CHALLAN_ITEM.'.gross_weight as omsgross_weight,'.TBL_OMS_CHALLAN_ITEM.'.net_weight as omsnet_weight,'.TBL_OMS_CHALLAN_ITEM.'.qty as omsqty,'.TBL_OMS_CHALLAN_ITEM.'.remark as omsremark,'.TBL_OMS_CHALLAN_ITEM.'.id  as omsid');
            $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_name');
            $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_OMS_CHALLAN_ITEM.'.pre_vendor_po_number');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_OMS_CHALLAN_ITEM.'.part_number');
           // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_OMS_CHALLAN_ITEM.'.status', 1);
            $this->db->where(TBL_OMS_CHALLAN_ITEM.'.oms_chllan_id',$id);
            $query = $this->db->get(TBL_OMS_CHALLAN_ITEM);
            $data_2 = $query->result_array();
            return $data_2;

        }


    }

    public function getenquiryformcount($params){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENAUIRY_FORM.".enquiry_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".buyer_enquiry_no LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".buyer_enquiry_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENAUIRY_FORM.'.status', 1);
        $this->db->order_by(TBL_ENAUIRY_FORM.'.id','DESC');
        $query = $this->db->get(TBL_ENAUIRY_FORM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getenquiryformdata($params){
        $this->db->select('*,'.TBL_ENAUIRY_FORM.'.id as enquiry_form_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENAUIRY_FORM.".enquiry_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".buyer_enquiry_no LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".buyer_enquiry_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENAUIRY_FORM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENAUIRY_FORM.'.status', 1);
        $this->db->order_by(TBL_ENAUIRY_FORM.'.id','DESC');
        $query = $this->db->get(TBL_ENAUIRY_FORM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['enquiry_number'] =$value['enquiry_number'];
                $data[$counter]['date'] =$value['date'];
                $data[$counter]['buyer_enquiry_no'] =$value['buyer_enquiry_no'];
                $data[$counter]['buyer_enquiry_date'] = $value['buyer_enquiry_date'];
                $data[$counter]['remark'] =$value['remark'];
                $data[$counter]['action'] ='';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editeqnuiryformdata/".$value['enquiry_form_id']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['enquiry_form_id']."' class='fa fa-trash-o deleteeqnuiryformdata' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }

    public function saveenquirydetailsform($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_ENAUIRY_FORM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ENAUIRY_FORM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }

    public function partNumberlistforenquirylist(){
        $this->db->select('fin_id,part_number');
        $this->db->where(TBL_FINISHED_GOODS.'.status', 1);
        $this->db->order_by(TBL_FINISHED_GOODS.'.fin_id','DESC');
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
    }

    public function saveenquiryformitem($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_ENAUIRY_FORM_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ENAUIRY_FORM_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }

    }

    public function saveenquiryformitemedit($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_REJECTION_FORM_REJECTED_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_REJECTION_FORM_REJECTED_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }

    }


    public function getenquirydetailsforedit($enquiryformid){

        $this->db->select('*,'.TBL_ENAUIRY_FORM.'.id as enquiry_form_id');
        $this->db->where(TBL_ENAUIRY_FORM.'.status', 1);
        $this->db->where(TBL_ENAUIRY_FORM.'.id',$enquiryformid);
        $query = $this->db->get(TBL_ENAUIRY_FORM);
        $data = $query->row_array();
        return $data;

    }



    public function getallenquiryformitemadd(){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as suplier_id_name_1,a.supplier_name as suplier_id_name_2,b.supplier_name as suplier_id_name_3,c.supplier_name as suplier_id_name_4,d.supplier_name as suplier_id_name_5,e.vendor_name as vendor_name_1,f.vendor_name as vendor_name_2,g.vendor_name as vendor_name_3,h.vendor_name as vendor_name_4,i.vendor_name as vendor_name_5,'.TBL_ENAUIRY_FORM_ITEM.'.id as enquiry_form_id,'.TBL_ENAUIRY_FORM_ITEM.'.groass_weight as engroass_weight');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_ENAUIRY_FORM_ITEM.'.part_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_1','left');
        $this->db->join(TBL_SUPPLIER.' as a', 'a.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_2','left');
        $this->db->join(TBL_SUPPLIER.' as b', 'b.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_3','left');
        $this->db->join(TBL_SUPPLIER.' as c', 'c.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_4','left');
        $this->db->join(TBL_SUPPLIER.' as d', 'd.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_5','left');
        $this->db->join(TBL_VENDOR.' as e', 'e.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_1','left');
        $this->db->join(TBL_VENDOR.' as f', 'f.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_2','left');
        $this->db->join(TBL_VENDOR.' as g', 'g.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_3','left');
        $this->db->join(TBL_VENDOR.' as h', 'h.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_4','left');
        $this->db->join(TBL_VENDOR.' as i', 'i.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_5','left');
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.status', 1);
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.enquiry_form_id IS NULL');
        $query = $this->db->get(TBL_ENAUIRY_FORM_ITEM);
        $data = $query->result_array();
        return $data;

    }


    public function getallenquiryformitemedit($id){
        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as suplier_id_name_1,a.supplier_name as suplier_id_name_2,b.supplier_name as suplier_id_name_3,c.supplier_name as suplier_id_name_4,d.supplier_name as suplier_id_name_5,e.vendor_name as vendor_name_1,f.vendor_name as vendor_name_2,g.vendor_name as vendor_name_3,h.vendor_name as vendor_name_4,i.vendor_name as vendor_name_5,'.TBL_ENAUIRY_FORM_ITEM.'.id as enquiry_form_id,'.TBL_ENAUIRY_FORM_ITEM.'.groass_weight as engroass_weight');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_ENAUIRY_FORM_ITEM.'.part_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_1','left');
        $this->db->join(TBL_SUPPLIER.' as a', 'a.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_2','left');
        $this->db->join(TBL_SUPPLIER.' as b', 'b.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_3','left');
        $this->db->join(TBL_SUPPLIER.' as c', 'c.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_4','left');
        $this->db->join(TBL_SUPPLIER.' as d', 'd.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_5','left');
        $this->db->join(TBL_VENDOR.' as e', 'e.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_1','left');
        $this->db->join(TBL_VENDOR.' as f', 'f.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_2','left');
        $this->db->join(TBL_VENDOR.' as g', 'g.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_3','left');
        $this->db->join(TBL_VENDOR.' as h', 'h.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_4','left');
        $this->db->join(TBL_VENDOR.' as i', 'i.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_5','left');
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.status', 1);
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.enquiry_form_id',$id);
        $query = $this->db->get(TBL_ENAUIRY_FORM_ITEM);
        $data = $query->result_array();
        return $data;

    }




    public function geteditenquiryformitemdata($id){
        $this->db->select('*,'.TBL_SUPPLIER.'.sup_id as suplier_id_name_1,a.sup_id as suplier_id_name_2,b.sup_id as suplier_id_name_3,c.sup_id as suplier_id_name_4,d.sup_id as suplier_id_name_5,e.ven_id  as vendor_name_1,f.ven_id  as vendor_name_2,g.ven_id  as vendor_name_3,h.ven_id  as vendor_name_4,i.ven_id  as vendor_name_5,'.TBL_ENAUIRY_FORM_ITEM.'.id as enquiry_form_item_id,'.TBL_ENAUIRY_FORM_ITEM.'.groass_weight as engroass_weight');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_ENAUIRY_FORM_ITEM.'.part_number');
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_1','left');
        $this->db->join(TBL_SUPPLIER.' as a', 'a.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_2','left');
        $this->db->join(TBL_SUPPLIER.' as b', 'b.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_3','left');
        $this->db->join(TBL_SUPPLIER.' as c', 'c.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_4','left');
        $this->db->join(TBL_SUPPLIER.' as d', 'd.sup_id = '.TBL_ENAUIRY_FORM_ITEM.'.suplier_id_5','left');
        $this->db->join(TBL_VENDOR.' as e', 'e.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_1','left');
        $this->db->join(TBL_VENDOR.' as f', 'f.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_2','left');
        $this->db->join(TBL_VENDOR.' as g', 'g.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_3','left');
        $this->db->join(TBL_VENDOR.' as h', 'h.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_4','left');
        $this->db->join(TBL_VENDOR.' as i', 'i.ven_id = '.TBL_ENAUIRY_FORM_ITEM.'.vendor_id_5','left');
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.status', 1);
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.id',$id);
        $query = $this->db->get(TBL_ENAUIRY_FORM_ITEM);
        $data = $query->result_array();
        return $data;

    }




    public function update_enquiry_from_id_in_items($enquiry_form_id){

        $data = array(
            'enquiry_form_id' =>$enquiry_form_id
        );
        $this->db->where(TBL_ENAUIRY_FORM_ITEM.'.enquiry_form_id IS NULL');
        if($this->db->update(TBL_ENAUIRY_FORM_ITEM,$data)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function deleteenquiryformitemdata($id){
        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_ENAUIRY_FORM_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function fetchALLvendorListwithsupplier(){
        $this->db->select(TBL_VENDOR.'.ven_id,'.TBL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.vendor_name = '.TBL_VENDOR.'.ven_id');
        $this->db->where(TBL_VENDOR.'.status', 1);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number!=',"");
        $this->db->group_by(TBL_VENDOR_PO_MASTER.'.vendor_name');
        $query = $this->db->get(TBL_VENDOR);
        $data = $query->result_array();
        return $data;
    }

    public function fetchALLvendorListwithoutsupplier(){
        $this->db->select(TBL_VENDOR.'.ven_id,'.TBL_VENDOR.'.vendor_name');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.vendor_name = '.TBL_VENDOR.'.ven_id');
        $this->db->where(TBL_VENDOR.'.status', 1);
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name =',"");
        $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_po_number =',"");
        $this->db->group_by(TBL_VENDOR_PO_MASTER.'.vendor_name');
        $query = $this->db->get(TBL_VENDOR);
        $data = $query->result_array();
        return $data;
    }

    public function getVendorpoconfirmationdetails($vendor_po_confirmation_id){
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as vendorname,'.TBL_VENDOR_PO_CONFIRMATION.'.vendor_name as vendor_name_id,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_master_no,'.TBL_VENDOR_PO_CONFIRMATION.'.buyer_name as buyer_id,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_VENDOR_PO_CONFIRMATION.'.remark as remark_master,'.TBL_VENDOR_PO_CONFIRMATION.'.vendor_po_number as vendor_po_');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_VENDOR_PO_CONFIRMATION.'.vendor_po_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER.'.vendor_name');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_CONFIRMATION.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_CONFIRMATION.'.id',$vendor_po_confirmation_id);
        $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION);
        $data = $query->result_array();
        return $data;
    }

    public function deleteBillofmaterialitem($id){

        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_BILL_OF_MATERIAL_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function checkvendorpoandvendornumber($data){

        $this->db->select('*');
        $this->db->where(TBL_INCOMING_DETAILS.'.status', 1);
        //$this->db->where(TBL_INCOMING_DETAILS.'.incoming_details_id', trim($data['incoming_no']));
        $this->db->where(TBL_INCOMING_DETAILS.'.vendor_po_number', trim($data['vendor_po_number']));
        $query = $this->db->get(TBL_INCOMING_DETAILS);
        $data = $query->result_array();
        return $data;


    }

    public function checkvendorpoandvendornumberinbillofmaterial($data){

        $this->db->select('*');
        $this->db->where(TBL_BILL_OF_MATERIAL.'.status', 1);
        $this->db->where(TBL_BILL_OF_MATERIAL.'.vendor_name', trim($data['vendor_name']));
        $this->db->where(TBL_BILL_OF_MATERIAL.'.vendor_po_number', trim($data['vendor_po_number']));
        $query = $this->db->get(TBL_BILL_OF_MATERIAL);
        $data = $query->result_array();
        return $data;

    }

    public function checkvendorpoandvendornumberinvendorbillofmaterial($data){

        $this->db->select('*');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name', trim($data['vendor_name']));
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number', trim($data['vendor_po_number']));
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $data = $query->result_array();
        return $data;

    }

    public function fetchincomingdeatilsitemlistaddcountedit($params,$part_number_serach,$edit_id){
        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$edit_id);
        
        if($part_number_serach != 'NA'){
            $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number_serach);
        }

        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function fetchincomingdeatilsitemlistadddataedit($params,$part_number_serach,$edit_id){
        $this->db->select('*,'.TBL_INCOMING_DETAILS_ITEM.'.id as incoming_details_item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_INCOMING_DETAILS_ITEM.'.pre_vendor_po_number');
        $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$edit_id);
        if($part_number_serach != 'NA'){
          $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number',$part_number_serach);
        }
        $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                $data[$counter]['count'] = $counter+1;
                $data[$counter]['part_number'] = $value['part_number'];
                $data[$counter]['name'] = $value['name'];
                $data[$counter]['part_number_with_lot'] = $value['part_number'].' - '.$value['lot_no'];
                $data[$counter]['p_o_qty'] = $value['p_o_qty'];
                $data[$counter]['invoice_qty'] = $value['invoice_qty'];
                $data[$counter]['balance_qty'] = $value['balance_qty'];

                $data[$counter]['invoice_qty_in_kgs'] = $value['invoice_qty_in_kgs'];
                $data[$counter]['invoice_no'] = $value['invoice_no'];
                $data[$counter]['invoice_date'] = $value['invoice_date'];
                
                $data[$counter]['net_weight'] = $value['net_weight'];
                $data[$counter]['challan_no'] = $value['challan_no'];
                $data[$counter]['challan_date'] = $value['challan_date'];
                $data[$counter]['received_date'] = $value['received_date'];
                $data[$counter]['fg_material_gross_weight'] = $value['fg_material_gross_weight'];

                
                $data[$counter]['units'] = $value['units'];
                $data[$counter]['boxex_goni_bundle'] = $value['boxex_goni_bundle'];
                $data[$counter]['remarks'] = $value['remarks'];

                $data[$counter]['action'] = '';
                $data[$counter]['action'] .="<i style='font-size: x-large;cursor: pointer' data-id='".$value['incoming_details_item_id']."' class='fa fa-pencil-square-o editIncomingDetailsitem'  aria-hidden='true'></i>  &nbsp";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer' data-id='".$value['incoming_details_item_id']."' class='fa fa-trash-o deleteIncomingDetailsitem' aria-hidden='true'></i>   &nbsp ";
              
                $counter++; 
            }
        }

        return $data;
    }

    public function fetchALLVendorbillofmaterialdetails($edit_id){

        $this->db->select(TBL_BILL_OF_MATERIAL_VENDOR.'.id as vbom_id,'.TBL_BILL_OF_MATERIAL_VENDOR.'.bom_number,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.date as bom_date,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_name as vbm_vendor_name,'
        .TBL_VENDOR_PO_MASTER.'.po_number as vendor_po_number_po,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number,'
        .TBL_BUYER_PO_MASTER.'.sales_order_number,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_name,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_po_number,'

        .TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_po_date,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_delivery_date,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.bom_status,'

        .TBL_BILL_OF_MATERIAL_VENDOR.'.remark,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.status,'
        .TBL_BILL_OF_MATERIAL_VENDOR.'.incoming_details'
        
        );

        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR.'.vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR.'.buyer_po_number');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.status', 1);
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR.'.id', trim($edit_id));
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR);
        $data = $query->row_array();
        return $data;
    }

    public function fetchALLpreVendorpoitemListedit($edit_id){

        $this->db->select('*,'.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id as vendoritmid');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.pre_vendor_po_number');
        $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.pre_buyer_po_number');
        $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_bill_of_material_id',$edit_id);
        $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id','desc');
        $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR_ITEM);
        $data = $query->result_array();
        return $data;

    }

    public function fetchenstockrejectionformCount($params){
        $this->db->select('*');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_REJECTION_FORM.'.vendor_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REJECTION_FORM.'.vendor_po_number');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_REJECTION_FORM.".rejection_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REJECTION_FORM.".rejection_form_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REJECTION_FORM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_REJECTION_FORM.'.status', 1);
        $this->db->order_by(TBL_REJECTION_FORM.'.id','DESC');
        $query = $this->db->get(TBL_REJECTION_FORM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function fetchenstockrejectionformData($params){
        $this->db->select('*,'.TBL_VENDOR.'.vendor_name as ven_name,'.TBL_REJECTION_FORM.'.remark as rejectionremark,'.TBL_REJECTION_FORM.'.id as rejectionformid');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_REJECTION_FORM.'.vendor_id');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REJECTION_FORM.'.vendor_po_number');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_REJECTION_FORM.".rejection_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REJECTION_FORM.".rejection_form_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR.".vendor_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER.".po_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_REJECTION_FORM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_REJECTION_FORM.'.status', 1);
        $this->db->order_by(TBL_REJECTION_FORM.'.id','DESC');
        $query = $this->db->get(TBL_REJECTION_FORM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['rejection_number'] =$value['rejection_number'];
                $data[$counter]['date'] =$value['rejection_form_date'];
                $data[$counter]['vendor_id'] =$value['ven_name'];
                $data[$counter]['vendor_po_number'] = $value['po_number'];
                $data[$counter]['remark'] =$value['rejectionremark'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editrejetionform/".$value['rejectionformid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addrejectionformitemsdata/".$value['rejectionformid']."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-plus-circle' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['rejectionformid']."' class='fa fa-trash-o deleterejectionform' aria-hidden='true'></i>"; 

                $counter++; 
            }
        }
        return $data;
    }

    public function savenewrejectionform($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_REJECTION_FORM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_REJECTION_FORM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }

    public function getPreviousrejectionformnumber(){
        $this->db->select('rejection_number');
        $this->db->where(TBL_REJECTION_FORM.'.status', 1);
        $this->db->limit(1);
        $this->db->order_by(TBL_REJECTION_FORM.'.id','DESC');
        $query = $this->db->get(TBL_REJECTION_FORM);
        $rowarry = $query->row_array();
        return $rowarry;

    }

    public function getalldataofeditrejectionform($id){

        $this->db->select('*,'.TBL_VENDOR.'.ven_id,'.TBL_VENDOR.'.vendor_name,'.TBL_REJECTION_FORM.'.remark as rejection_form_remark,'.TBL_REJECTION_FORM.'.id as rejection_form_id,'.TBL_REJECTION_FORM.'.vendor_po_number as vpn');
        $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_REJECTION_FORM.'.vendor_po_number');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_REJECTION_FORM.'.vendor_id');
        // $this->db->where(TBL_VENDOR.'.status', 1);
        // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name =',"");
        $this->db->where(TBL_REJECTION_FORM.'.id',$id);
        // $this->db->group_by(TBL_VENDOR_PO_MASTER.'.vendor_name');
        $query = $this->db->get(TBL_REJECTION_FORM);
        $data = $query->row_array();
        return $data;

    }

    public function deleterejectionform($id){
        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_REJECTION_FORM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    public function deletejobworkitem($id){
        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_JOB_WORK_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

    

    public function getstockrejectionformitemcount($params,$vendor_po_id){
        $this->db->select('*');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_MASTER_ITEM.".rejection_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER_ITEM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->order_by(TBL_VENDOR_PO_MASTER_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getstockrejectionformitemdata($params,$vendor_po_id,$id){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as net_weight_fg');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_MASTER_ITEM.".rejection_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER_ITEM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id', $vendor_po_id);
        $this->db->order_by(TBL_VENDOR_PO_MASTER_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['part_number'] =$value['part_number'];
                $data[$counter]['name'] =$value['name'];
                $data[$counter]['remark'] =$value['item_remark'];
                $data[$counter]['action'] = '';

                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;color: #3c8dbc;' data-toggle='modal' data-target='#addNewModal'  rejection-form-id='".$id."' vendor-po-id='".$vendor_po_id."'  vendor_po_item_id='".$value['id']."' net_weight='".$value['net_weight_fg']."'  class='fa fa-plus-circle addrejectionitemdata' aria-hidden='true'></i>  &nbsp "; 
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewrejectionformitemdetails?rejection_form_id=".$id.'&vendor_po_item_id='.$value['id'].'&vendor_po_id='.$vendor_po_id."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-eye' aria-hidden='true'></i></a>   &nbsp ";

                // $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addrejectionformitemsdatamultientries?rejection_form_id=".$id.'&vendor_po_item_id='.$value['id'].'&vendor_po_id='.$vendor_po_id."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-plus-circle' aria-hidden='true'></i></a>   &nbsp ";
                // $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addrejectionformitemsdatamultientries?rejection_form_id=".$id.'&vendor_po_item_id='.$value['id'].'&vendor_po_id='.$vendor_po_id."' style='cursor: pointer;'><i style='font-size: x-large;cursor: pointer;' class='fa fa-plus-circle' aria-hidden='true'></i></a>   &nbsp ";
                 $counter++; 
            }
        }
        return $data;
    }

    public function getstockrejectionformitemdataitemdetailsforedit($vendor_po_id){

        $this->db->select(TBL_FINISHED_GOODS.'.net_weight as net_weight_fg');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_VENDOR_PO_MASTER_ITEM.".rejection_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_VENDOR_PO_MASTER_ITEM.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id', $vendor_po_id);
        $this->db->order_by(TBL_VENDOR_PO_MASTER_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $fetch_result = $query->result_array();

        return $fetch_result;

    }


    
    public function  saverejectedformitemdata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_REJECTION_FORM_REJECTED_ITEM, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_REJECTION_FORM_REJECTED_ITEM, $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }

    public function getfetch_stock_rejection_form_ttem_detailscount($params,$rejection_form_id,$vendor_po_item_id,$vendor_po_id){
        $this->db->select('*');
       // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');

        // if($params['search']['value'] != "") 
        // {
        //     $this->db->where("(".TBL_VENDOR_PO_MASTER_ITEM.".rejection_number LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where(TBL_VENDOR_PO_MASTER_ITEM.".remark LIKE '%".$params['search']['value']."%')");
        // }
        
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.item_id', $vendor_po_item_id);
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.rejection_form_id', $rejection_form_id);
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.vendor_po_id', $vendor_po_id);
        $this->db->order_by(TBL_REJECTION_FORM_REJECTED_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getfetch_stock_rejection_form_ttem_detailsdata($params,$rejection_form_id,$vendor_po_item_id,$vendor_po_id){
        $this->db->select('*,'.TBL_REJECTION_FORM_REJECTED_ITEM.'.id as rejection_item_id');
        // $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // if($params['search']['value'] != "") 
        // {
        //     $this->db->where("(".TBL_REJECTION_FORM_REJECTED_ITEM.".rejection_number LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where(TBL_REJECTION_FORM_REJECTED_ITEM.".remark LIKE '%".$params['search']['value']."%')");
        // }
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.item_id', $vendor_po_item_id);
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.rejection_form_id', $rejection_form_id);
        $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.vendor_po_id', $vendor_po_id);
        $this->db->order_by(TBL_REJECTION_FORM_REJECTED_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['rejected_reason'] =$value['rejected_reason'];
                $data[$counter]['qty_In_pcs'] =$value['qty_In_pcs'];
                $data[$counter]['qty_In_kgs'] =$value['qty_In_kgs'];
                $data[$counter]['remark'] =$value['remark'];
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['rejection_item_id']."' class='fa fa-pencil-square-o editrejectionformitem' aria-hidden='true'></i>  &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['rejection_item_id']."' class='fa fa-trash-o deleterejectionformitem' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }
        return $data;
    }
    
    public function deleterejectionformitem($id){
        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_REJECTION_FORM_REJECTED_ITEM)){
           return TRUE;
        }else{
           return FALSE;
        }
    }

  public function getStockdatadependsonvendorpo($vendor_po_number){
    $this->db->select('stock_id_number,stock_date');
    $this->db->where(TBL_STOCKS.'.vendor_po_number', $vendor_po_number);
    $this->db->where(TBL_STOCKS.'.status', 1);
    $query = $this->db->get(TBL_STOCKS);
    $data = $query->result_array();
    return $data;
  }


  public function getbuyerorderqtyfrompartnumber($vendor_po_number,$item_number){

    $this->db->select(TBL_BUYER_PO_MASTER_ITEM.'.order_oty');
    $this->db->join(TBL_VENDOR_PO_MASTER, TBL_VENDOR_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id');
    $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_VENDOR_PO_MASTER.'.buyer_po_number');
    $this->db->join(TBL_BUYER_PO_MASTER_ITEM.' as a ', 'a.buyer_po_id = '.TBL_BUYER_PO_MASTER.'.id');
    $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id', $item_number);
    $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id', $vendor_po_number);
    $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
    $data = $query->result_array();
    return $data;

  }

  public function getallcalculationrejecteditems(){

    // $this->db->select('sum(qty_In_pcs) as total_rejected_qty_in_pcs');
    // //$this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
    // // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
    // $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.status',1);
    // $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
    // $data = $query->result_array();
    // return $data;

    // $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');

    $this->db->select('sum(qty_In_pcs) as total_rejected_qty_in_pcs,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight,'.TBL_REJECTION_FORM_REJECTED_ITEM.'.qty_In_kgs');
    $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.id = '.TBL_REJECTION_FORM_REJECTED_ITEM.'.item_id');
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    $this->db->join(TBL_REJECTION_FORM, TBL_REJECTION_FORM.'.id = '.TBL_REJECTION_FORM_REJECTED_ITEM.'.rejection_form_id');
    $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.status', 1);
    $this->db->order_by(TBL_REJECTION_FORM_REJECTED_ITEM.'.id ','DESC');
    $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }


  public function getallcalculationexportitems(){

    // $this->db->select('sum(qty_In_pcs) as total_rejected_qty_in_pcs');
    // //$this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
    // // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
    // $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.status',1);
    // $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
    // $data = $query->result_array();
    // return $data;

    // $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');

        $this->db->select('sum('.TBL_PACKING_INSTRACTION_DETAILS.'.buyer_invoice_qty) as total_exp_qty_in_pcs,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');
        $this->db->join(TBL_PACKING_INSTRACTION, TBL_PACKING_INSTRACTION.'.id = '.TBL_PACKING_INSTRACTION_DETAILS.'.packing_instract_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_PACKING_INSTRACTION_DETAILS.'.part_number');
        $this->db->where(TBL_PACKING_INSTRACTION_DETAILS.'.status', 1);
        $this->db->order_by(TBL_PACKING_INSTRACTION_DETAILS.'.id','DESC');
        $query = $this->db->get(TBL_PACKING_INSTRACTION_DETAILS);
        $fetch_result = $query->result_array();
         return $fetch_result;

  }


  public function getallbalencecalculationexportitems(){

    // $this->db->select('sum(qty_In_pcs) as total_rejected_qty_in_pcs');
    // //$this->db->where(TBL_INCOMING_DETAILS_ITEM.'.part_number', $part_number);
    // // $this->db->where(TBL_VENDOR_PO_MASTER.'.supplier_name !=',"");
    // $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.status',1);
    // $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
    // $data = $query->result_array();
    // return $data;

    // $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as fg_net_weight');

        $this->db->select('sum('.TBL_STOCKS_ITEM.'.balence_qty_in_pcs) as balence_qty_in_pcs,sum('.TBL_STOCKS_ITEM.'.balence_qty_in_kgs) as balence_qty_in_kgs');
        $this->db->where(TBL_STOCKS_ITEM.'.status', 1);
        $this->db->order_by(TBL_STOCKS_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $fetch_result = $query->result_array();
         return $fetch_result;

  }


  public function getbuyeritemdataforitemedit($id){

    $this->db->select(TBL_BUYER_PO_MASTER_ITEM.'.id as buyer_item_id,'.TBL_FINISHED_GOODS.'.fin_id,'.TBL_FINISHED_GOODS.'.part_number,'.TBL_FINISHED_GOODS.'.name as description,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty,'.TBL_BUYER_PO_MASTER_ITEM.'.unit,'.TBL_BUYER_PO_MASTER_ITEM.'.rate,'.TBL_BUYER_PO_MASTER_ITEM.'.value');
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id');
    $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.id', $id);
    $this->db->order_by(TBL_BUYER_PO_MASTER_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_BUYER_PO_MASTER_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }


  public function getSupplieritemdataforitemedit($id){

    $this->db->select(TBL_SUPPLIER_PO_MASTER_ITEM.'.id as supplier_item_id,'.TBL_RAWMATERIAL.'.raw_id,'.TBL_RAWMATERIAL.'.part_number,'
    .TBL_RAWMATERIAL.'.type_of_raw_material as description,'
    .TBL_RAWMATERIAL.'.diameter as diameter,'
    .TBL_RAWMATERIAL.'.sitting_size,'
    .TBL_RAWMATERIAL.'.thickness,'
    .TBL_RAWMATERIAL.'.hex_a_f,'
    .TBL_RAWMATERIAL.'.HSN_code,'
    .TBL_RAWMATERIAL.'.length,'
    .TBL_RAWMATERIAL.'.gross_weight,'
    .TBL_RAWMATERIAL.'.net_weight,'
    .TBL_RAWMATERIAL.'.sac,'
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.description_1,'
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.description_2,'
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.item_remark,'    
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty,'
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.vendor_qty,'
    
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.unit,'
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.rate,'
    .TBL_SUPPLIER_PO_MASTER_ITEM.'.value');
    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id');
    $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.id', $id);
    $this->db->order_by(TBL_SUPPLIER_PO_MASTER_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_SUPPLIER_PO_MASTER_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }

  public function getVendoritemdataforitemedit($id){

    $this->db->select(TBL_VENDOR_PO_MASTER_ITEM.'.id as vendor_po_item_id,'.TBL_FINISHED_GOODS.'.fin_id,'.TBL_FINISHED_GOODS.'.part_number,'
    .TBL_FINISHED_GOODS.'.name as description,'
    // .TBL_FINISHED_GOODS.'.diameter as diameter,'
    // .TBL_FINISHED_GOODS.'.sitting_size,'
    // .TBL_FINISHED_GOODS.'.thickness,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.rm_type,'
    .TBL_FINISHED_GOODS.'.hsn_code,'
    .TBL_FINISHED_GOODS.'.drawing_number,'
    .TBL_FINISHED_GOODS.'.groass_weight,'
    .TBL_FINISHED_GOODS.'.net_weight,'
    .TBL_FINISHED_GOODS.'.sac,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.description_1,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.description_2,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.item_remark,'    
    .TBL_VENDOR_PO_MASTER_ITEM.'.order_oty,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.vendor_qty,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.unit,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.rate,'
    .TBL_VENDOR_PO_MASTER_ITEM.'.value');
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.id', $id);
    $this->db->order_by(TBL_VENDOR_PO_MASTER_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }

  public function getSupplierpoconfimationitemedit($id){

    $this->db->select(
     TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id as supplier_confirmation_po_item_id,'
    .TBL_RAWMATERIAL.'.raw_id,'
    .TBL_RAWMATERIAL.'.part_number,'
    .TBL_RAWMATERIAL.'.type_of_raw_material as description,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.order_oty as order_oty,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.sent_qty as sent_qty,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.unit as unit,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.short_excess as short_excess,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.sent_qty_pcs as sent_qty_pcs,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.vendor_id as vendor_id,'
    .TBL_VENDOR.'.vendor_name,'
    .TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.vendor_qty'

    );
    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.part_number_id');
    $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.vendor_id');
    $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id', $id);
    $this->db->order_by(TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }

  public function getvendorpoconfirmationitemedit($id){
    $this->db->select(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id as vendor_po_confirmation_item_id,'
    .TBL_FINISHED_GOODS.'.fin_id,'
    .TBL_FINISHED_GOODS.'.part_number,'
    .TBL_FINISHED_GOODS.'.name as description,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.vendor_qty as vendor_qty,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.order_qty as order_qty,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.row_material_recived_qty as row_material_recived_qty,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.finished_good_recived_qty as finished_good_recived_qty,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.gross_weight as gross_weight,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.expected_qty as expected_qty,'
    .TBL_VENDOR_PO_CONFIRMATION_ITEM.'.item_remark as item_remark,'

    // .TBL_FINISHED_GOODS.'.sitting_size,'
    // .TBL_FINISHED_GOODS.'.thickness,'
    );
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.part_number_id');
    $this->db->where(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id', $id);
    $this->db->order_by(TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_VENDOR_PO_CONFIRMATION_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }

  public function getIncomingDetailitemedit($id){

    $this->db->select(TBL_INCOMING_DETAILS_ITEM.'.id as incoiming_details_item_id,'
    .TBL_FINISHED_GOODS.'.fin_id,'
    .TBL_FINISHED_GOODS.'.part_number,'
    .TBL_FINISHED_GOODS.'.name as description,'
    .TBL_INCOMING_DETAILS_ITEM.'.p_o_qty as p_o_qty,'
    .TBL_INCOMING_DETAILS_ITEM.'.net_weight as net_weight,'
    .TBL_INCOMING_DETAILS_ITEM.'.invoice_no as invoice_no,'
    .TBL_INCOMING_DETAILS_ITEM.'.invoice_date as invoice_date,'
    .TBL_INCOMING_DETAILS_ITEM.'.challan_no as challan_no,'
    .TBL_INCOMING_DETAILS_ITEM.'.challan_date as challan_date,'
    .TBL_INCOMING_DETAILS_ITEM.'.received_date as received_date,'
    .TBL_INCOMING_DETAILS_ITEM.'.invoice_qty as invoice_qty,'
    .TBL_INCOMING_DETAILS_ITEM.'.invoice_qty_in_kgs as invoice_qty_in_kgs,'
    .TBL_INCOMING_DETAILS_ITEM.'.balance_qty as balance_qty,'
    .TBL_INCOMING_DETAILS_ITEM.'.fg_material_gross_weight as fg_material_gross_weight,'
    .TBL_INCOMING_DETAILS_ITEM.'.units as units,'
    .TBL_INCOMING_DETAILS_ITEM.'.boxex_goni_bundle as boxex_goni_bundle,'
    .TBL_INCOMING_DETAILS_ITEM.'.lot_no as lot_no,'
    .TBL_INCOMING_DETAILS_ITEM.'.remarks as remarks,'
    .TBL_INCOMING_DETAILS_ITEM.'.part_number as part_number,'

    // .TBL_FINISHED_GOODS.'.sitting_size,'
    // .TBL_FINISHED_GOODS.'.thickness,'
    );
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
    $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.id', $id);
    $this->db->order_by(TBL_INCOMING_DETAILS_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }


  public function geteditBillofmaterialitem($id){

        $this->db->select(
            TBL_BILL_OF_MATERIAL_ITEM.'.id as bill_of_material_item_id,'
           .TBL_FINISHED_GOODS.'.fin_id as  raw_id,'
           .TBL_RAWMATERIAL.'.part_number,'
           .TBL_FINISHED_GOODS.'.name as description,'
           .TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty as rmsupplier_order_qty,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.rm_actual_aty as rm_actual_aty,'
           .TBL_RAWMATERIAL.'.type_of_raw_material as rm_type,'
           .TBL_RAWMATERIAL.'.sitting_size,'
           .TBL_RAWMATERIAL.'.thickness,'
           .TBL_RAWMATERIAL.'.diameter,'
           .TBL_RAWMATERIAL.'.thickness,'
           .TBL_RAWMATERIAL.'.hex_a_f,'
           .TBL_RAWMATERIAL.'.length,'
           .TBL_RAWMATERIAL.'.gross_weight,'
           .TBL_RAWMATERIAL.'.net_weight,'
           .TBL_RAWMATERIAL.'.sac,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.expected_qty as expected_qty,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.vendor_actual_recived_qty as vendor_actual_recived_qty,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.net_weight_per_pcs as net_weight_per_pcs,'
           
           .TBL_BILL_OF_MATERIAL_ITEM.'.total_neight_weight as total_neight_weight,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.short_excess as short_excess,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.scrap_in_kgs as scrap_in_kgs,'
           
           .TBL_BILL_OF_MATERIAL_ITEM.'.actual_scrap_received_in_kgs as actual_scrap_recived,'
           .TBL_BILL_OF_MATERIAL_ITEM.'.remark as remark,'
       
           );
           //$this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_BILL_OF_MATERIAL_ITEM.'.part_number');
           $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_ITEM.'.part_number');
           $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
           $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
           $this->db->where(TBL_BILL_OF_MATERIAL_ITEM.'.id', $id);
           $query = $this->db->get(TBL_BILL_OF_MATERIAL_ITEM);
           $fetch_result = $query->result_array();
           return $fetch_result;

  }


  public function geteditVendorbillofmaterialpoitem($id){

    $this->db->select(
        TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id as vendor_bill_of_material_item_id,'
        .TBL_FINISHED_GOODS.'.fin_id,'
        .TBL_FINISHED_GOODS.'.part_number,'
        .TBL_FINISHED_GOODS.'.name as description,'
        .TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.buyer_order_qty as buyer_order_qty,'
        .TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_order_qty as vendor_order_qty,'
        .TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.vendor_received_qty as vendor_received_qty,'

        .TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.balenced_qty as balenced_qty,'
        .TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.item_remark as item_remark,'
        
        

    );
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.part_number_id');
    $this->db->where(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id', $id);
    $this->db->order_by(TBL_BILL_OF_MATERIAL_VENDOR_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_BILL_OF_MATERIAL_VENDOR_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;

  }


  public function geteditDebitnoteitemedit($id){

    $this->db->select(
         TBL_DEBIT_NOTE_ITEM.'.id  as debit_note_item_id,'
        .TBL_RAWMATERIAL.'.raw_id,'
        .TBL_RAWMATERIAL.'.part_number,'
        .TBL_RAWMATERIAL.'.type_of_raw_material as description,'
        .TBL_DEBIT_NOTE_ITEM.'.invoice_no as invoice_no,'
        .TBL_DEBIT_NOTE_ITEM.'.invoice_date as invoice_date,'
        .TBL_DEBIT_NOTE_ITEM.'.invoice_qty as invoice_qty,'
        .TBL_DEBIT_NOTE_ITEM.'.ok_qty as ok_qty,'
        .TBL_DEBIT_NOTE_ITEM.'.less_quantity as less_quantity,'
        .TBL_DEBIT_NOTE_ITEM.'.rejected_quantity as rejected_quantity,'
        .TBL_DEBIT_NOTE_ITEM.'.received_quantity as received_quantity,'
        .TBL_DEBIT_NOTE_ITEM.'.p_and_f_charges as p_and_f_charges,'
        .TBL_DEBIT_NOTE_ITEM.'.rate as rate,'
        .TBL_DEBIT_NOTE_ITEM.'.gst_rate as gst_rate,'
        .TBL_DEBIT_NOTE_ITEM.'.debit_amount as debit_amount,'
        .TBL_DEBIT_NOTE_ITEM.'.remark as remark,'

        .TBL_DEBIT_NOTE_ITEM.'.SGST_value as SGST_value,'
        .TBL_DEBIT_NOTE_ITEM.'.CGST_value as CGST_value,'
        .TBL_DEBIT_NOTE_ITEM.'.IGST_value as IGST_value,'

        .TBL_DEBIT_NOTE_ITEM.'.SGST_value_ok_val as SGST_value_ok_val,'
        .TBL_DEBIT_NOTE_ITEM.'.CGST_value_ok_val as CGST_value_ok_val,'
        .TBL_DEBIT_NOTE_ITEM.'.IGST_value_ok_val as IGST_value_ok_val,'

        

        
    );
    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
    $this->db->where(TBL_DEBIT_NOTE_ITEM.'.id', $id);
    $this->db->order_by(TBL_DEBIT_NOTE_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_DEBIT_NOTE_ITEM);
    $fetch_result = $query->result_array();
    // return $fetch_result;

    if(count($fetch_result) > 0)
    {
      return $fetch_result;   
    }else{

        $this->db->select(
            TBL_DEBIT_NOTE_ITEM.'.id  as debit_note_item_id,'
           .TBL_FINISHED_GOODS.'.fin_id as raw_id,'
           .TBL_FINISHED_GOODS.'.part_number,'
           .TBL_FINISHED_GOODS.'.name as description,'
           .TBL_DEBIT_NOTE_ITEM.'.invoice_no as invoice_no,'
           .TBL_DEBIT_NOTE_ITEM.'.invoice_date as invoice_date,'
           .TBL_DEBIT_NOTE_ITEM.'.invoice_qty as invoice_qty,'
           .TBL_DEBIT_NOTE_ITEM.'.ok_qty as ok_qty,'
           .TBL_DEBIT_NOTE_ITEM.'.less_quantity as less_quantity,'
           .TBL_DEBIT_NOTE_ITEM.'.rejected_quantity as rejected_quantity,'
           .TBL_DEBIT_NOTE_ITEM.'.received_quantity as received_quantity,'
           .TBL_DEBIT_NOTE_ITEM.'.p_and_f_charges as p_and_f_charges,'
           .TBL_DEBIT_NOTE_ITEM.'.rate as rate,'
           .TBL_DEBIT_NOTE_ITEM.'.gst_rate as gst_rate,'
           .TBL_DEBIT_NOTE_ITEM.'.debit_amount as debit_amount,'
           .TBL_DEBIT_NOTE_ITEM.'.remark as remark,'
   
           .TBL_DEBIT_NOTE_ITEM.'.SGST_value as SGST_value,'
           .TBL_DEBIT_NOTE_ITEM.'.CGST_value as CGST_value,'
           .TBL_DEBIT_NOTE_ITEM.'.IGST_value as IGST_value,'
   
           .TBL_DEBIT_NOTE_ITEM.'.SGST_value_ok_val as SGST_value_ok_val,'
           .TBL_DEBIT_NOTE_ITEM.'.CGST_value_ok_val as CGST_value_ok_val,'
           .TBL_DEBIT_NOTE_ITEM.'.IGST_value_ok_val as IGST_value_ok_val,'
   
           
   
           
       );
       $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_DEBIT_NOTE_ITEM.'.part_number');
       $this->db->where(TBL_DEBIT_NOTE_ITEM.'.id', $id);
       $this->db->order_by(TBL_DEBIT_NOTE_ITEM.'.id','DESC');
       $query_1 = $this->db->get(TBL_DEBIT_NOTE_ITEM);
       $fetch_result_1 = $query_1->result_array();

       return $fetch_result_1;

    }

  }


  public function geteditjobworkitem($id){

    $this->db->select(
        TBL_JOB_WORK_ITEM.'.id as jobwork_item_id,'
        .TBL_FINISHED_GOODS.'.fin_id as raw_id,'
        .TBL_FINISHED_GOODS.'.part_number,'
        .TBL_FINISHED_GOODS.'.name as description,'
        .TBL_RAWMATERIAL.'.sac as sac,'
        .TBL_RAWMATERIAL.'.HSN_code as HSN_code,'
        .TBL_RAWMATERIAL.'.sitting_size as sitting_size,'
        .TBL_JOB_WORK_ITEM.'.vendor_qty as vendor_qty,'
        .TBL_JOB_WORK_ITEM.'.rm_actual_qty as rm_actual_qty,'
        .TBL_JOB_WORK_ITEM.'.unit as unit,'
        .TBL_JOB_WORK_ITEM.'.ram_rate as ram_rate,'
        .TBL_JOB_WORK_ITEM.'.value as value,'
        .TBL_JOB_WORK_ITEM.'.packing_forwarding as packing_forwarding,'
        .TBL_JOB_WORK_ITEM.'.total as total,'
        .TBL_JOB_WORK_ITEM.'.gst as gst,'
        .TBL_JOB_WORK_ITEM.'.gst_rate as gst_rate,'
        .TBL_JOB_WORK_ITEM.'.grand_total as grand_total,'
        .TBL_JOB_WORK_ITEM.'.item_remark as item_remark,'

    );
    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_JOB_WORK_ITEM.'.part_number_id');
    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
    $this->db->where(TBL_JOB_WORK_ITEM.'.id', $id);
    $this->db->order_by(TBL_JOB_WORK_ITEM.'.id','DESC');
    $query = $this->db->get(TBL_JOB_WORK_ITEM);
    $fetch_result = $query->result_array();
    return $fetch_result;


  }


  public function geteditReworkRejectionitem($id){


    $this->db->select('pre_vendor_supplier_name,pre_vendor_supplier_name');
    $this->db->where(TBL_REWORK_REJECTION_ITEM.'.id',$id);
    $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
    $pre_vendor_supplier_name = $query->result_array();

    foreach ($pre_vendor_supplier_name as $key_vendor_supplier_name => $value_vendor_supplier_name) {

        if($value_vendor_supplier_name['pre_vendor_supplier_name']=='vendor'){

            if($value_vendor_supplier_name['pre_supplier_po_number']){


                $this->db->select(
                    TBL_REWORK_REJECTION_ITEM.'.id as rework_rejection_item_id,'
                    .TBL_FINISHED_GOODS.'.fin_id as raw_id,'
                    .TBL_FINISHED_GOODS.'.part_number,'
                    .TBL_FINISHED_GOODS.'.name as description,'
                    .TBL_RAWMATERIAL.'.type_of_raw_material as tp,'
                    .TBL_FINISHED_GOODS.'.sac as sac,'
                    .TBL_FINISHED_GOODS.'.hsn_code as HSN_code,'
                    // .TBL_FINISHED_GOODS.'.sitting_size as sitting_size,'
                    .TBL_REWORK_REJECTION_ITEM.'.rejection_rework_reason,'
                    .TBL_REWORK_REJECTION_ITEM.'.qty,'
                    .TBL_REWORK_REJECTION_ITEM.'.rate,'
                    .TBL_REWORK_REJECTION_ITEM.'.value,'
                    .TBL_REWORK_REJECTION_ITEM.'.row_material_cost,'
                    .TBL_REWORK_REJECTION_ITEM.'.gst_rate,'
                    .TBL_REWORK_REJECTION_ITEM.'.gst_value,'
                    .TBL_REWORK_REJECTION_ITEM.'.grand_total,'
                    .TBL_REWORK_REJECTION_ITEM.'.item_remark,'
                    .TBL_RAWMATERIAL.'.type_of_raw_material as tppp,'
                    

                );
                $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                $this->db->where(TBL_REWORK_REJECTION_ITEM.'.id', $id);
                $this->db->order_by(TBL_REWORK_REJECTION_ITEM.'.id','DESC');
                $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                $fetch_result = $query->result_array();
                return $fetch_result;


            }else{


                $this->db->select(
                    TBL_REWORK_REJECTION_ITEM.'.id as rework_rejection_item_id,'
                    .TBL_FINISHED_GOODS.'.fin_id as raw_id,'
                    .TBL_FINISHED_GOODS.'.part_number,'
                    .TBL_FINISHED_GOODS.'.name as description,'
                    // .TBL_FINISHED_GOODS.'.type_of_raw_material,'
                    .TBL_FINISHED_GOODS.'.sac as sac,'
                    .TBL_FINISHED_GOODS.'.hsn_code as HSN_code,'
                    // .TBL_FINISHED_GOODS.'.sitting_size as sitting_size,'
                    .TBL_REWORK_REJECTION_ITEM.'.rejection_rework_reason,'
                    .TBL_REWORK_REJECTION_ITEM.'.qty,'
                    .TBL_REWORK_REJECTION_ITEM.'.rate,'
                    .TBL_REWORK_REJECTION_ITEM.'.value,'
                    .TBL_REWORK_REJECTION_ITEM.'.row_material_cost,'
                    .TBL_REWORK_REJECTION_ITEM.'.gst_rate,'
                    .TBL_REWORK_REJECTION_ITEM.'.gst_value,'
                    .TBL_REWORK_REJECTION_ITEM.'.grand_total,'
                    .TBL_REWORK_REJECTION_ITEM.'.item_remark,'
                    

                );
                $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                $this->db->where(TBL_REWORK_REJECTION_ITEM.'.id', $id);
                $this->db->order_by(TBL_REWORK_REJECTION_ITEM.'.id','DESC');
                $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                $fetch_result = $query->result_array();
                return $fetch_result;



            }
        }else{


                    $this->db->select(
                    TBL_REWORK_REJECTION_ITEM.'.id as rework_rejection_item_id,'
                    .TBL_RAWMATERIAL.'.raw_id,'
                    .TBL_RAWMATERIAL.'.part_number,'
                    .TBL_RAWMATERIAL.'.type_of_raw_material as description,'
                    .TBL_RAWMATERIAL.'.type_of_raw_material as tp,'
                    .TBL_RAWMATERIAL.'.sac as sac,'
                    .TBL_RAWMATERIAL.'.HSN_code as HSN_code,'
                    .TBL_RAWMATERIAL.'.sitting_size as sitting_size,'
                    .TBL_REWORK_REJECTION_ITEM.'.rejection_rework_reason,'
                    .TBL_REWORK_REJECTION_ITEM.'.qty,'
                    .TBL_REWORK_REJECTION_ITEM.'.rate,'
                    .TBL_REWORK_REJECTION_ITEM.'.value,'
                    .TBL_REWORK_REJECTION_ITEM.'.row_material_cost,'
                    .TBL_REWORK_REJECTION_ITEM.'.gst_rate,'
                    .TBL_REWORK_REJECTION_ITEM.'.gst_value,'
                    .TBL_REWORK_REJECTION_ITEM.'.grand_total,'
                    .TBL_REWORK_REJECTION_ITEM.'.item_remark,'
                    // .TBL_RAWMATERIAL.'.type_of_raw_material as tppp,'

                );
                $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_REWORK_REJECTION_ITEM.'.part_number');
                $this->db->where(TBL_REWORK_REJECTION_ITEM.'.id', $id);
                $this->db->order_by(TBL_REWORK_REJECTION_ITEM.'.id','DESC');
                $query = $this->db->get(TBL_REWORK_REJECTION_ITEM);
                $fetch_result = $query->result_array();
                return $fetch_result;

        }
    }
  }


  public function geteditqualityrecordsitem($id){

            $this->db->select(
                TBL_QUALITY_RECORDS_ITEM.'.id as quality_record_item_id,'
            .TBL_FINISHED_GOODS.'.fin_id as part_number_id,'
            .TBL_FINISHED_GOODS.'.part_number,'
            .TBL_FINISHED_GOODS.'.name as description,'
            .TBL_FINISHED_GOODS.'.name as type_of_raw_material,'
            .TBL_FINISHED_GOODS.'.sac as sac,'
            .TBL_FINISHED_GOODS.'.hsn_code as HSN_code,'
            //.TBL_FINISHED_GOODS.'.sitting_size as sitting_size,'
            .TBL_QUALITY_RECORDS_ITEM.'.inspection_report_no,'
            .TBL_QUALITY_RECORDS_ITEM.'.inspection_report_date,'
            .TBL_QUALITY_RECORDS_ITEM.'.lot_qty,'
            .TBL_QUALITY_RECORDS_ITEM.'.inspected_by,'
            .TBL_QUALITY_RECORDS_ITEM.'.remark,'
        );
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_QUALITY_RECORDS_ITEM.'.part_number');
        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.id', $id);
        // $this->db->order_by(TBL_QUALITY_RECORDS_ITEM.'.id','DESC');
        $query2 = $this->db->get(TBL_QUALITY_RECORDS_ITEM);
        $fetch_result2 = $query2->result_array();
        return $fetch_result2;

    if(count($fetch_result) > 0)
    {
      return $fetch_result;   
    }else{

            $this->db->select(
                TBL_QUALITY_RECORDS_ITEM.'.id as quality_record_item_id,'
            .TBL_RAWMATERIAL.'.raw_id as part_number_id,'
            .TBL_RAWMATERIAL.'.part_number,'
            .TBL_RAWMATERIAL.'.type_of_raw_material as description,'
            .TBL_RAWMATERIAL.'.type_of_raw_material,'
            .TBL_RAWMATERIAL.'.sac as sac,'
            .TBL_RAWMATERIAL.'.HSN_code as HSN_code,'
            .TBL_RAWMATERIAL.'.sitting_size as sitting_size,'
            .TBL_QUALITY_RECORDS_ITEM.'.inspection_report_no,'
            .TBL_QUALITY_RECORDS_ITEM.'.inspection_report_date,'
            .TBL_QUALITY_RECORDS_ITEM.'.lot_qty,'
            .TBL_QUALITY_RECORDS_ITEM.'.inspected_by,'
            .TBL_QUALITY_RECORDS_ITEM.'.remark,'
        );
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_QUALITY_RECORDS_ITEM.'.part_number');
        $this->db->where(TBL_QUALITY_RECORDS_ITEM.'.id', $id);
        //$this->db->order_by(TBL_QUALITY_RECORDS_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_QUALITY_RECORDS_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;

       
    }

  }


  public function geteditrejectionformitem( $id){

   $this->db->select('id,rejected_reason,qty_In_pcs,qty_in_kgs,remark');
   $this->db->where(TBL_REJECTION_FORM_REJECTED_ITEM.'.id', $id);
   $this->db->order_by(TBL_REJECTION_FORM_REJECTED_ITEM.'.id','DESC');
   $query = $this->db->get(TBL_REJECTION_FORM_REJECTED_ITEM);
   $fetch_result = $query->result_array();
   return $fetch_result;

  }
  

  public function geteditpackinginstractionsubitem( $id){

        $this->db->select('*');
        $this->db->where(TBL_PACKING_INSTRACTION_DETAILS.'.id', $id);
        $this->db->order_by(TBL_PACKING_INSTRACTION_DETAILS.'.id','DESC');
        $query = $this->db->get(TBL_PACKING_INSTRACTION_DETAILS);
        $fetch_result = $query->result_array();
        return $fetch_result;
    }


   public function geteditStockformitem($id){
    
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.name as description,'.TBL_STOCKS_ITEM.'.id as item_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_STOCKS_ITEM.'.part_number');
        $this->db->where(TBL_STOCKS_ITEM.'.id', $id);
        $this->db->order_by(TBL_STOCKS_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_STOCKS_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;

   }
   
  

   public function geteditScrpareturnid($id){
    
        $this->db->select('*');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
        $this->db->where(TBL_SCRAP_RETURN_ITEM.'.id', $id);
        $this->db->order_by(TBL_SCRAP_RETURN_ITEM.'.id','DESC');
        $query = $this->db->get(TBL_SCRAP_RETURN_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;

   }
   

   public function geteditPODitemedit($id){

    $this->db->select('pre_vendor_supplier_name');
    $this->db->where(TBL_POD_ITEM.'.id',$id);
    $query = $this->db->get(TBL_POD_ITEM);
    $pre_vendor_supplier_name = $query->result_array();
   
    foreach ($pre_vendor_supplier_name as $key_vendor_supplier_name => $value_vendor_supplier_name) {

        // print_r($value_vendor_supplier_name);
        // exit;

        if($value_vendor_supplier_name['pre_vendor_supplier_name']=='vendor'){

            if($value_vendor_supplier_name['pre_supplier_po_number']){

                $this->db->select(TBL_POD_ITEM.'.id as poditems_id,
                '.TBL_FINISHED_GOODS.'.fin_id as raw_id,
                '.TBL_POD_ITEM.'.order_qty,
                '.TBL_POD_ITEM.'.lot_no,
                '.TBL_POD_ITEM.'.qty_recived,
                '.TBL_POD_ITEM.'.unit,
                '.TBL_POD_ITEM.'.bill_no,
                '.TBL_POD_ITEM.'.bill_date,
                '.TBL_POD_ITEM.'.short_excess_qty,
                '.TBL_POD_ITEM.'.remark,
                
                '.TBL_FINISHED_GOODS.'.name as description');
                $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_POD_ITEM.'.part_number');
                $this->db->where(TBL_POD_ITEM.'.id', $id);
                $this->db->order_by(TBL_POD_ITEM.'.id','DESC');
                $query = $this->db->get(TBL_POD_ITEM);
                $fetch_result = $query->result_array();
                return $fetch_result;

            }else{

                $this->db->select(TBL_POD_ITEM.'.id as poditems_id,
                '.TBL_FINISHED_GOODS.'.fin_id as raw_id,
                '.TBL_POD_ITEM.'.order_qty,
                '.TBL_POD_ITEM.'.lot_no,
                '.TBL_POD_ITEM.'.qty_recived,
                '.TBL_POD_ITEM.'.unit,
                '.TBL_POD_ITEM.'.bill_no,
                '.TBL_POD_ITEM.'.bill_date,
                '.TBL_POD_ITEM.'.short_excess_qty,
                '.TBL_POD_ITEM.'.remark,
                
                '.TBL_FINISHED_GOODS.'.name as description');
                $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_POD_ITEM.'.part_number');
                $this->db->where(TBL_POD_ITEM.'.id', $id);
                $this->db->order_by(TBL_POD_ITEM.'.id','DESC');
                $query = $this->db->get(TBL_POD_ITEM);
                $fetch_result = $query->result_array();
                return $fetch_result;
            }
            
            
        }else{

            $this->db->select(TBL_POD_ITEM.'.id as poditems_id,
            '.TBL_RAWMATERIAL.'.raw_id,
            '.TBL_POD_ITEM.'.order_qty,
            '.TBL_POD_ITEM.'.lot_no,
            '.TBL_POD_ITEM.'.qty_recived,
            '.TBL_POD_ITEM.'.unit,
            '.TBL_POD_ITEM.'.bill_no,
            '.TBL_POD_ITEM.'.bill_date,
            '.TBL_POD_ITEM.'.short_excess_qty,
            '.TBL_POD_ITEM.'.remark,
            
            '.TBL_RAWMATERIAL.'.type_of_raw_material as description');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_POD_ITEM.'.part_number');
            $this->db->where(TBL_POD_ITEM.'.id', $id);
            $this->db->order_by(TBL_POD_ITEM.'.id','DESC');
            $query = $this->db->get(TBL_POD_ITEM);
            $fetch_result = $query->result_array();
            return $fetch_result;

        }           
    }

   }



   public function geteditChallanformitem($id,$vendor_po_number,$vendor_supplier_name){

            if($vendor_supplier_name=='vendor'){
                $this->db->select('supplier_po_number');
                $this->db->where(TBL_VENDOR_PO_MASTER.'.id', $vendor_po_number);
                $supplier_po_number_query = $this->db->get(TBL_VENDOR_PO_MASTER);
                $supplier_po_number_result = $supplier_po_number_query->row_array();
    
                if($supplier_po_number_result['supplier_po_number']){

        
                    $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as raw_id,'.TBL_FINISHED_GOODS.'.name as description,'.TBL_CHALLAN_FORM_ITEM.'.id  as challan_form_item_id,'.TBL_FINISHED_GOODS.'.hsn_code as HSN_code1,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrow5gk,'.TBL_CHALLAN_FORM_ITEM.'.unit as unit1');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.id', $id);
                    $query10 = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                    $fetch_result10 = $query10->result_array();
                    return $fetch_result10;
    
                }else{
    
                    $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as raw_id,'.TBL_FINISHED_GOODS.'.name as description,'.TBL_CHALLAN_FORM_ITEM.'.id  as challan_form_item_id,'.TBL_FINISHED_GOODS.'.hsn_code as HSN_code1,'.TBL_CHALLAN_FORM_ITEM.'.unit as unit1');
                    $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                    $this->db->where(TBL_CHALLAN_FORM_ITEM.'.id', $id);
                    $this->db->order_by(TBL_CHALLAN_FORM_ITEM.'.id','DESC');
                    $query3 = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                    $fetch_result3 = $query3->result_array();
                    return $fetch_result3;
    
                }

            }else{
                $this->db->select('*,'.TBL_RAWMATERIAL.'.raw_id as raw_id,'.TBL_RAWMATERIAL.'.type_of_raw_material as description,'.TBL_CHALLAN_FORM_ITEM.'.id  as challan_form_item_id,'.TBL_RAWMATERIAL.'.HSN_code as HSN_code1,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrow5gk,'.TBL_CHALLAN_FORM_ITEM.'.unit as unit1');
                $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_CHALLAN_FORM_ITEM.'.part_number');
                $this->db->where(TBL_CHALLAN_FORM_ITEM.'.id', $id);
                $this->db->order_by(TBL_CHALLAN_FORM_ITEM.'.id','DESC');
                $query3 = $this->db->get(TBL_CHALLAN_FORM_ITEM);
                $fetch_result3 = $query3->result_array();
                return $fetch_result3;
            }


          

}



   public function getVendoritemonlyforpod($vendor_po_number,$flag){

        $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);

        if($check_if_supplier_exist['supplier_po_number']){
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;
        }else{
            // $this->db->select('*,'.TBL_RAWMATERIAL.'.raw_id as fin_id');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // $this->db->where(TBL_RAWMATERIAL.'.status',1);
            // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            // $data = $query->result_array();
            // return $data;

            $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;


        }
            
   }


   
   public function getVendoritemonlyforchallan($vendor_po_number,$flag){

    $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);

    if($check_if_supplier_exist['supplier_po_number']){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;
    }else{
        // $this->db->select('*,'.TBL_RAWMATERIAL.'.raw_id as fin_id');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->where(TBL_RAWMATERIAL.'.status',1);
        // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        // $data = $query->result_array();
        // return $data;

        $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;


    }
        
   }


   public function getVendoritemonlyforreworkrejection($vendor_po_number,$flag){


    if($flag=='vendor'){

        $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);

        if($check_if_supplier_exist['supplier_po_number']){
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;
        }else{
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;


        }
    }else{

        $this->db->select('*,'.TBL_RAWMATERIAL.'.raw_id as fin_id');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        $this->db->where(TBL_RAWMATERIAL.'.status',1);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

    }

    // $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);

    // if($check_if_supplier_exist['supplier_po_number']){
    //     $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
    //     $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    //     // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
    //     $this->db->where(TBL_FINISHED_GOODS.'.status',1);
    //     //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
    //     $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
    //     $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
    //     $data = $query->result_array();
    //     return $data;
    // }else{
    //     // $this->db->select('*,'.TBL_RAWMATERIAL.'.raw_id as fin_id');
    //     // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    //     // //$this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    //     // $this->db->where(TBL_RAWMATERIAL.'.status',1);
    //     // //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
    //     // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
    //     // $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
    //     // $data = $query->result_array();
    //     // return $data;

    //     $this->db->select('*,'.TBL_FINISHED_GOODS.'.fin_id as fin_id');
    //     $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
    //     // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
    //     $this->db->where(TBL_FINISHED_GOODS.'.status',1);
    //     //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
    //     $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
    //     $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
    //     $data = $query->result_array();
    //     return $data;


    // }
        
   }


   public function getSuppliergoodsreworkrejectionvendorpod($part_number,$vendor_po_number,$vendor_supplier_name){

    $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);
    if($check_if_supplier_exist['supplier_po_number']){


        // $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_RAWMATERIAL.'.status',1);
        // // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        // $query = $this->db->get(TBL_RAWMATERIAL);
        // $data = $query->result_array();
        // return $data;

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;



    }else{

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

       

    }

   }



   public function getSuppliergoodsreworkrejectionvendorchallan($part_number,$vendor_po_number,$vendor_supplier_name){


    $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);
    if($check_if_supplier_exist['supplier_po_number']){

        // $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_RAWMATERIAL.'.status',1);
        // // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        // $query = $this->db->get(TBL_RAWMATERIAL);
        // $data = $query->result_array();
        // return $data;

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
      
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
          $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;



    }else{

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        //$this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

       

    }

   }


   public function getSuppliergoodsreworkrejectionvendorreworkrejection($part_number,$vendor_po_number,$vendor_supplier_name){


    $check_if_supplier_exist =  $this->chekc_if_supplie_name_exits($vendor_po_number);
    if($check_if_supplier_exist['supplier_po_number']){

        // $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_RAWMATERIAL.'.status',1);
        // // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        // $query = $this->db->get(TBL_RAWMATERIAL);
        // $data = $query->result_array();
        // return $data;

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;



    }else{

        // $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        // $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        // $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        // $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        // $query = $this->db->get(TBL_FINISHED_GOODS);
        // $data = $query->result_array();
        // return $data;

        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as typeofrawmaterial,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
        // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
        //$this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
        $data = $query->result_array();
        return $data;

       

    }

   }

   public function getpreviuousenquirynumber(){
    $this->db->select('enquiry_number');
    $this->db->where(TBL_ENAUIRY_FORM.'.status', 1);
    $this->db->limit(1);
    $this->db->order_by(TBL_ENAUIRY_FORM.'.id','DESC');
    $query = $this->db->get(TBL_ENAUIRY_FORM);
    $rowcount = $query->row_array();
    return $rowcount;
   }


    public function deleteenquiryformdata($id){

        $this->db->where('id ', $id);
        //$this->db->delete(TBL_SUPPLIER);
        if($this->db->delete(TBL_ENAUIRY_FORM)){
            
            $this->db->where('enquiry_form_id', $id);
            //$this->db->delete(TBL_SUPPLIER);
            if($this->db->delete(TBL_ENAUIRY_FORM_ITEM)){
               return TRUE;
            }else{
               return FALSE;
            }
        //    return TRUE;
        }else{
          return FALSE;
        }
    }


    public function geteditChallanformitemforedititem($id){

        $this->db->select(TBL_OMS_CHALLAN_ITEM.'.id as omschallanid,'
        .TBL_FINISHED_GOODS.'.fin_id as part_number,'
        .TBL_FINISHED_GOODS.'.name as fg_description,'
        .TBL_RAWMATERIAL.'.type_of_raw_material as rm_description,'
        .TBL_OMS_CHALLAN_ITEM.'.gross_weight as gross_weight,'
        .TBL_OMS_CHALLAN_ITEM.'.net_weight as net_weight,'
        .TBL_OMS_CHALLAN_ITEM.'.unit as unit,'
        .TBL_OMS_CHALLAN_ITEM.'.calculation as calculation,'
        .TBL_OMS_CHALLAN_ITEM.'.qty as qty,'
        .TBL_OMS_CHALLAN_ITEM.'.no_of_bags as no_of_bags,'
        .TBL_OMS_CHALLAN_ITEM.'.hsn_no as hsn_no,'
        .TBL_OMS_CHALLAN_ITEM.'.remark as remark,'
         );

        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_OMS_CHALLAN_ITEM.'.part_number');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number','left');
        
        $this->db->where(TBL_OMS_CHALLAN_ITEM.'.id', $id);
        $query = $this->db->get(TBL_OMS_CHALLAN_ITEM);
        $fetch_result = $query->result_array();
        return $fetch_result;

    }


    public function getdebitnotepartnumberdetails_byvendor($part_number,$vendor_po_number){


        /*check If vendor Po Exits*/
        $this->db->select('supplier_po_number');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.id ',$vendor_po_number);
        $query_data = $this->db->get(TBL_VENDOR_PO_MASTER);
        $data_supplier_po_number = $query_data->result_array();
        //return $data_supplier_po_number;

        if($data_supplier_po_number[0]['supplier_po_number']){

            // $this->db->select('*,'.TBL_RAWMATERIAL.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_RAWMATERIAL.'.type_of_raw_material as name,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            // $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            // //$this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            // $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            // $this->db->where(TBL_RAWMATERIAL.'.status',1);
            // $this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
            // $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            // $data = $query->result_array();
            // return $data;

            
            $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as name,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            //$this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;

        }else{

            $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate as vendorrate,'.TBL_FINISHED_GOODS.'.name as name,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty as vendor_order_qty');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            //$this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
            // $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $this->db->where(TBL_FINISHED_GOODS.'.status',1);
            $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
            $query = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query->result_array();
            return $data;
        


        }


    }

  

  }

  

?>