<?php
       
        $con=null;
        $con=new mysqli("localhost","root","","dxx");
        $medical_data_list=array();
        $dx_master_list=array();
        //for patient medical data
        $symptoms_test=array();
        $lab_test=array();
        $physical_test=array();
        $history_test=array();
        $physiological_test=array();
        $lab_test_value=array();
        $patient_id=array();
        //for exploding patient's medical data
        $symptoms=array();
        $lab=array();
        $physical=array();
        $history=array();
        $physiological=array();
        $lab_value=array();
        //for disease data
        $d_symptoms_test=array();
        $d_lab_test=array();
        $d_physical_test=array();
        $d_history_test=array();
        $d_physiological_test=array();
        $d_disease_list=array();
        //for exploding disease data
        $d_symptoms=array();
        $d_lab=array();
        $d_physical=array();
        $d_history=array();
        $d_physiological=array();
        $d_disease=array();
        //for probability
        $symptom_prob=array();
        $lab_test_prob=array();
        $physical_prob=array();
        $history_prob=array();
        $physiological_prob=array();
        //for exploding probability
        $e_symptom_prob=array();
        $e_lab_prob=array();
        $e_phsical_prob=array();
        $e_history_prob=array();
        $e_physiological_prob=array();
        
        if($con)
        {       
            echo 'connected'."<br>";
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
                echo 'all diseases all patients';
                $query="select * from medical_data where dx_list=''";
                $query1="select * from disease_master";
                break;
            }
            
            $result=  mysqli_query($con, $query);
            $medical_data_list=mysqli_fetch_all($result,MYSQLI_ASSOC);
            $symptoms_test=  array_column($medical_data_list, 'symptom_list');
            $lab_test=array_column($medical_data_list, 'lab_test_list');
            $physical_test=array_column($medical_data_list, 'phy_exam_list');
            $history_test=array_column($medical_data_list, 'history_list');
            $physiological_test=array_column($medical_data_list, 'physiological_list');
            $lab_test_value=  array_column($medical_data_list, 'lab_test_value');
            $patient_id=  array_column($medical_data_list, 'patient_id');
            
            $result1=mysqli_query($con,$query1);
            $dx_master_list=mysqli_fetch_all($result1,MYSQLI_ASSOC);
            $d_symptoms_test=  array_column($dx_master_list, 'symptom_list');
            $d_lab_test=array_column($dx_master_list, 'lab_test_list');
            $d_physical_test=array_column($dx_master_list, 'phy_exam_list');
            $d_history_test=array_column($dx_master_list, 'history_list');
            $d_physiological_test=array_column($dx_master_list, 'physiological_list');
            $d_disease_list=array_column($dx_master_list, 'dx_title');
            
            $symptom_prob=  array_column($dx_master_list, 'symptom_prob');
            $lab_test_prob=array_column($dx_master_list, 'lab_test_prob');
            $physical_prob=array_column($dx_master_list, 'phy_exam_prob');
            $history_prob=array_column($dx_master_list, 'history_prob');
            $physiological_prob=array_column($dx_master_list, 'physiological_prob');

            if(count($symptoms_test)>0)
            {
                for($i=0;$i<count($symptoms_test);$i++)
                {
                $val=array();
                $symptoms=explode(',', $symptoms_test[$i]);
                $lab=explode(',',$lab_test[$i] );
                $physical=explode(',', $physical_test[$i]);
                $history=explode(',', $history_test[$i]);
                $physiological=explode(',', $physiological_test[$i]);
                $lab_value=  explode(',', $lab_test_value[$i]);
               
                for($j=0;$j<count($d_symptoms_test);$j++)
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
                if(!empty($d_physical_test[$j]))
                {
                  $d_physical=explode(',',($d_physical_test[$j]));  
                }
                if(!empty($d_history_test[$j]))
                {
                    $d_history=explode(',',($d_history_test[$j]));
                }
                if(!empty($d_physiological_test[$j]))
                {
                  $d_physiological=explode(',',($d_physiological_test[$j]));  
                }
                $e_symptom_prob=  explode(',',($symptom_prob[$j]));
                $e_lab_prob=explode(',',($lab_test_prob[$j]));
                $e_phsical_prob=explode(',',($physical_prob[$j]));
                $e_history_prob=explode(',',($history_prob[$j]));
                $e_physiological_prob=explode(',',($physiological_prob[$j]));
            
                for($k=0;$k<count($d_symptoms);$k++)
                {
                    foreach($symptoms as $s)
                    {
                        if($s==($d_symptoms[$k]))
                        {
                            $count++;
                            $prob=$prob+$e_symptom_prob[$k];
                        }
                    }
                }
                for($k=0;$k<count($d_lab);$k++)
                {
                    $l=0;
                    foreach($lab as $s)
                    {
                        if($s==($d_lab[$k]))
                        {
                            $count++;
                            $labprob=get_labtest_prob($e_lab_prob[$k],$s,$lab_value[$l]);
                            $prob=$prob+$labprob;
                        }
                        $l++;
                    }
                }
                for($k=0;$k<count($d_history);$k++)
                {
                    foreach($history as $s)
                    {
                        if($s==($d_history[$k]))
                        {
                            $count++;
                            $prob=$prob+$e_history_prob[$k];
                        }
                    }
                }
                for($k=0;$k<count($d_physical);$k++)
                {
                    foreach($physical as $s)
                    {
                        if($s==($d_physical[$k]))
                        {
                            $count++;
                            $prob=$prob+$e_phsical_prob[$k];
                        }
                    }
                }
                for($k=0;$k<count($d_physiological);$k++)
                {
                    foreach($physiological as $s)
                    {
                        if($s==($d_physiological[$k]))
                        {
                            $count++;
                            $prob=$prob+($e_physiological_prob[$k]);
                        }
                    }
                }
                $val[$d_disease_list[$j]]=$prob/$count;
                echo $val[$d_disease_list[$j]];
                }
                $str= http_build_query($val);
                $que="update medical_data set dx_findings_probability=concat(dx_findings_probability,'$str') where patient_id='$patient_id[$i]'";
                $res=  mysqli_query($con, $que);
                if($res>0)
                {
                    echo "Updated";
                }
                } 
            }
           else
                {
                    echo 'patient is analysed already';
                } 
        }
        else{
            echo 'not connected';
        }
        
        function get_labtest_prob($value,$test,$report)
        {
            $prob;
            $prev=0;
            $con=null;
            $con=new mysqli("localhost","root","","dxx");
            $query="select * from lab_test where id='$test'";
            $result=  mysqli_query($con, $query);
            $row=mysqli_fetch_array($result);
            $range=$row[2];
            $expld=array();
            $expld=explode(',', $range);
            foreach($expld as $e)
            {
                if($report<=$e)
                {
                    break;
                }
            }
            $subtr=$e-$report;
            
            if($subtr != 0)
            {
                $div=$value*($subtr/$e);
            }
            else
            {
                foreach($expld as $e)
                {
                if($report<$e)
                {
                    break;
                }
                }
                $subtr=$e-$report;
                if($subtr!=0)
                {
                    $div=$value*($subtr/$e);
                }
                else
                {
                    $div=$value;
                }
            }
            return $div;
        }   
?>
    

