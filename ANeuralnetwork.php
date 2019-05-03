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

