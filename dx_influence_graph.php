<?php


require_once '../../vendor/autoload.php';
use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\BinaryStep;
$username="root";
$password="";
$dbname="dxx";

// Create connection 

$con=mysqli_connect("localhost",$username,$password,$dbname);
ini_set('max_execution_time',300);

//////////////////////////////////////////////////// for probability //////////////////////////////////////////////////////
function calculate_in_curve_all($width,$height,$in_vector_size,$i)
{
    $step=54;
    $x0 = 20;
    $y0 = 27 + $step * $i;
    $x1 = $width / 2;
    $y1 = $y0;
    $x2 = $x1;
    $y2 = $height / 2;
    $x3 = $width;
    $y3 = $y2;
    return "M " . $x0 . " " . $y0 . " C " . $x1 . "," . $y1 . " " . $x2 . "," . $y2 . " " . $x3 . " " . $y3 . "";
}
function calculate_in_polygon_all($width,$height){
    $x1=$width-20;$y1=($height/2)-10;
    $x2=$width;$y2=($height/2)-0;
    $x3=$x1;$y3=$y2+10;
    return $x1.",".$y1." ".$x2.",".$y2." ".$x3.",".$y3; 
}
function calculate_out_curve_all($width, $height,$out_vector_size, $i) {
    $step=54;
    $x0 = 0;
    $y0 = 0 + $height / 2;
    $x1 = $width / 2;
    $y1 = $y0;
    $x2 = $x1;
    $y2 = $step*$i+27;
    $x3 = $width-20;
    $y3 = $y2;
    return "M " . $x0 . " " . $y0 . " C " . $x1 . "," . $y1 . " " . $x2 . "," . $y2 . " " . $x3 . " " . $y3 . "";
}


//include_once 'connection.php';


if(isset($_POST['probability']))
{
    $p_id=$_POST['p_id'];
    $medical_data_list=array();
        $dx_master_list=array();
        //for patient medical data
        $symptoms_test=array();
        $lab_test=array();
       // $physical_test=array();
        $history_test=array();
        //$physiological_test=array();
        $lab_test_value=array();
        $patient_id=array();
        //for exploding patient's medical data
        $symptoms=array();
        $lab=array();
        //$physical=array();
        $history=array();
        //$physiological=array();
 //       $lab_value=array();
        //for disease data
        $d_symptoms_test=array();
        $d_lab_test=array();
        //$d_physical_test=array();
        $d_history_test=array();
        //$d_physiological_test=array();
        $d_disease_list=array();
        //for exploding disease data
        $d_symptoms=array();
        $d_lab=array();
        //$d_physical=array();
        $d_history=array();
        //$d_physiological=array();
        $d_disease=array();
        //for probability
        $symptom_prob=array();
        $lab_test_prob=array();
       // $physical_prob=array();
        //$physiological_prob=array();
        $history_prob=array();
        
        //for exploding probability
        $e_symptom_prob=array();
    //    $e_lab_prob=array();
        $e_history_prob=array();
        //$e_phsical_prob=array();
       // $e_physiological_prob=array();
        
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
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $medical_data_list=array();
    $symptoms=array();
    $lab=array();
    $history=array();
    $prob=array();
if($con)
{
 $query="select * from ml_patiet_data where patient_id='$p_id'";
 $result=mysqli_query($con,$query);
 while($row=mysqli_fetch_array($result))
 {
    $s=$row['symptoms_list'];
    $h=$row['history'];
    $l=$row['lab_list'];
    $pb=$row['dx_probability'];
    $p_name=$row['patient_name'];
    $bmi_msg=$row['bmi_status'];
   
    if(!empty($s))
    {
        $symptoms=explode(',', $s);
    }
     if(!empty($h))
    {
        $history=explode(',', $h);
    }
     if(!empty($l))
    {
         $lab=explode(',', $l);
    }
     if(!empty($pb))
    {
       $prob=  explode('&', $pb);
    }
    $a=0;
    foreach ($symptoms as $s)
    {
        if($s>0)
        {
            $a++;
        }
    }
    $b=0;
    foreach ($lab as $s)
    {
        if($s>0)
        {
            $b++;
        }
    }
    $d=0;
    foreach ($history as $s)
    {
        if($s>0)
        {
            $d++;
        }
    }    
    
 //   $a=count($symptoms);
 //   $b=count($lab);
 //   $d=count($history);
 }
 for($i=0;$i<count($prob);$i++)
    {
        $key_value=  explode('=', $prob[$i]);
    }
}
//if($bmi<18.5)
//{
//    $bmi_msg="Underweight";
//}
//elseif ($bmi>=18.5 && $bmi<24.9) {
// $bmi_msg="Normal";
//}
//elseif ($bmi>=25.0 && $bmi<29.9) {
// $bmi_msg="Overweight";
//}
//elseif ($bmi>=30.0 && $bmi<34.9) {
// $bmi_msg="Obeisity 1";
//}
//elseif ($bmi>=35 && $bmi<39.9) {
// $bmi_msg="Obesity 2";
//}
//elseif ($bmi>=40.0 ) {
// $bmi_msg="Extreme Obesity";
//}
$in_title="INPUT VECTOR";
//$in_title=$p_name;
$out_title="OUTPUT VECTOR";
$patient=$p_name;
$in_data=array(array("Symptom",$a),array("Lab-test",$b),array("History",$d));
$in_vector_size=count($in_data);
$out_vector_size=count($prob);

$max_vector_size=($in_vector_size >= $out_vector_size?$in_vector_size:$out_vector_size);
$height=54*$max_vector_size;
$width=300;

?>

<html>

<head>
    <link href="graph_css.css" rel="stylesheet">
</head>

<body>
     <div >
        <label style="alignment-adjust: central">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Analysis By Probability</b></label>
    </div>
    <div class="container author-page-content">
        <div class="influence-graph">
            <div class="influence-graph-titles flex-row">
                <h4 class="influence-graph__title influencedBy"><?php echo $in_title;?></h4>
                <h4 class="influence-graph__title influenced"><?php echo $out_title;?></h4></div>
            <div class="influence-graph-inner">
                <div class="influence-graph__nodes influencedBy" id="inner">
                    <?php
                    foreach ($in_data as $key => $value) {
                        echo '<div class="tooltip-parent influence-graph__node">';
                        echo '<a class="influence-graph__node__link" href="#">'.$value[0].'</a>';
                        echo '<span class="influence-graph__node__score badge badge--highlight">'.$value[1].'</span></div>';
                    } 
                    ?>
                </div>
                <div class="influence-graph__center-content">
                    <div class="influence-graph__lines">
                        <svg height="<?php echo $height;?>" width="<?php echo $width;?>">
                            <g>
                            <?php
                    foreach ($in_data as $key => $value) {
                        $bz_line=  calculate_in_curve_all($width,$height,$in_vector_size,$key);
                        echo '<path class="influence-graph__line influence-graph__line--influencedBy" marker-end="" d="'.$bz_line.'"></path>';
                        
                    }
                    $poly=  calculate_in_polygon_all($width,$height);
                    echo '<polygon class="influence-graph__influencedBy-arrow" points="'.$poly.'"></polygon>';
                    ?>
                           </g>
                        </svg>
                    </div>
                    <div class="influence-graph__current-author">
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo $patient."<br>"."<br>"; ?></strong></div>
                             
                        </div>
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo "<br>"."<br>" ?></strong></div>
                        </div>
                        
                        
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo "(Patient is ".$bmi_msg.")"; ?></strong></div>
                        </div>
                    </div>
                    <div class="influence-graph__lines">
                        <svg height="<?php echo $height;?>" width="<?php echo $width;?>">
                            <defs>
                                <marker id="arrowhead" viewBox="0 0 40 40" refX="30" refY="30" markerWidth="30" markerHeight="30" orient="auto">
                                    <path d="M 30 22 L 40 30 L 30 38 z"></path>
                                </marker>
                            </defs>
                            <g>
                            <?php
                    for ($i=0;$i<count($prob);$i++) {
                        $bz_line=  calculate_out_curve_all($width,$height,$out_vector_size,$i);
                        echo '<path class="influence-graph__line influence-graph__line--influenced" marker-end="url(#arrowhead)" d="'.$bz_line.'"></path>';
                    }
                    ?>
                              </g>
                        </svg>
                    </div>
                </div>
                <div class="influence-graph__nodes influenced" id="outer">
                                        <?php
                                        for($i=0;$i<count($prob);$i++)
                    {
                        $key_value=  explode('=', $prob[$i]);
                       echo '<div class="tooltip-parent influence-graph__node">';
                        echo '<span class="influence-graph__node__score badge badge--highlight">'.sprintf("%0.2f",$key_value[1]).'</span>';
                        echo '<a class="influence-graph__node__link" href="#">'.$key_value[0].'</a>';
                        echo'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}

 function calculate_in_curve($width,$height,$i)
{
    $step=54;
    $x0 = 20;
    $y0 = 27 + $step * $i;
    $x1 = $width / 2;
    $y1 = $y0;
    $x2 = $x1;
    $y2 = $height / 2;
    $x3 = $width;
    $y3 = $y2;
    return "M " . $x0 . " " . $y0 . " C " . $x1 . "," . $y1 . " " . $x2 . "," . $y2 . " " . $x3 . " " . $y3 . "";
}
function calculate_in_polygon($width,$height){
    $x1=$width-20;$y1=($height/2)-10;
    $x2=$width;$y2=($height/2)-0;
    $x3=$x1;$y3=$y2+10;
    return $x1.",".$y1." ".$x2.",".$y2." ".$x3.",".$y3; 
}
function calculate_out_curve($width, $height, $i) {
    $step=54;
    $x0 = 0;
    $y0 = 0 + $height / 2;
    $x1 = $width / 2;
    $y1 = $y0;
    $x2 = $x1;
    $y2 = $step*$i+27;
    $x3 = $width-20;
    $y3 = $y2;
    return "M " . $x0 . " " . $y0 . " C " . $x1 . "," . $y1 . " " . $x2 . "," . $y2 . " " . $x3 . " " . $y3 . "";
}


///////////////////////////////////////for single instance/////////////////////////////////////////////////
if (isset($_POST['lab']))
{
    $p_id=$_POST['p_id'];
     $p_symp_list='lab_prob';
        $title="Lab test";
        $d_symp_prob='lab_test_prob';
        analyze($p_symp_list,$title,$d_symp_prob);
}
elseif (isset ($_POST['symptoms'])) {
    $p_id=$_POST['p_id'];
 $p_symp_list='symptoms_value';
        $title="Symptoms";
        $d_symp_prob='symptom_prob';
        analyze($p_symp_list,$title,$d_symp_prob);
}
elseif (isset ($_POST['history'])) {
    $p_id=$_POST['p_id'];
   $p_symp_list='historys_prob';
        $title="History";
        $d_symp_prob='history_prob';
        analyze($p_symp_list,$title,$d_symp_prob);

}
 

function analyze($p_symp_list,$title,$d_symp_prob)
{
    
$username="root";
$password="";
$dbname="dxx";

// Create connection 

$con=mysqli_connect("localhost",$username,$password,$dbname);
$p_factor=array();
$lab_value=array();
if($con)
{
     $p_id=$_POST['p_id'];
 $query="select * from ml_patiet_data where patient_id='$p_id'and dx_list=''";
 $result=mysqli_query($con,$query);
 while($row=mysqli_fetch_array($result))
 {
     $bmi=$row['bmi'];
     $p_name=$row['patient_name'];
    $f_string=$row[$p_symp_list];
    if(!empty($f_string))
    {
       $p_factor=explode(',', $f_string);
       $a=0;
       foreach ($p_factor as $f)
       {
           if($f>0)
           {
               $a++;
           }
       } 
    }
    else {
        $a=0;
    }

 }
}
if($bmi<18.5)
{
    $bmi_msg="Underweight";
}
elseif ($bmi>=18.5 && $bmi<24.9) {
 $bmi_msg="Normal";
}
elseif ($bmi>=25.0 && $bmi<29.9) {
 $bmi_msg="Overweight";
}
elseif ($bmi>=30.0 && $bmi<34.9) {
 $bmi_msg="Obeisity 1";
}
elseif ($bmi>=35 && $bmi<39.9) {
 $bmi_msg="Obesity 2";
}
elseif ($bmi>=40.0 ) {
 $bmi_msg="Extreme Obesity";
}
$in_title="INPUT VECTOR";
$out_title="OUTPUT VECTOR";
$patient=$p_name;
$in_data=array(array($title,$a));
$in_vector_size=count($in_data);
$out_vector_size=11;
$max_vector_size=($in_vector_size >= $out_vector_size?$in_vector_size:$out_vector_size);
$height=54*$max_vector_size;
$width=300;

?>

<html>

<head>
    <link href="graph_css.css" rel="stylesheet">
</head>

<body>
     <div >
        <label style="alignment-adjust: central">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Analysis By <?php echo $title?></b></label>
    </div>
    <div class="container author-page-content">
        <div class="influence-graph">
            <div class="influence-graph-titles flex-row">
                <h4 class="influence-graph__title influencedBy"><?php echo $in_title;?></h4>
                <h4 class="influence-graph__title influenced"><?php echo $out_title;?></h4></div>
            <div class="influence-graph-inner">
                <div class="influence-graph__nodes influencedBy" id="inner">
                    <?php
                    foreach ($in_data as $key => $value) {
                        echo '<div class="tooltip-parent influence-graph__node">';
                        echo '<a class="influence-graph__node__link" href="#">'.$value[0].'</a>';
                        echo '<span class="influence-graph__node__score badge badge--highlight">'.$value[1].'</span></div>';
                    } 
                    ?>
                </div>
                <div class="influence-graph__center-content">
                    <div class="influence-graph__lines">
                        <svg height="<?php echo $height;?>" width="<?php echo $width;?>">
                            <g>
                            <?php
                                foreach ($in_data as $key => $value) {
                                    $bz_line=calculate_in_curve($width,$height,$key);
                                    echo '<path class="influence-graph__line influence-graph__line--influencedBy" marker-end="" d="'.$bz_line.'"></path>';                       
                                }
                                $poly=calculate_in_polygon($width,$height);
                                echo '<polygon class="influence-graph__influencedBy-arrow" points="'.$poly.'"></polygon>';
                            ?>
                           </g>
                        </svg>
                    </div>
                    <div class="influence-graph__current-author">
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo $patient."<br>"."<br>"; ?></strong></div>
                            
                        </div>
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo "<br>"."<br>" ?></strong></div>
                        </div>
                        
                        
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo "(Patient is ".$bmi_msg.")"; ?></strong></div>
                        </div>
                    </div>
                    <div class="influence-graph__lines">
                        <svg height="<?php echo $height;?>" width="<?php echo $width;?>">
                            <defs>
                                <marker id="arrowhead" viewBox="0 0 40 40" refX="30" refY="30" markerWidth="30" markerHeight="30" orient="auto">
                                    <path d="M 30 22 L 40 30 L 30 38 z"></path>
                                </marker>
                            </defs>
                            <g>
                            <?php
                                for ($i=0;$i<11;$i++) {
                                    $bz_line=calculate_out_curve($width,$height,$i);
                                    echo '<path class="influence-graph__line influence-graph__line--influenced" marker-end="url(#arrowhead)" d="'.$bz_line.'"></path>';
                                }
                            ?>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="influence-graph__nodes influenced" id="outer">
                    <?php
                       $d_factor=array();
                        $fact_prob=array();
                        if($con)
                        {
                            $query1="select * from ml_disease_master";
                            $result=mysqli_query($con,$query1);
                            while($row=mysqli_fetch_array($result))
                            {
                                $sum=0;
                                $count=0;
                               // $d_factor=explode(',', $ds);
                                $prob=$row[$d_symp_prob];
                                $fact_prob=  explode(',', $prob);
                               
                                if(count($fact_prob)!=0 && count($p_factor)!=0)
                                {   
                                   
                                    $sum=0;
                                    $count=0;
                                    for($i=0;$i<count($p_factor);$i++)
                                    {
                                        
                                        if($p_factor[$i]>0 && $fact_prob[$i]>0)
                                        {
                                            $sum=$sum+$fact_prob[$i];
                                            $count=$count+1;
                                           // echo $fact_prob[$i]." & ".$p_factor[$i]."/"."<br>";
                                           
                                        }
                                        
                                    }
                                   
                                     if($count==0)
                                     {
                                         $reslt=0;
                                     }
                             else {
                                 //$reslt=($sum/$count); 
                                 $reslt=$sum;
                                    }
                                   
                                }
                                else {
                                    $reslt=0;
                                }
                                echo '<div class="tooltip-parent influence-graph__node">';
                                echo '<span class="influence-graph__node__score badge badge--highlight">'.sprintf("%0.2f",$reslt).'</span>';
                                echo '<a class="influence-graph__node__link" href="#">'.$row['dx_title'].'</a>';
                                echo'</div>';  
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
/////////////////////////////////////////////////////for weight//////////////////////////////////////////////////////////////
if(isset($_POST['weight']))
{
    $con=null;
        $con=new mysqli("localhost","root","","dxx");
        $p_id=$_POST['p_id'];
    $medical_data_list=array();
        $dx_master_list=array();
        //for medical data
        $symptoms_test=array();
        $lab_test=array();
        //$physical_test=array();
        $history_test=array();
        //$physiological_test=array();
        $patient_id=array();
        //for exploding medical data
        $symptoms=array();
        $lab=array();
        //$physical=array();
        $history=array();
        //$physiological=array();
        
        //for disease data
        $d_symptoms_test=array();
        $d_lab_test=array();
        //$d_physical_test=array();
        $d_history_test=array();
        //$d_physiological_test=array();
        
       
        //for exploding disease data
        $d_symptoms=array();
        $d_lab=array();
        //$d_physical=array();
        $d_history=array();
        //$d_physiological=array();
        $d_disease=array();
  
        if($con)
        {            
      

            $choice=4;
            
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
                $query="select * from ml_patiet_data where patient_id='$p_id'";
                $query1="select * from ml_disease_master";
                break;
            case 4:
               
                $query="select * from ml_patiet_data where patient_id='$p_id' and dx_weight='' and dx_list=''";
                $query1="select * from ml_disease_master";
                break;
            }
           
            $result=  mysqli_query($con, $query);
            $medical_data_list=mysqli_fetch_all($result,MYSQLI_ASSOC);
            
            $result1=mysqli_query($con,$query1);
            $dx_master_list=mysqli_fetch_all($result1,MYSQLI_ASSOC);
            
            $symptoms_test=  array_column($medical_data_list, 'symptoms_value');
            $lab_test=array_column($medical_data_list, 'lab_value');
            $history_test=array_column($medical_data_list, 'historys_prob');
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
                    $val=0;
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
                    $val=$val+0.50*$count;
               
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
                $que="update ml_patiet_data set dx_weight=concat(dx_weight,'$str') where patient_id='$p_id'";
                $res=mysqli_query($con, $que);
                if($res>0)
                {
                    echo "Updated";
                   // echo "<script language=java.script>alert 'updated'</script>";
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
        
        draw_weight_graph();
}
function draw_weight_graph()
{
    $con=null;
        $con=new mysqli("localhost","root","","dxx");
        $p_id=$_POST['p_id'];
     $medical_data_list=array();
    $symptoms=array();
    $lab=array();
    $history=array();
    $prob=array();
if($con)
{
 $query="select *from ml_patiet_data where patient_id='$p_id'";
 $result=mysqli_query($con,$query);
 while($row=mysqli_fetch_array($result))
 {
    $s=$row['symptoms_list'];
    $h=$row['history'];
    $l=$row['lab_list'];
    $pb=$row['dx_weight'];
    $p_name=$row['patient_name'];
    $bmi=$row['bmi'];
  
    if(!empty($s))
    {
        $symptoms=explode(',', $s);
    }
     if(!empty($h))
    {
        $history=explode(',', $h);
    }
     if(!empty($l))
    {
         $lab=explode(',', $l);
    }
     if(!empty($pb))
    {
       $prob=  explode('&', $pb);
    }
    $a=0;
    foreach ($symptoms as $s)
    {
        if($s>0)
        {
            $a++;
        }
    }
    $b=0;
    foreach ($lab as $s)
    {
        if($s>0)
        {
            $b++;
        }
    }
    $d=0;
    foreach ($history as $s)
    {
        if($s>0)
        {
            $d++;
        }
    }    
    
 //   $a=count($symptoms);
 //   $b=count($lab);
 //   $d=count($history);
 }
 for($i=0;$i<count($prob);$i++)
    {
        $key_value=  explode('=', $prob[$i]);
    }
}
if($bmi<18.5)
{
    $bmi_msg="Underweight";
}
elseif ($bmi>=18.5 && $bmi<24.9) {
 $bmi_msg="Normal";
}
elseif ($bmi>=25.0 && $bmi<29.9) {
 $bmi_msg="Overweight";
}
elseif ($bmi>=30.0 && $bmi<34.9) {
 $bmi_msg="Obeisity 1";
}
elseif ($bmi>=35 && $bmi<39.9) {
 $bmi_msg="Obesity 2";
}
elseif ($bmi>=40.0 ) {
 $bmi_msg="Extreme Obesity";
}
$in_title="INPUT VECTOR";
$out_title="OUTPUT VECTOR";
$patient=$p_name;
$in_data=array(array("Symptom",$a),array("Lab-test",$b),array("History",$d));
$in_vector_size=count($in_data);
$out_vector_size=count($prob);
$max_vector_size=($in_vector_size >= $out_vector_size?$in_vector_size:$out_vector_size);
$height=54*$max_vector_size;
$width=300;
?>
<html>

<head>
    <link href="graph_css.css" rel="stylesheet">
</head>

<body>
    <div >
        <label style="alignment-adjust: central">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Analysis By Weight</b></label>
    </div>
    <div class="container author-page-content">
        <div class="influence-graph">
            <div class="influence-graph-titles flex-row">
                <h4 class="influence-graph__title influencedBy"><?php echo $in_title;?></h4>
                <h4 class="influence-graph__title influenced"><?php echo $out_title;?></h4></div>
            <div class="influence-graph-inner">
                <div class="influence-graph__nodes influencedBy" id="inner">
                    <?php
                    foreach ($in_data as $key => $value) {
                        echo '<div class="tooltip-parent influence-graph__node">';
                        echo '<a class="influence-graph__node__link" href="#">'.$value[0].'</a>';
                        echo '<span class="influence-graph__node__score badge badge--highlight">'.$value[1].'</span></div>';
                    } 
                    ?>
                </div>
                <div class="influence-graph__center-content">
                    <div class="influence-graph__lines">
                        <svg height="<?php echo $height;?>" width="<?php echo $width;?>">
                            <g>
                            <?php
                    foreach ($in_data as $key => $value) {
                        $bz_line=  calculate_in_curve_all($width,$height,$in_vector_size,$key);
                        echo '<path class="influence-graph__line influence-graph__line--influencedBy" marker-end="" d="'.$bz_line.'"></path>';
                        
                    }
                    $poly=  calculate_in_polygon_all($width,$height);
                    echo '<polygon class="influence-graph__influencedBy-arrow" points="'.$poly.'"></polygon>';
                    ?>
                           </g>
                        </svg>
                    </div>
                    <div class="influence-graph__current-author">
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo $patient."<br>"."<br>"; ?></strong></div>
                            
                        </div>
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo "<br>"."<br>" ?></strong></div>
                        </div>
                        
                        
                        <div class="influence-graph__current-author__name">
                            <div class="influence-graph__current-author__name-inner"><strong><?php echo "(Patient is ".$bmi_msg.")"; ?></strong></div>
                        </div>
                    </div>
                    <div class="influence-graph__lines">
                        <svg height="<?php echo $height;?>" width="<?php echo $width;?>">
                            <defs>
                                <marker id="arrowhead" viewBox="0 0 40 40" refX="30" refY="30" markerWidth="30" markerHeight="30" orient="auto">
                                    <path d="M 30 22 L 40 30 L 30 38 z"></path>
                                </marker>
                            </defs>
                            <g>
                            <?php
                    for ($i=0;$i<count($prob);$i++) {
                        $bz_line=  calculate_out_curve_all($width,$height,$out_vector_size,$i);
                        echo '<path class="influence-graph__line influence-graph__line--influenced" marker-end="url(#arrowhead)" d="'.$bz_line.'"></path>';
                    }
                    ?>
                              </g>
                        </svg>
                    </div>
                </div>
                <div class="influence-graph__nodes influenced" id="outer">
                                        <?php
                                        for($i=0;$i<count($prob);$i++)
                    {
                        $key_value=  explode('=', $prob[$i]);
                       echo '<div class="tooltip-parent influence-graph__node">';
                        echo '<span class="influence-graph__node__score badge badge--highlight">'.sprintf("%0.2f",$key_value[1]).'</span>';
                        echo '<a class="influence-graph__node__link" href="#">'.$key_value[0].'</a>';
                        echo'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
  
///////////////////////////////////////////////////////// MLP ////////////////////////////////////////////////////////////////////////
$prediction=array();
if(isset($_POST['mlp_sym']))
{
    
    $p_id=$_POST['p_id'];
    

$disease_master=array();

$p_sev1=array();
$p_sev2=array();
$p_sev3=array();
$p_sev4=array();

$floats1=array();
$floats2=array();
$floats3=array();
$floats4=array();
$floats5=array();
$floats6=array();
$floats7=array();
$floats8=array();
$floats9=array();
$floats10=array();
$floats11=array();



$con=new mysqli("localhost","root","","dxx");
if($con)
{
    //Feching disease data
    $query="select * from ml_disease_master";
    $result=  mysqli_query($con, $query);
    $disease_master=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $disease_names=  array_column($disease_master, 'dx_title');
    
     $query1="select * from ml_patiet_data where patient_id='$p_id'";
    $result1=mysqli_query($con,$query1);
    $row=mysqli_fetch_array($result1);   
    
    $symp_prob=  array_column($disease_master, 'symptom_prob');
    $hist_prob=array_column($disease_master, 'history_prob');
  $lab_prob=array_column($disease_master, 'lab_test_prob');
   
      
    if(count($symp_prob)>0)
    {
        $floats1= array_map('floatval', explode(',', $symp_prob[0]));
        $floats2= array_map('floatval',explode(',', $symp_prob[1]));
        $floats3= array_map('floatval',explode(',', $symp_prob[2]));
        $floats4= array_map('floatval',explode(',', $symp_prob[3]));
        $floats5= array_map('floatval',explode(',', $symp_prob[4]));
        $floats6= array_map('floatval',explode(',', $symp_prob[5]));
        $floats7= array_map('floatval',explode(',', $symp_prob[6]));
        $floats8= array_map('floatval',explode(',', $symp_prob[7]));
        $floats9= array_map('floatval',explode(',', $symp_prob[8]));
        $floats10= array_map('floatval',explode(',', $symp_prob[9]));
        $floats11= array_map('floatval',explode(',', $symp_prob[10]));
//        $floats1=  explode(',', $symp_prob[0]);
//        $floats2= explode(',', $symp_prob[1]);
//        $floats3= explode(',', $symp_prob[2]);
//        $floats4= explode(',', $symp_prob[3]);
//        $floats5= explode(',', $symp_prob[4]);
//        $floats6= explode(',', $symp_prob[5]);
//        $floats7= explode(',', $symp_prob[6]);
//        $floats8= explode(',', $symp_prob[7]);
//        $floats9= explode(',', $symp_prob[8]);
//        $floats10= explode(',', $symp_prob[9]);
//        $floats11= explode(',', $symp_prob[10]);
        }
    
    $mlp_symptoms = new MLPClassifier(11, [2],$disease_names); // 4 nodes in input layer, 2 nodes in first hidden layer and 3 possible labels.
    $mlp_symptoms->train(
//            $samples1=array($floats1,$floats2,$floats3),
        $samples1=array($floats1,$floats2,$floats3,$floats4,$floats5,$floats6,$floats7,$floats8,$floats9,$floats10,$floats11),
        $targets1=$disease_names
    );
    
 
  
    if(count($hist_prob)>0)
    {
        $floats1= array_map('floatval', explode(',', $hist_prob[0]));
        $floats2= array_map('floatval',explode(',', $hist_prob[1]));
        $floats3= array_map('floatval',explode(',', $hist_prob[2]));
        $floats4= array_map('floatval',explode(',', $hist_prob[3]));
         $floats5= array_map('floatval',explode(',', $hist_prob[4]));
        $floats6= array_map('floatval',explode(',', $hist_prob[5]));
        $floats7= array_map('floatval',explode(',', $hist_prob[6]));
        $floats8= array_map('floatval',explode(',', $hist_prob[7]));
        $floats9= array_map('floatval',explode(',',$hist_prob[8]));
        $floats10= array_map('floatval',explode(',',$hist_prob[9]));
        $floats11= array_map('floatval',explode(',', $hist_prob[10]));
//        $floats1= explode(',', $hist_prob[0]);
//        $floats2= explode(',', $hist_prob[1]);
//        $floats3= explode(',', $hist_prob[2]);
//        $floats4= explode(',', $hist_prob[3]);
//         $floats5= explode(',', $hist_prob[4]);
//        $floats6= explode(',', $hist_prob[5]);
//        $floats7= explode(',', $hist_prob[6]);
//        $floats8= explode(',', $hist_prob[7]);
//        $floats9= explode(',',$hist_prob[8]);
//        $floats10= explode(',',$hist_prob[9]);
//        $floats11= explode(',', $hist_prob[10]);
        }
    $mlp_hist = new MLPClassifier(11, [2], $disease_names); 
    $mlp_hist->train(
        $samples2=array($floats1,$floats2,$floats3,$floats4,$floats5,$floats6,$floats7,$floats8,$floats9,$floats10,$floats11),
        $targets2=$disease_names
    );


    if(count($lab_prob)>0)
    {
       $floats1= array_map('floatval', explode(',', $lab_prob[0]));
        $floats2= array_map('floatval',explode(',', $lab_prob[1]));
        $floats3= array_map('floatval',explode(',', $lab_prob[2]));
        $floats4= array_map('floatval',explode(',', $lab_prob[3]));
         $floats5= array_map('floatval',explode(',', $lab_prob[4]));
        $floats6= array_map('floatval',explode(',', $lab_prob[5]));
        $floats7= array_map('floatval',explode(',', $lab_prob[6]));
        $floats8= array_map('floatval',explode(',', $lab_prob[7]));
        $floats9= array_map('floatval',explode(',', $lab_prob[8]));
        $floats10= array_map('floatval',explode(',', $lab_prob[9]));
        $floats11= array_map('floatval',explode(',', $lab_prob[10]));
//            $floats1=  explode(',', $lab_prob[0]);
//        $floats2= explode(',', $lab_prob[1]);
//        $floats3= explode(',', $lab_prob[2]);
//        $floats4= explode(',', $lab_prob[3]);
//         $floats5= explode(',', $lab_prob[4]);
//        $floats6= explode(',', $lab_prob[5]);
//        $floats7= explode(',', $lab_prob[6]);
//        $floats8= explode(',', $lab_prob[7]);
//        $floats9= explode(',', $lab_prob[8]);
//        $floats10= explode(',', $lab_prob[9]);
//        $floats11= explode(',', $lab_prob[10]);
    }
    $mlp_lab = new MLPClassifier(11, [[3, new BinaryStep]], $disease_names); 
    $mlp_lab->train(
        $samples4=array($floats1,$floats2,$floats3,$floats4,$floats5,$floats6,$floats7,$floats8,$floats9,$floats10,$floats11),
        $targets4=$disease_names
    );

    //Fetching patient data
   $query1="select * from ml_patiet_data where patient_id='$p_id'";
    $result1=mysqli_query($con,$query1);
    $row=mysqli_fetch_array($result1);   

   // $prediction=array();
    
   if($row>0)
    {
        
      $p_sev1=  array_map('floatval', explode(',', $row['symptoms_value']));
       $prediction[0]=$mlp_symptoms ->predict($p_sev1);
        print_r($prediction[0]);
         echo "<br>";
       $p_sev2=  array_map('floatval', explode(',', $row['historys_prob']));
        $prediction[1]=$mlp_hist ->predict($p_sev2);
      print_r($prediction[1]);
         echo "<br>";
       
        $p_sev4=  array_map('floatval', explode(',', $row['lab_prob']));
       $prediction[2]=$mlp_lab ->predict($p_sev4);
       print_r($prediction[2]);
       echo "<br>";
     
//       $p_sev1=  array_map('floatval', explode(',', $row['symptoms_list']));
//       $prediction[0]=$mlp_symptoms ->predict($p_sev1);
//        print_r($prediction[0]);
//        
//       $p_sev2=  array_map('floatval', explode(',', $row['history']));
//        $prediction[1]=$mlp_hist ->predict($p_sev2);
//      print_r($prediction[1]);
//        
//       
//        $p_sev4=  array_map('floatval', explode(',', $row['lab_list']));
//       $prediction[2]=$mlp_lab ->predict($p_sev4);
//       print_r($prediction[2]);
      
        print_r(array_count_values($prediction));
  
   }

}   
    
}







?>

