/**
This function enables an alert box to greet the visitor, explaining the page is a claculator.
using IFFE to not pollute the global environment
no parameters, no return, no intention of calling again
*/
(function() {
	let msg = 'This is a JavaScript calculator';
	alert(msg);
})();

/**
This function gives the result computed by the user input
no parameters, no return, called when the user clicks the compute button
*/
function change(){
	//initialize variables
	let number1 = 0;
	let number2 = 0;
	let outcome = 0;
	
	number1 = parseFloat(document.getElementById("value1").value); //get the first value from the user input
	number2 = parseFloat(document.getElementById("value2").value); //get the second value from the user input
	if (document.getElementById("add").checked) { //if the user selects "add" button, adding two input values
		outcome = number1 + number2;
	}
	else if(document.getElementById("subtract").checked) { //if the user selects "subtract" button, subtracting the second value from the first value
		outcome = number1 - number2;
	}
	else if(document.getElementById("multiply").checked) { //if the user selects "multiply" button, multiplying two input values
		outcome = number1 * number2;
	}
	else if(document.getElementById("divide").checked) { //if the user selects "divide" button, divide the first value by the second value
		outcome = number1 / number2;
	}
	document.getElementById("result").innerHTML = "Result: " + outcome; //give user the output result
}