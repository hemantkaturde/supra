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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewBuyerpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>    &nbsp ";

                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editBuyerpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>    &nbsp";

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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editSupplierpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-pencil-square-o' aria-hidden='true'></i></a>  &nbsp";

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
            // $this->db->where('id', $id);
            // if($this->db->update(TBL_BUYER_PO_MASTER_ITEM, $data)){
            //     return TRUE;
            // } else {
            //     return FALSE;
            // }

            if($this->db->insert(TBL_BUYER_PO_MASTER_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }


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
            // $this->db->where('id', $id);
            // if($this->db->update(TBL_SUPPLIER_PO_MASTER_ITEM, $data)){
            //     return TRUE;
            // } else {
            //     return FALSE;
            // }

            if($this->db->insert(TBL_SUPPLIER_PO_MASTER_ITEM, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }

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
        $this->db->select('*');
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

        $this->db->select('*,'.TBL_SUPPLIER.'.supplier_name as sup_name');
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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewVendorpo/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['id']."' class='fa fa-trash-o deleteVendorpo' aria-hidden='true'></i>"; 
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

    public function getfinishedgoodsPartnumberByid($part_number){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.net_weight as supplier_goods_net_weight,'.TBL_FINISHED_GOODS.'.sac as supplier_goods_sac');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;

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

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER_ITEM.'.id as vendoritemid');
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

    public function fetchALLVendoritemlistforview($vendorpoid){
        $this->db->select('*');
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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpoconfirmation/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
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
        $this->db->select('*');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
      }else{


        $this->db->select('*');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
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
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_SUPPLIER_PO_MASTER_ITEM, TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id = '.TBL_RAWMATERIAL.'.raw_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
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

        $this->db->select('*');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.part_number_id');
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

        $this->db->select('*');
        $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.part_number_id');
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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpoconfirmation/".$value['id']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
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

        $this->db->select('*');
        $this->db->where(TBL_SUPPLIER_PO_CONFIRMATION.'.id', $supplierpoconfirmationid);
        $query = $this->db->get(TBL_SUPPLIER_PO_CONFIRMATION);
        $data = $query->result_array();
        return $data;

    }

    public function getVendorPonumberbySupplierid($supplier_name){
        $this->db->select('*');
        $this->db->join(TBL_BUYER_MASTER, TBL_BUYER_MASTER.'.buyer_id = '.TBL_VENDOR_PO_MASTER.'.buyer_name');
        $this->db->where(TBL_VENDOR_PO_MASTER.'.vendor_name', $supplier_name);
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

    public function getVendoritemsonly($vendor_po_number){

        $this->db->select('*');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;

    }
    
    public function getSuppliergoodsPartnumberByid($part_number){
        $this->db->select('*');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->join(TBL_SUPPLIER_PO_CONFIRMATION_ITEM, TBL_SUPPLIER_PO_CONFIRMATION_ITEM.'.vendor_id = '.TBL_VENDOR.'.ven_id');

        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
        $data = $query->result_array();
        return $data;
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

        $this->db->select('*,'.TBL_BUYER_MASTER.'.buyer_name as buyer_name_master,'.TBL_VENDOR_PO_CONFIRMATION_ITEM.'.id as vendoritemid');
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

        $this->db->select('*,'.TBL_VENDOR_PO_MASTER.'.po_number as vendor_po,'.TBL_SUPPLIER.'.supplier_name as rowmaterialsuppliername');
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
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id= '.TBL_JOB_WORK.'.raw_material_supplier');
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
        $this->db->join(TBL_SUPPLIER, TBL_SUPPLIER.'.sup_id= '.TBL_JOB_WORK.'.raw_material_supplier');
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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpoconfirmation/".$value['jobworkid']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
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

    public function getSuppliergoodsPartnumberByidjobwork($part_number,$vendor_po_number){
        $this->db->select('*,'.TBL_FINISHED_GOODS.'.sac as sac_no');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR, TBL_VENDOR.'.ven_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.pre_vendor_name');
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        //$this->db->where(TBL_RAWMATERIAL.'.raw_id',$part_number);
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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewSupplierpoconfirmation/".$value['billofmaterialid']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
                $data[$counter]['action'] .= "<i style='font-size: x-large;cursor: pointer;' data-id='".$value['billofmaterialid']."' class='fa fa-trash-o deleteBillofmaterial' aria-hidden='true'></i>"; 
                $counter++; 
            }
        }

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
            // $this->db->where('jobwork_id', $id);
            // $this->db->delete(TBL_SUPPLIER);
            // if($this->db->delete(TBL_JOB_WORK_ITEM)){
            //    return TRUE;
            // }else{
            //    return FALSE;
            // }
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
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewVendorbillofmaterial/".$value['billofmaterialid']."' style='cursor: pointer;'><i style='font-size: large;cursor: pointer;' class='fa fa-file-text-o' aria-hidden='true'></i></a>   &nbsp ";
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


    public function getVendoritemsonlyvendorBillofmaterial($vendor_po_number,$buyer_po_number){

        $this->db->select('*');
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
        $this->db->join(TBL_BUYER_PO_MASTER_ITEM, TBL_BUYER_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_FINISHED_GOODS.'.fin_id' .' and '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id='.TBL_FINISHED_GOODS.'.fin_id');
        $this->db->where(TBL_FINISHED_GOODS.'.status',1);
        $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
        //$this->db->where(TBL_FINISHED_GOODS.'.fin_id',$part_number);
        $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
        $query = $this->db->get(TBL_FINISHED_GOODS);
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
        $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.part_number = '.TBL_FINISHED_GOODS.'.part_number');
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


}

?>