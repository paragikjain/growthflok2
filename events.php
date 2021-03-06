<?php
error_reporting(E_ERROR | E_PARSE);
$json_string = file_get_contents("https://graph.facebook.com/v7.0/growthfolks/events/?fields=category,is_online,start_time,end_time,place,type,cover,maybe_count,name&access_token=EAAmI9uiMvgIBAAU2IswvNdLTZBnKSF5zIDnKYWG5dGW8EZBBFRrNWH1MfKWYvuBDxDzXU2cntKtXe72t66UOxyglHoisNJeZAznDrNS9KhaCjqx1sI8FlX6EweV3nCQZBizKd1zap2tAelgLcc2URKhuhuj7TLuyp5iZA5j1NxwZDZD");
$parsed_json = json_decode($json_string);
$signal=1;
//echo "Total Posts :".count($parsed_json->data);
$months=Array('01'=>'January',
			  '02'=>'February',
			  '03'=>'March',
			  '04'=>'April',
			  '05'=>'May',
			  '06'=>'June',
			  '07'=>'July',
			  '08'=>'August',
			  '09'=>'September',
			  '10'=>'October',
			  '11'=>'November',
			  '12'=>'December');
			  
function convert_seconds($seconds) 
{
	$dt1 = new DateTime("@0");
	$dt2 = new DateTime("@$seconds");
	//return $dt1->diff($dt2)->format('%a days, %h hours, %i minutes and %s seconds');
	return $dt1->diff($dt2)->format(' %h H: %i M');
}
set_error_handler(function ($severity, $message, $file, $line) {
    return "Online";
});
/*
for($i=0; $i<count($parsed_json->data); $i++){
	echo "<br><br><h1>Post ".$i."</h1><br>";
	echo "Description: ".$parsed_json->data[$i]->description."<br>";
	echo "Start time: ".$parsed_json->data[$i]->start_time."<br>";
	echo "End time: ".$parsed_json->data[$i]->end_time."<br>";
	echo "time: ".explode("T",$parsed_json->data[$i]->start_time)[1]."<br>";
	echo "date: ".explode("T",(explode("-",$parsed_json->data[$i]->start_time)[2]))[0]."<br>";
	echo "month: ".$months[explode("-",$parsed_json->data[$i]->start_time)[1]]."<br>";
	echo "year: ".explode("-",$parsed_json->data[$i]->start_time)[0]."<br>";
	echo "day: ".date('l',strtotime($parsed_json->data[$i]->end_time))."<br>";
	echo "duration: ".convert_seconds(strtotime($parsed_json->data[$i]->end_time)-strtotime($parsed_json->data[$i]->start_time))."<br>";
    echo "name: ".$parsed_json->data[$i]->name."<br>";
    echo "Category: ".$parsed_json->data[$i]->category."<br>";
    echo "Online: ".$parsed_json->data[$i]->is_online."<br>";
    echo "City: ".$parsed_json->data[$i]->place->location->city."<br>";
    echo "Image: ".$parsed_json->data[$i]->cover->source."<br>";
    echo "id: ".$parsed_json->data[$i]->id."<br>";
}
*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@300;400;500;600;700;800&family=Lato:wght@300;400&display=swap"
        rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>GrothFloks services</title>
</head>

<body>

    <!-- Header Section -->
    <?php require('./common/header.php') ?>
    <!-- Main -->
    <main>

        <section class="herobar">
            <div class="herobar_main">
                <div class="container">
                    <h1>Events</h1>
                </div>
            </div>
        </section>

        <section class="blog_post">
            <div class="container">
                <div class="blog_post--toggel">
                   
                    <div class="blog_post--toggel-btn active_btn">
                        <span><a href="">Upcomming</a></span>
                    </div>
                
                </div>
                
                <!-- Events -->
			<?php
            for($i=0; $i<count($parsed_json->data); $i++){
                $fbdate = strtotime($parsed_json->data[$i]->start_time);
                date_default_timezone_set('Asia/Calcutta');
                $timezone = date_default_timezone_get();
                $date_fb = date('Y-m-d', $fbdate);
                $date_now = date("Y-m-d");
                $date1 = date_create($date_fb);
                $date2 = date_create($date_now);
                $diff=date_diff($date2,$date1);
           if($diff->format("%R%a")>0){
               $signal=0;
               try{
                $city=$parsed_json->data[$i]->place->location->city;
                }
               catch(customException $e){
                 $city="online";
               }
               if($parsed_json->data[$i]->is_online)
               {
                   $online="Online";
               }
               else{
                   $online="Offline";
               }

             echo '<div class="blog_post--events">
		            <div class="blog_post--events-item">
                        <div class="item-img-box">
                            <img height="240" src="'.$parsed_json->data[$i]->cover->source.'" alt="" class="item-img">
                        </div>
                        <div class="item-content">
                            <div class="item-content-h2">
                                <h2>'.$parsed_json->data[$i]->name.'</h2>
                            </div>
                            <div class="item-content-data">
                                <div class="data-set">
                                    <span class="data-head">Date & day</span>
                                    <p>'.explode("T",(explode("-",$parsed_json->data[$i]->start_time)[2]))[0].' '.$months[explode("-",$parsed_json->data[$i]->start_time)[1]].' '.date('l',strtotime($parsed_json->data[$i]->end_time)).'</p>
                                </div>
                                <div class="data-set">
                                    <span class="data-head">Time & Duration</span>
                                    <p>'.explode("+",explode("T",$parsed_json->data[$i]->start_time)[1])[0].','.convert_seconds(strtotime($parsed_json->data[$i]->end_time)-strtotime($parsed_json->data[$i]->start_time)).'</p>
                                </div>
                                <div class="data-set">
                                    <span class="data-head">Location</span>
                                    <p>'.$city.'</p>
                                </div>
                                <div class="data-set">
                                    <span class="data-head">Medium</span>
                                    <p>'.$online.'</p>
                                </div>
                                <div class="data-set">
                                    <span class="data-head">registration</span>
                                    <p>4000 Rs.</p>
                                </div>
                            </div>
                            <div class="item-content-btn">
                              <a href="https://facebook.com/'.$parsed_json->data[$i]->id.'">  <button class="btn">Book Now</button></a   >
                            </div>

                        </div>
                    </div>

                </div>';
            }
        }
        if(count($parsed_json->data)==0 || $signal==1){
            echo "<p>Hey Homie,</p><p>There are no upcoming events right now. There are some really exciting events lined up. We will update you about this soon. Watch this space for more updates.</p>";
        }

			?>
                <!-- end Event sec -->
                <!-- Events -->

        </section>

             
    </main>
   
<?php require('./common/footer.php') ?>
<script>
    $('.nav-item').removeClass("nav-active");
    $('#events').addClass("nav-active");
 </script>
</body>
</html>
