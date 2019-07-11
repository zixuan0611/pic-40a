#!/usr/local/bin/php
<?php
	session_name('Demo'); // resume Demo session
	session_start();
	$help_name = $_SESSION['email']; // start a session

	if(isset($_POST['adding'])){ //if add an event
		$our_file = fopen('event.txt', 'a') or die('cannot open');
		fwrite($our_file, $help_name);
		fwrite($our_file, "\t");
		fwrite($our_file, $_POST['event_time']);
		fwrite($our_file, "\t");
		fwrite($our_file, $_POST['event_content']);
		fwrite($our_file, "\n");
		fclose($our_file); 				
	 } ?>
	<script type="text/javascript">
			let our_name = "<?php echo $help_name ?>"; 
			showEvent(our_name);

			/**
			This function shows events on the left coloumn

			@param string $name the email address the user entered
			*/

			function showEvent(name) {

				let xhttp = new XMLHttpRequest(); // object to do ajax with
				xhttp.onreadystatechange = function() { //get file content
					if (this.readyState === 4 && this.status === 200) { //get
						let names = this.responseText;
						names = names.replace(/\r\n/g, "\n");
						names = names.replace(/\r/g, "\n");
						names = names.split("\n");
						for(let i = 0; i < names.length; i+=1){
							events = names[i].split("\t");
							//alert(events[0]);
							//alert(events);
							//alert(names[0]);
							if (events[0] === name) { //if found the user email
								let rei = document.getElementsByClassName("calendar_events")[0];
								let cell = document.createElement("div");
								cell.classList.add("event_item");
								let cell2 = document.createElement("div");
								cell2.classList.add("event_dot");

								let cell3 = document.createElement("div");
								cell3.classList.add("event_title");
								let celltext = document.createTextNode(events[1]);
								cell3.appendChild(celltext);

								let cell4 = document.createElement("div");
								cell4.classList.add("event_msg");
								let celltext2 = document.createTextNode(events[2]);
								cell4.appendChild(celltext2);

								let b_cell = document.createElement("button");
								b_cell.onclick=function() {this.parentNode.remove();};
								b_cell.classList.add("minus");
								let b_sub = document.createElement("i");
								b_sub.classList.add("fa");
								b_sub.classList.add("fa-minus");
								b_sub.style.color="white";
								b_cell.appendChild(b_sub);

								cell.appendChild(cell2);
								cell.appendChild(cell3);
								cell.appendChild(b_cell);
								cell.appendChild(cell4);
								rei.appendChild(cell);

							}
						}
					}

				};
				// set GET request to read from the file, doing it 'asynchronously'
				xhttp.open("GET", "event.txt", true);
				xhttp.send(); // do it!
			}

			
		</script>			
	

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Calendar</title>
	<link rel="stylesheet" href="project.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" defer></script>
	<script src="calendar.js" defer ></script>
</head>

<body>
	<div id="wrap">
		<div id="left_col">
			
			<div class="container">
				<div class="calendar_header">
					<h1>Welcome Back</h1>
				</div>
				
				<div class="calendar_title">
					<div class="cl_title">Today</div>
					<div class="cl_date"></div>
				</div>
			<div class="calendar_events">
				<p class="ce_title">Upcoming Events</p>
				
				
				<div class="event_item">
					<div class="event_dot"></div>
					<div class="event_title">06/11/2019 12:00 am</div>
					<button class="minus" onclick="removeDiv(this)"><i class="fa fa-minus" style="color:white"></i></button>
					<div class="event_msg">Zixuan's birthday (example)</div>
				</div>
			</div>

			<div class="add_event">
				
				<form method = "post">
					Event Time (recommended form mm/dd/yyyy ??:?? am/pm): 
					<br>
					<input type="text" name="event_time" value="06/11/2019 12:00 am"><br>
					Event Content: 
					<br>
					<input type="text" name="event_content" value="Zixuan's birthday"><br>
					<input type="submit" name="adding" onclick="window.location.href='calendar.php';" class="add_eve" value="add event"/>
				</form>

			</div>

		</div>
	</div>

		<div id="right_col">
			<h1> Calendar </h1>
			
			<div class="month">   
				<ul style="list-style:none;">
					<li id="monthAndYear">
						
					</li>
				</ul>
			</div>
			<ul class="weekdays">
				<li>Sun</li>
				<li>Mon</li>
				<li>Tue</li>
				<li>Wed</li>
				<li>Thu</li>
				<li>Fri</li>
				<li>Sat</li>
			</ul>
			<ul class="days">
				
			</ul>
			<button class="link_button" id="previous" onclick="previous()">Previous Month</button>

            <button class="link_button" id="next" onclick="next()">Next Month</button>
            <br>
            <form method="get" action="logout.php">
            	<input class="link_button" type="submit" name="log_out" value="log out" />
            </form>
		</div>
	</div>



</body>

</html>
