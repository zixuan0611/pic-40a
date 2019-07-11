let our_name = "";
let our_speed = "";
let our_color = "";
/**
This function makes a cookie out of the user data.
It expires in ten seconds.
*/
function make_cookie(){
	let cookie_name = "name=" + our_name + ";";
	let cookie_speed = "speed=" + our_speed + ";";
	let cookie_color = "color=" + our_color + ";";
	let now = new Date(), expires = now;
	expires.setSeconds(expires.getSeconds()+10);
	let cookie_expires = "expires=" + expires.toUTCString() + ";";
	let cookie_path = "path=/;"
	document.cookie = cookie_name + cookie_expires + cookie_path;
	document.cookie = cookie_speed + cookie_expires + cookie_path;
	document.cookie = cookie_color + cookie_expires + cookie_path;
}

/**
This function is executed once the window loads
*/
// when the window loads
window.onload = function(){
	if (document.cookie.toString().includes("speed")) {
		let c = document.cookie.split(';');

		let fields = ["name", "speed", "color"];
		for(let field of fields){ // go through each field to populate
		    for(let part of c){ // look at all parts of the cookie
			    let pieces = part.split('='); // split that, the right part

			    if(pieces.length===2){ // so enough parts
				   while(pieces[0][0] === ' '){ // while whitespace at start
				       pieces[0] = pieces[0].substr(1); // remove it!
				}

				if(pieces[0] === field){ // if field found within part
					if (field === "name") { // if the field is name
						our_name = pieces[1];
					}
					else if (field === "speed") { //if the field is speed
						our_speed = pieces[1];
					}
					else if (field === "color") { //if the field is color
						our_color = pieces[1];
					}
				}
			}
		}
	}
		/*for(let i = 0; i <=c.length; i+=1) {
			i = parseInt(i);
			if (c[i].split('=')[0] === "name") {
				our_name = c[i].split('=')[1];
			}
			else if (c[i][0] ==="speed") {
				our_speed = c[i].split('=')[1];
			}
			else if (c[i][0]==="color") {
				our_color = c[i].split('=')[1];
			}
		}*/

		
	}
	else{
		our_name = prompt("What is your name?", "");		
		our_speed = "0";
		our_color = "red";
	}
	
	let xhttp = new XMLHttpRequest(); // object to do ajax with

	// when the operation is complete (readyState 4) and it is successful ( status 200)
	xhttp.onreadystatechange = function() {
		if (this.readyState === 4 && this.status === 200) {
			// change HTML to store what came back
			let names = this.responseText;
			
			let name_include = false;
			names = names.replace(/\r\n/g, "\n");
			names = names.replace(/\r/g, "\n");
			names = names.split("\n");
			
			for(let i = 0; i < names.length; i+=1){
				
				if (names[i]===our_name && names[i] !== "") {					
					name_include = true;
				}
			}
			
			if (name_include) { //if important name is found
				/*if(document.cookie === ''){
					let cookie_name = "name=" + name + ";";
					let cookie_speed = "speed=" + "0" + ";";
					let cookie_color = "color=" + "red"+ ";";
					let now = new Date(), expires = now;
					expires.setSeconds(expires.getSeconds()+10);
					let cookie_expires = "expires=" + expires.toUTCString() + ";";
					let cookie_path = "path=/;"
					document.cookie = cookie_name + cookie_expires + cookie_path;
					document.cookie = cookie_speed + cookie_expires + cookie_path;
					document.cookie = cookie_color + cookie_expires + cookie_path;
				}
				else{
					let fields = ["name", "speed", "color"];
				}*/
				
				let new_form = document.createElement("form");
				let set1 = document.createElement("fieldset");
				let set2 = document.createElement("fieldset");
				new_form.appendChild(set1);
				new_form.appendChild(set2);
				for(let i = 0; i <= 50; i+=1){ //create buttons
					let new_label = document.createElement("label");
					let label_text = document.createTextNode("Speed " + i);
					new_label.appendChild(label_text);
					let new_button = document.createElement("input");
					new_button.type="radio";
					new_button.name="speed";
					b_id = i.toString();
					new_button.id = b_id;
					new_button.value = b_id;
					if (i === parseInt(our_speed)) { //if need to check speed button
						new_button.checked = true;
					}
					set1.appendChild(new_label);
					set1.appendChild(new_button);
					if (i === 0 || i % 10 === 0) { //if need to insert a line break
						set1.appendChild(document.createElement("br"));
					}
				}
				let color1_label = document.createElement("label");
				let color1_text = document.createTextNode("red");
				color1_label.appendChild(color1_text);
				let color1_button = document.createElement("input");
				color1_button.type = "radio";
				color1_button.name = "color";
				color1_button.id = "red";
				color1_button.value = "red";
				//color1_button.checked = "true";
				set2.appendChild(color1_label);
				set2.appendChild(color1_button);

				let color2_label = document.createElement("label");
				let color2_text = document.createTextNode("yellow");
				color2_label.appendChild(color2_text);
				let color2_button = document.createElement("input");
				color2_button.type = "radio";
				color2_button.name = "color";
				color2_button.id = "yellow";
				color2_button.value = "yellow";
				set2.appendChild(color2_label);
				set2.appendChild(color2_button);

				let color3_label = document.createElement("label");
				let color3_text = document.createTextNode("blue");
				color3_label.appendChild(color3_text);
				let color3_button = document.createElement("input");
				color3_button.type = "radio";
				color3_button.name = "color";
				color3_button.id = "blue";
				color3_button.value = "blue";
				set2.appendChild(color3_label);
				set2.appendChild(color3_button);

				if (our_color === "red") { //if need to check red button
					color1_button.checked = "true";
				}
				else if (our_color === "yellow") { //if need to check yellow button
					color2_button.checked = "true";
				}
				else if (our_color === "blue") { //if need to check blue button
					color3_button.checked = "true";
				}

				document.getElementById("valid").appendChild(new_form)

				let div1 = document.createElement("div");
				
				div1.style.background = "grey";
				div1.style.width = "100%";
				div1.style.height = "200px";

				let div2 = document.createElement("div");
				div2.innerHTML = "Welcome " + our_name;
				div2.style.textAlign = 'center';
				
				
				div2.style.background = our_color;
				div2.style.width = "15%";
				div2.style.height = "100px";
				let position = "0%"
				div2.style.margin = "0px 0px 0px " + position;
				//reach the end 85%
				div1.appendChild(div2);
				document.getElementById("move").appendChild(div1);

				our_speed = $('input[name=speed]:checked').val();
				let forward = true;
				/**
				This function moves the box according to corresponding speed and color
				*/
				function to_move(){
					let move_speed = parseFloat(our_speed);
					if (move_speed === 0) { //if speed is zero
						div2.style.margin = "0px 0px 0px " + position;
					}
					else { //if speed is not zero
						let change = move_speed/10;
						let new_position = parseFloat(position);

						if (new_position <= 0) { //if need to make box forward
							forward = true;
						}
						if (new_position >= 85) { //if need to make box backward
							forward = false;
						}
						if (forward === true) { //change position if forward
							new_position = new_position + change;
						}
						else { //change position if backward
							new_position = new_position - change;
						}


						position = new_position.toString() + "%";
						div2.style.margin = "0px 0px 0px " + position;
					}

					move_call_back();
				}

				/** 
				This functionrepeatedly call the to_move function
				*/
				function move_call_back() {
					setTimeout(to_move, 100);
				}

				move_call_back();
				/**
				This function checked the radio buttons for speed and color every second
				*/
				function to_repeat(){
					our_speed = $('input[name=speed]:checked').val(); //string
					our_color = $('input[name=color]:checked').val(); //string
					div2.style.background = our_color;
					
					call_back();

				}
				/**
				This function repeatedly call the to_repeat function (every second)
				*/
				function call_back(){
					setTimeout(to_repeat,1000);
					setTimeout(make_cookie,1000);
				}
				call_back();
			}
			else { //if no cookie and not important name
				document.getElementById("valid").innerHTML = "No greeting for you!";
			}
		}
	};

	// set GET request to read from the file, doing it 'asynchronously'
	xhttp.open("GET", "important.txt", true);
	xhttp.send(); // do it!
};


