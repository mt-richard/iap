<?php 
include("./includes/head.php");
?>
 <script src="https://cdn.tailwindcss.com"></script>

<!-- logbook -->
<?php
function redirect()
{
    echo "Unautorized <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./reports">';
    exit(0);
}
if (!input::required(array('rname'))) {
    redirect();
}
$rName = input::get("rname"); // report name;
$from = input::get('from');
$to = input::get('to');
$cIntern=$database->get("*","a_internaship_periode","status='activated'");
if(!isset($cIntern->id)){
  $cIntern=$database->get("*","a_internaship_periode","order by id desc"); 
} 
$totalDays=(int)input::getRemainingDateTime($cIntern->start_date,$cIntern->end_date);
if ($rName == "LSNCL") {
    // list of students did not completed de course
    $fdata=[];
    $sups = $database->fetch("SELECT id,first_name,last_name,major_in,card_id FROM a_student_tb where internaship_periode_id={$cIntern->id}");
    // print_r($sups);
    foreach ($sups as $key => $s) {
        $id=$s['card_id'];
        $studentLogBook=$database->count_all(" a_student_logbook where student_id='$id'");
        $pp=$studentLogBook?$studentLogBook:1;
        $fdata[]=(object)[
    "name"=>$s['first_name'].' '.$s['last_name'],
    "major_in"=>$s['major_in'],
    "card_id"=>$s['card_id'],
    "attended"=>$studentLogBook,
    "per"=>$studentLogBook?round($pp*100/$totalDays,1):0];
    }
    usort($fdata,function($first,$second){
        return $first->per < $second->per;
    });
}

?>

<div class="bg-gray-400 col-12 flex flex-col items-center justify-center">
<!-- cover -->
    <div class="w-[1200px] h-[1570px]  container-fluid col-8 bg-yellow-200 py-5 px-5 ">
        <div class="row card px-5 py-5 bg-yellow-200 border-2 border-gray-800 rounded-3xl">
            <div class="col-12 ">
                <div class="h-100 w-full flex justify-center items-center flex-col">
                    <img src="images/rplogo.png" alt="" class="pb-10 w-80">
                    <h3 class="font-black text-5xl text-gray-900">Rwanda Polytechnic</h3>
                    <div class="flex w-full pt-5 gap-1">
                        <div class="w-1/3 h-4 rounded-md bg-green-600"></div>
                        <div class="w-1/3 h-4 rounded-md bg-yellow-600"></div>
                        <div class="w-1/3 h-4 rounded-md bg-blue-500"></div>
                    </div>
                    <div class="flex justify-center flex-col items-center py-5">
                        <h1 class="text-4xl text-gray-800 font-black py-2">IPRC KIGALI</h1>
                        <h1 class="text-3xl text-gray-800">Industrial Attachment Program (IAP)</h1>
                    </div>
                    <div class="flex justify-center flex-col items-center py-1">
                        <h1 class="text-4xl text-gray-800 font-black">STUDENT LOGBOOK</h1>
                        <!-- <h1>Industrial Attachment Program (IAP)</h1> -->
                    </div>
                    <?php 
                                $id=(int)$_GET['student_id'];
                                $std = $database->get("*","a_student_tb","card_id = $id");
                                $iap = $database->get("*","a_internaship_periode","id=$std->internaship_periode_id");
                                ?>
                    <h3 class="py-3 text-xl text-gray-800 font-bold">IAP Period ( from <?= $iap->start_date?> to <?= $iap->end_date?> )</h3>
                    
                    <div class="flex justify-between w-full py-5">
                        <div class="flex flex-col w-1/2">
                            <span class="text-gray-700 font-semibold"></span></span>
                            <h1 class="text-gray-800 text-[20px] font-bold py-3">STUDENT IDENTIFICATION</h1>
                            <span class="ml-4 leading-8 text-gray-700 text-xl capitalize">Names : <span class="text-gray-700 font-semibold"><?= $std->first_name." ".$std->last_name; ?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Registration No :  <span class="text-gray-700 font-semibold"><?= $std->card_id; ?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Phone :  <span class="text-gray-700 font-semibold"><?= $std->phone; ?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Email :  <span class="text-gray-700 font-semibold"><?= $std->email; ?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Department :  <span class="text-gray-700 font-semibold"><?= $std->major_in; ?></span></span>
                        </div>
                        <div class="flex flex-col w-1/2">
                            <?php 
                                $id = $std->partner_id;
                                $pat = $database->get("*","a_partner_tb","id = $id");
                                $person = $database->get("*","a_users","institition_id = $id");
                                ?>
                            <h1 class="text-gray-800 text-[20px] font-bold py-3">COMPANY IDENTIFICATION</h1>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Names of Company : <span class="text-gray-700 font-semibold"><?= $pat->name;?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Location: <span class="text-gray-700 font-semibold"><?= $pat->place;?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Contact Person : <span class="text-gray-700 font-semibold"><?= $person->names;?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Phone : <span class="text-gray-700 font-semibold"><?= $pat->phone;?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Email : <span class="text-gray-700 font-semibold"><?= $pat->email;?></span></span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Area of Specialisation : <span class="text-gray-700 font-semibold"><?= $pat->major_in;?></span></span>
                            
                        </div>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="flex flex-col  w-1/2  ">
                            <h1 class="text-gray-800 text-[20px] font-bold py-3">COLLEGE INDUSTRY LIAISON SPECIALIST</h1>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Names : Apophia KATUSHABE</span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Phone : (+250) 785 703 490</span>
                            <span class="ml-4 leading-8 text-gray-700 text-lg">Email : katupophia2016@gmail.com</span>
                        </div>
                        <div class=" w-1/2"></div>
                    </div>
                    
                </div>
            </div>
        </div>   
    </div>
<!-- cover end  -->
<!-- some content -->
    <div class="w-[1200px] h-[1570px] m-2 container-fluid col-8 bg-white py-10 px-5 flex flex-col justify-center">
       <div class="py-20">
            <h3 class="text-center font-black text-4xl text-gray-900">Statement of Commitment</h3>
            <div class="flex w-full pt-5 gap-1">
                <div class="w-1/3 h-4 rounded-md bg-green-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-yellow-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-blue-500"></div>
            </div>
       </div> 

       <div>
        <p class="leading-10 text-gray-600 font-semibold text-xl">I  <span class="font-black text-gray-900 text-xl"><?= $std->first_name ?>  <?= $std->last_name ?></span>, a level 6/ Level 7/ Level 8 student of <span class="font-black text-gray-900 text-xl"><?= $std->major_in ?></span> (Program of study) hereby do commit myself to undertake the industrial attachement Program (IAP) at (company Name)  <span class="font-black text-gray-900 text-xl"><?= $pat->name ?> </span>  Located at  <span class="font-black text-gray-900 text-xl"><?= $pat->place ?></span>  District/ Sector for minimum of 45 Days.</p>

        <p class="leading-10 text-gray-600 font-semibold text-xl py-5">I also do commit myself to start and finish my industrial attachment in one instruction as approved by the college. If it becomes absolutely necessary to change my company of industrial attachment, I should first secure written permission from the college. Any of industrial attachment not properly authorized will be cancelled.
        </p>
       </div>
    
    </div>
<!-- end of content -->
    <div class="w-[1200px] h-[1570px] m-2 container-fluid col-8 bg-white py-10 px-5 flex flex-col justify-center">
       <div class="py-10">
            <h3 class="text-center font-black text-4xl text-gray-900">Instruction to complete this Logbook</h3>
            <div class="flex w-full pt-5 gap-1">
                <div class="w-1/3 h-4 rounded-md bg-green-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-yellow-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-blue-500"></div>
            </div>
       </div> 
       <div class= "px-20" >
        <p class='font-bold'>This Log Book is divided into five sections: </p>
        <div class="py-2">
            <span class="font-bold text-xl py-2 text-gray-900"> SECTION ONE: Key Competencies for Industrial Attachment </span> 
            <p class="py-3 text-lg">This section is about the list of Competencies that can be practiced by students during Industrial Attachment. This list is provided by Rwanda Polytechnic.</p> 
        </div>     
        <div class="py-2">
            <span class="font-bold text-xl py-2 text-gray-900">SECTION TWO: Industrial Attachment Plan </span>
            <p class="py-3 text-lg">This section is about the Industrial Attachment plan which contains a list of competencies, activities, and timeframe to be practiced by the student during the industrial attachment. With the assistance of in company supervisor, a student should, during his/her IA period. cover at least 50% of due competencies. </p>
        </div>
        <div class="py-2">
            <span class="font-bold text-xl py-2 text-gray-900">SECTION THREE: Weekly report sheet </span>
            <p class="py-3 text-lg">This section is about the form for a daily detailed description of work to be filled on a daily basis duringthe industrial attachment. The part will be filled by the student at the end of every working day and should comprehensively indicate the tasks done and the skills learned on that particular day. At the end of every week, the company supervisor should grade the performance of a student. </p>
        </div>
        <div class="py-2">
            <span class="font-bold text-xl py-2 text-gray-900">SECTION FOUR: Student attendance sheet. </span>
            <p class="py-3 text-lg">This section is about the form for Industrial Attachment Attendance Sheet to be filled and signed by the student for presence record, with confirmation by the company supervisor. If a student is on Medical Leave, he/she will indicate "ML" in the Attendance Sheet and will attach his/her medical certificate (original or duplicate) to this Attendance Sheet. If a student is granted official leave, he/she will indicate "ON LEAVE" in the Attendance Sheet. and attach supporting documents. Failing that, he/she will be considered absent on that day. </p>
        </div>
        <div class="py-2">
            <span class="font-bold text-xl py-2 text-gray-900">SECTION FIVE: Annexes </span>
            <p class="py-3 text-lg">This section is about other industrial attachment tools helping the industrial attachment program planning, monitoring, and evaluation as annexed to this logbook.</p>
        </div>

       </div>
    
    </div>

    <!-- section 1 -->
    <div class="w-[1200px] h-[1570px] m-2 container-fluid col-8 bg-white py-10 px-5 flex flex-col">
       <div class="py-10">
            <h3 class="text-center font-black text-4xl text-gray-900">SECTION ONE: Key Competencies</h3>
            <div class="flex w-full pt-5 gap-1">
                <div class="w-1/3 h-4 rounded-md bg-green-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-yellow-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-blue-500"></div>
            </div>
       </div> 
       <div class= "px-20" >
            <p class='font-bold text-xl py-2 text-gray-900 py-5'>List of comptencies that can be practiced during IAP: </p>
            
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700"> 1 : Sieve analysis test  </span> 
            </div>     
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">2 : Perform Slump test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">3 : Perform Sand equivalent test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">4 : Perform Proctor test. </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Execute Deflexion test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Executute Dynamic cone penetration test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Perform Compression testing </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Perform California bearing ratio (cbr) test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Perform Atterberg limits test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Perform Los angeles test </span>
            </div>
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">5 : Perform In situ density test </span>
            </div>
       </div>
    
    </div>

    <!-- section 2 -->
    <div class="w-[1200px] h-[1570px] m-2 container-fluid col-8 bg-white py-10 px-5 flex flex-col">
       <div class="py-10">
            <h3 class="text-center font-black text-4xl text-gray-900">SECTION TWO : Industrial Attachment Plan </h3>
            <div class="flex w-full pt-5 gap-1">
                <div class="w-1/3 h-4 rounded-md bg-green-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-yellow-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-blue-500"></div>
            </div>
       </div> 
       <div class= "px-20" >
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700"> This IA plan is completed by the student and the company supervisor. Competencies should be selected from the list stated in section one.  </span> 
            </div>     
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">Note:The student plan to perform the tasks/work reflecting at least 50% of the competencies stated in section one. </span>
            </div>
       </div>

       <div class="flex justify-between px-20 py-5">
        <h3 class="font-semibold text-lg">Starting date : <?= $iap->start_date?> </h3>
        <h3 class="font-semibold text-lg">Ending date : <?= $iap->end_date?> </h3>
       </div>
       <div class="px-20">
        <table class="w-full text-gray-700">
            <thead>
                <tr class="border-b border-t border-gray-400 m-3 bg-gray-600 text-gray-100">
                    <th class="p-2">No</th>
                    <th class="p-2">Specific Competence to implement</th>
                    <th class="p-2">Activities to carry out</th>
                    <th class="p-2">Timeframe</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-400 m-3">
                    <td class="py-2">0</td>
                    <td class="py-2">Perform Slump test</td>
                    <td class="py-2">Testing Slump</td>
                    <td class="py-2">2 hours</td>
                </tr>
                <tr class="border-b border-gray-400 m-3">
                    <td class="py-2">1</td>
                    <td class="py-2">Perform Slump test</td>
                    <td class="py-2">Testing Slump</td>
                    <td class="py-2">2 hours</td>
                </tr>
                <tr class="border-b border-gray-400 m-3">
                    <td class="py-2">2</td>
                    <td class="py-2">Perform Slump test</td>
                    <td class="py-2">Testing Slump</td>
                    <td class="py-2">2 hours</td>
                </tr>
                <tr class="border-b border-gray-400 m-3">
                    <td class="py-2">3</td>
                    <td class="py-2">Perform Slump test</td>
                    <td class="py-2">Testing Slump</td>
                    <td class="py-2">2 hours</td>
                </tr>
                <tr class="border-b border-gray-400 m-3">
                    <td class="py-2">4</td>
                    <td class="py-2">Perform Slump test</td>
                    <td class="py-2">Testing Slump</td>
                    <td class="py-2">2 hours</td>
                </tr>
            </tbody>
        </table>
       </div>

    </div>

    <!-- section 2 -->
    <div class="w-[1200px] h-[1570px] m-2 container-fluid col-8 bg-white py-10 px-5 flex flex-col">
       <div class="py-10">
            <h3 class="text-center font-black text-4xl text-gray-900">SECTION Three : Weekly report Sheet </h3>
            <div class="flex w-full pt-5 gap-1">
                <div class="w-1/3 h-4 rounded-md bg-green-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-yellow-600"></div>
                <div class="w-1/3 h-4 rounded-md bg-blue-500"></div>
            </div>
       </div> 
       <div class= "px-20" >
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700"> This weekly report sheet is to be filled every day by the student, on the basis of the IA Plan. It is a tool for the student to keep track of the work performed and the tools used.
  </span> 
            </div>     
            <div class="py-2">
                <span class="font-bold text-xl py-2 text-gray-700">It is a supporting tool for the college's supervisor during the IAP final interview, to check the work performed and the tools used.</span>
            </div>
       </div>

       <div class="flex justify-start px-20 py-5">
        <h3 class="font-semibold text-lg">Date: From : <?= $iap->start_date?> </h3>
        <h3 class="font-semibold text-lg">  to : <?= $iap->end_date?> </h3>
       </div>


       <?php if ($rName == "SLB" && isset($_GET['student_id'])) {
 
            $id=(int)$_GET['student_id'];
            $cond="WHERE st.card_id=al.student_id  AND al.internaship_id='{$cIntern->id}'";
            if($id!=0){
            $student=$database->get("*","a_student_tb","card_id=$id");
            if(!isset($student->id) ){
                echo "<center><div class='alert alert-danger'>Student with $id as student id not found try again</center></h1>";
                exit(0);
            }
            $cond="WHERE st.card_id=al.student_id AND al.student_id=$student->card_id AND al.internaship_id='{$cIntern->id}'";
            }
            $sql= "SELECT al.*,st.first_name,st.last_name,st.card_id, st.phone, st.email, st.major_in FROM a_student_logbook as al INNER JOIN a_student_tb as st $cond order by al.log_date asc";
                // echo $sql;
            $lists=$database->fetch($sql);
        ?>
       <div class="px-20">
        <table class="w-full text-gray-700">
            <thead>
                <tr class="border-b border-t border-gray-400 m-3 bg-gray-600 text-gray-100">
                    <th class="p-2">No</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Objectives</th>
                    <th class="p-2">Challenges</th>
                    <th class="p-2">Partner Comment</th>
                    <th class="p-2">Supervisor Comment</th>
                </tr>
            </thead>
            <tbody class="text-md">
                                        <?php
                                            $i=0;
                                            foreach ($lists as $key => $h) {
                                                $i++;
                                                ?>
                                                <tr class="border-b border-t border-gray-400">
                                                    <td class="p-2 border-l border-r"><?= $i?></td>
                                                    <td class="p-2 border-l border-r" class=""><?= $h['created_at'] ?></td>
                                                    <td class="p-2 border-l border-r" class=""><?= $h['objective'] ?></td>
                                                    <td class="p-2 border-l border-r" class=""><?= $h['challenges'] ?></td>
                                                    <td class="p-2 border-l border-r" class=""><?= $h['partner_comment'] ?></td>
                                                    <td class="p-2 border-l border-r" class="" id="sup<?=$h['id']?>"><?= $h['suppervisior_comment'] ?></td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
        </table>
       </div>
    </div>
<!-- daily acts -->
   
    <?php }?>
<!-- daily ends -->


</div>
<!-- include footer -->
<?php include_once("./footer.php") ?>