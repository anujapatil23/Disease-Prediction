<?php
       
        $con=null;
        $con=new mysqli("localhost","root","","dxx");
       $p_id=$_POST['p_id'];
        $medical_data_list=array();
        $dx_master_list=array();
        //for patient medical data
        $symptoms_test=array();
        $lab_test=array();
       
        $history_test=array();
        
        $lab_test_value=array();
        $patient_id=array();
        //for exploding patient's medical data
        $symptoms=array();
        $lab=array();
        
        $history=array();
        
        //for disease data
        $d_symptoms_test=array();
        $d_lab_test=array();
        
        $d_history_test=array();
        
        $d_disease_list=array();
        //for exploding disease data
        $d_symptoms=array();
        $d_lab=array();
        
        $d_history=array();
        
        $d_disease=array();
        //for probability
        $symptom_prob=array();
        $lab_test_prob=array();
      
        $history_prob=array();
        
        //for exploding probability
        $e_symptom_prob=array();
    //    $e_lab_prob=array();
        $e_history_prob=array();
       
        if($con)
        {       
            //echo 'connected'."<br>";
            $choice=4;
            
            switch ($choice)
            {
            case 1:
                echo '1 disease 1 patient'.'<br>';
                $query="select * from medical_data where dx_list='' and patient_id=1001";
                $query1="select * from disease_master where dx_title='Pneumonia'";
                break;
            case 2:
                echo '1 disease all patient';
                $query="select * from medical_data where dx_list=''";
                $query1="select * from disease_master where dx_title='Diabetes'";
                break;
            case 3:
                echo 'all diseases 1 patient';
                $query="select * from medical_data where dx_list='' and patient_id=1001";
                $query1="select * from disease_master";
                break;
            case 4:
                //echo 'all diseases all patients';
                $query="select * from ml_patiet_data where dx_list='' and patient_id='$p_id' and dx_probability=''";
                $query1="select * from ml_disease_master";
                break;
            }
            
            $result=  mysqli_query($con, $query);
            $medical_data_list=mysqli_fetch_all($result,MYSQLI_ASSOC);
            $symptoms_test=  array_column($medical_data_list, 'symptoms_value');
            $lab_test=array_column($medical_data_list, 'lab_value');
    //        $lab_test_value=  array_column($medical_data_list, 'lab_value');
            $patient_id=  array_column($medical_data_list, 'patient_id');
            $history_test=array_column($medical_data_list, 'historys_prob');
            
           
            
            $result1=mysqli_query($con,$query1);
            $dx_master_list=mysqli_fetch_all($result1,MYSQLI_ASSOC);
        //    $d_symptoms_test=  array_column($dx_master_list, 'symptom_list');
        //    $d_lab_test=array_column($dx_master_list, 'lab_test');
        //    $d_history_test=array_column($dx_master_list, 'history');
            $d_disease_list=array_column($dx_master_list, 'dx_title');
            
            $symptom_prob=  array_column($dx_master_list, 'symptom_prob');
            $lab_test_prob=array_column($dx_master_list, 'lab_test_prob');
            $history_prob=array_column($dx_master_list, 'history_prob');
            
            

            if(count($symptoms_test)>0)
            {
                for($i=0;$i<count($symptoms_test);$i++)
                {
                $val=array();
                $symptoms=explode(',', $symptoms_test[$i]);
                $lab=explode(',',$lab_test[$i] );
               
                $history=explode(',', $history_test[$i]);
                
       //         $lab_value=  explode(',', $lab_test_value[$i]);
               
                for($j=0;$j<count($d_disease_list);$j++)
                {
                $prob=0;
                $count=0;
                if(!empty($d_symptoms_test[$j]))
                {
                    $d_symptoms=  explode(',',($d_symptoms_test[$j]));
                }
                if(!empty($d_lab_test[$j]))
                {
                    $d_lab=explode(',',($d_lab_test[$j]));
                }
               if(!empty($d_history_test[$j]))
                {
                    $d_history=explode(',',($d_history_test[$j]));
                }

               
                $e_symptom_prob=  explode(',',($symptom_prob[$j]));
                $e_lab_prob=explode(',',($lab_test_prob[$j]));
               $e_history_prob=explode(',',($history_prob[$j]));
               
               
                for($k=0;$k<count($e_symptom_prob);$k++)
                {
                    if($e_symptom_prob[$k]>0 && $symptoms[$k]>0)
                    {
                        $count++;
                        $prob=$prob+$e_symptom_prob[$k];
                    }
                }
                
                for($k=0;$k<count($e_lab_prob);$k++)
                {
                    if($e_lab_prob[$k]>0 && $lab[$k]>0)
                    {
                        $count++;
                        $prob=$prob+$e_lab_prob[$k];
                    }
                }

                for($k=0;$k<count($e_history_prob);$k++)
                {
                    if($e_history_prob[$k]>0 && $history[$k]>0)
                    {
                        $count++;
                        $prob=$prob+$e_history_prob[$k];
                    }
                }
                if($count!=0)
                {
                    // $val[$d_disease_list[$j]]=$prob/$count;
                    $val[$d_disease_list[$j]]=$prob;
                
                }
               
                }
                $str= http_build_query($val);
                $que="update ml_patiet_data set dx_probability=concat(dx_probability,'$str') where patient_id='$p_id'";
               
                $res=  mysqli_query($con, $que);
                if($res>0)
                {
                    //echo "Updated";
                }
                } 
            }
           else
            {
                //echo 'patient is analysed already';
            } 
        }
        else{
            echo 'not connected';
        }
        
      
?>
    

