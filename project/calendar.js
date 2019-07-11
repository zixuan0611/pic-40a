let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let currentDay = today.getDate();

let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

let monthAndYear = document.getElementById("monthAndYear");
let display_date = document.getElementsByClassName("cl_date")[0];
display_date.innerHTML = months[currentMonth] + " " + currentDay.toString() + ", " + currentYear.toString();
showCalendar(currentMonth, currentYear);

/**
This function hides the corresponding event for this login session.

@param this element
*/

function removeDiv(elem){
    $(elem).parent('div').remove();
}

/**
This function shows next month calendar.

*/
function next() {
    //alert(pass);
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
}

/**
This function shows previous month calendar.

*/
function previous() {
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
}

/**
This function shows the required month calendar.

@param the month of the calendar to show
@param the year of the calendar to show
*/
function showCalendar(month, year) {

    let firstDay = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32).getDate();

    let furuya = document.getElementsByClassName("days")[0]; // body of the calendar
    /*let test = document.createElement("li");
    let testtxt = document.createTextNode("hello");
    test.appendChild(testtxt);
    furuya.appendChild(test);*/

    // clearing all previous cells
    furuya.innerHTML = "";


    // filing data about month
    monthAndYear.innerHTML = months[month] + "<br><span style='font-size:18px'>" + year + "</span>";
    

    // creating all cells
    let date = 1;
    for (let i = 0; i < 6; i++) {

        //creating individual cells, filing them up with data.
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) { //for the weekday before the first day of the month
                let cell = document.createElement("li");
                let cellText = document.createTextNode("");
                cell.appendChild(cellText);
                furuya.appendChild(cell);
            }
            else if (date > daysInMonth) { //for the weekday after the end date of the month
                break;
            }

            else { //the day to display with date
                let cell = document.createElement("li");
                let cellText = document.createTextNode(date);               
                cell.appendChild(cellText);
                //if it is today, highlight
                if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                    cell = document.createElement("li");
                    activate = document.createElement("span");
                    
                    activate.appendChild(cellText);
                    activate.classList.add("active");
                    cell.appendChild(activate);
                } // color today's date
                furuya.appendChild(cell);
                date++;
            }

        }       
    }
}

