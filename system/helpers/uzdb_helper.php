<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

    class uzdb {
                
        function getSettingsData($table="settings"){
            $data=array();
            $query = $this->db->query("select * from $table");
            foreach ($query->result_array() as $row){
                $data[$row['title']]=$row['value'];
            }

            return $data;
        }

        function getSingleDataArray($table,$condition){
            $data=array();
            $fields = $this->db->list_fields($table);
            $row=uzdb::getSingleRow($table,$condition);

            foreach($fields as $field){
                $data[$field]=$row[$field];
            }

            return $data;
        }

        function getSingleRow($table,$condition=""){
            if($condition!=""){
                $condition=" where ".$condition;
            }
            $query = $this->db->query("select * from $table ".$condition);
            $result=$query->result_array();
            return $result[0];
        }

        function getRS($table,$condition="",$fields="*",$orderby="",$limit=""){
            if($condition!=""){
                $condition=" where ".$condition;
            }
            if($orderby!=""){
                $orderby=" order by ".$orderby;
            }
            if($limit!=""){
                $limit=" limit ".$limit;
            }

            $query = $this->db->query("select ".$fields." from $table ".$condition." ". $orderby ." ".$limit);
            return $query->result_array();
        }

        function count($table,$condition=""){
            if($condition!=""){
                $condition=" where ".$condition;
            }
            $query = $this->db->query("select count(*) as tot from $table ".$condition);
            //echo $query;
            $row=$query->row_array();
            return $row['tot'];
        }

        function status($status){
            if($status=="enabled"){
                return "Disable";
            }else{
                return "Enable";
            }
        }

        function cngStatus($table,$id,$status){
            if($status=="enabled"){
                $status="disabled";
            }else{
                $status="enabled";
            }

            $query = $this->db->query("update $table set status='$status' where id=".$id);
        }

        function del($table,$condition){
            if($condition!=""){
                $condition=" where ".$condition;
            }
            $query = $this->db->query("delete from $table ".$condition);
        }


    }//class db end
?>
