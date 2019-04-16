<?php
       
        $con=new mysqli("localhost","root","","dxx");
        $medical_data_list=array();
        $dx_master_list=array();
        //for medical data
        $symptoms_test=array();
        $lab_test=array();
        $history_test=array();
        $patient_id=array();
        //for exploding medical data
        $symptoms=array();
        $lab=array();
        $history=array();
        //for disease data
        $d_symptoms_test=array();
        $d_lab_test=array();
        $d_history_test=array();
        //for exploding disease data
        $d_symptoms=array();
        $d_lab=array();
        $d_history=array();
        $d_disease=array();
        $diseases=array();
        
        $val=0;
        
        if($con)
        {            
            echo 'connected'."<br>";

            $choice=3;
            
            switch ($choice)
            {
            case 1:
                echo '1 disease 1 patient';
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
                echo 'all diseases all patients';
                $query="select * from medical_data where dx_list=''";
                $query1="select * from disease_master";
                break;
            }
           
            $result=  mysqli_query($con, $query);
            $medical_data_list=mysqli_fetch_all($result,MYSQLI_ASSOC);
            
            $result1=mysqli_query($con,$query1);
            $dx_master_list=mysqli_fetch_all($result1,MYSQLI_ASSOC);
            
            $symptoms_test=  array_column($medical_data_list, 'symp_severity');
            $lab_test=array_column($medical_data_list, 'lab_severity');
            $history_test=array_column($medical_data_list, 'hist_severity');
            $patient_id=  array_column($medical_data_list, 'patient_id');
            
            $d_symptoms_test=  array_column($dx_master_list, 'symptom_prob');
            $d_history_test=  array_column($dx_master_list, 'history_prob');
            $d_lab_test=  array_column($dx_master_list, 'lab_test_prob');
            $diseases= array_column($dx_master_list, 'dx_title');
            
            if($symptoms_test>0)
            {
            for($i=0;$i<count($symptoms_test);$i++)
            {
                $final=array();
                $symptoms=explode(',', $symptoms_test[$i]);
                $lab=explode(',',$lab_test[$i] );
                $history=explode(',', $history_test[$i]);
                
                for($l=0;$l<count($d_symptoms_test);$l++)
                {
                    $count=0;
                    $d_symptoms=  explode(',', $d_symptoms_test[$l]);
                    for($j=0;$j<count($symptoms);$j++)
                    {
                        if($symptoms[$j]>0 && $d_symptoms[$j]>0)
                        {
                            $count++;
                        }
                    }
                    $val=$val+0.75*$count;
                    
                    $count=0;
                    $d_history=  explode(',', $d_history_test[$l]);
                    for($j=0;$j<count($history);$j++)
                    {
                        if($history[$j]>0 && $d_history[$j]>0)
                        {
                            $count++;
                        }
                    }
                    $val=$val+0.75*$count;
               
                    $count=0;
                    $d_lab= explode(',', $d_lab_test[$l]);
                    for($j=0;$j<count($lab);$j++)
                    {
                        if($lab[$j]>0 && $d_lab[$j]>0)
                        {
                            $count++;
                        }
                    }
                    $val=$val+1*$count;
                    $dis= $diseases[$l];
                    $final[$dis]=$val;
                }       
                $str= http_build_query($final);
                $que="update medical_data set dx_findings_weight=concat(dx_findings_weight,'$str') where patient_id='$patient_id[$i]'";
                $res=mysqli_query($con, $que);
                if($res>0)
                {
                    echo "Updated";
                }      
            }
            }
            else {
                echo 'patient is already analysed';
            }
        }
        else{
            echo 'not connected';
        }       
?>
    
