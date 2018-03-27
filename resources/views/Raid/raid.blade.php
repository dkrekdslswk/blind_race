<html>
<head>
	<title>BLUEB</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
var ans = new Array;
var done = new Array;
var score = 0; //정탑
	ans[1] = "c";


function Engine(question, answer) {
	if (answer != ans[question]) {
	if (!done[question]) {
		done[question] = -1;
		alert("Wrong!\n\nYour score is now: " + score);
	}
	else {
		alert("You have already answered that!");
	   }
	}
	else {
		if (!done[question]) {
			done[question] = -1;
			score++;
			alert("Correct!\n\nYour score is now: " + score);
		}
		else {		
			alert("You have already answered that!");
      }
   }
}
	
function NextLevel () {
	if (score > 10) {
		alert("Cheater!");
}
	if (score >= 7 && score <= 11) {
		alert("Access permitted!  But there are no more levels if you don't make any ...")
	}
	else { alert("Access denied!  You need 7 points to enter the next level.")   }
}
//-->
</SCRIPT>
<script>
var timeleft = 10;
var downloadTimer = setInterval(function(){
  document.getElementById("progressBar").value = 10 - --timeleft;
  if(timeleft <= 0)
    clearInterval(downloadTimer);
},1000);
</script>

<BODY>
<center><progress value="0" max="10" id="progressBar"></progress>
<div id="questions">
    <form name="formName" action="url_with_programming_here" method="POST">
        <h2>Write the text of the question here</h2>
        <div class="left_options">
             <p><input type="checkbox" id="answer1"><label for="answer1">Answer 1</label></p>
            <p><input type="checkbox" id="answer2"><label for="answer2">Answer 2</label></p>
        </div>
        <div class="right_options">
          <p><input type="checkbox" id="answer3"><label for="answer3">Answer 3</label></p>
           <p><input type="checkbox" id="answer4"><label for="answer4">Answer 4</label></p>
       </div>
</form>
</center>


<style type="text/css">
	questions {width: 100%; margin: 0 auto;} /*this margin is to center the div automatically, just in case*/
.left_options, .right_optiones {width: 45%; float: left;}
</style>