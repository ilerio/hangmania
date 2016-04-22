<?php 
    session_start(); 
    // Set up connection; redirect to log in if cannot connect or not logged in
    if (filter_input(INPUT_COOKIE, "auth") != 1) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hangmania Play!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link href='https://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet' type='text/css'>
        <style>
            #display, #message, button
            {
                font-family: 'Ubuntu Mono', monospace;
            }
			.hangman_pic{
				margin: 0 auto;
				width: 50%;
			}
        </style>
    </head>
    <body>
        <div class="container"><?php include 'nav.php'; ?></div>
        
        <div class="container">
        <div class="container hangman_pic" style="background-color: white;" >
            <img id="0" src="hm/hm0.jpg" class="img-responsive center-block" style="display: inline"/>
            <img id="1" src="hm/hm1.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="2" src="hm/hm2.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="3" src="hm/hm3.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="4" src="hm/hm4.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="5" src="hm/hm5.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="6" src="hm/hm6.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="7" src="hm/hm7.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="8" src="hm/hm8.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="win" src="hm/win.jpg" class="img-responsive center-block" style="display: none"/>
            <img id="dead" src="hm/dead.jpg" class="img-responsive center-block" style="display: none"/>
        </div>
        <br/>
        <div id="a-z-buttons" class="container jumbotron">
            <h1 id="display"></h1>
            <button id="A" onclick="guess(this.id)" class="btn btn-default input">A</button>
            <button id="B" onclick="guess(this.id)" class="btn btn-default input">B</button>
            <button id="C" onclick="guess(this.id)" class="btn btn-default input">C</button>
            <button id="D" onclick="guess(this.id)" class="btn btn-default input">D</button>
            <button id="E" onclick="guess(this.id)" class="btn btn-default input">E</button>
            <button id="F" onclick="guess(this.id)" class="btn btn-default input">F</button>
            <button id="G" onclick="guess(this.id)" class="btn btn-default input">G</button>
            <button id="H" onclick="guess(this.id)" class="btn btn-default input">H</button>
            <button id="I" onclick="guess(this.id)" class="btn btn-default input">I</button>
            <button id="J" onclick="guess(this.id)" class="btn btn-default input">J</button>
            <button id="K" onclick="guess(this.id)" class="btn btn-default input">K</button>
            <button id="L" onclick="guess(this.id)" class="btn btn-default input">L</button>
            <button id="M" onclick="guess(this.id)" class="btn btn-default input">M</button>
            <button id="N" onclick="guess(this.id)" class="btn btn-default input">N</button>
            <button id="O" onclick="guess(this.id)" class="btn btn-default input">O</button>
            <button id="P" onclick="guess(this.id)" class="btn btn-default input">P</button>
            <button id="Q" onclick="guess(this.id)" class="btn btn-default input">Q</button>
            <button id="R" onclick="guess(this.id)" class="btn btn-default input">R</button>
            <button id="S" onclick="guess(this.id)" class="btn btn-default input">S</button>
            <button id="T" onclick="guess(this.id)" class="btn btn-default input">T</button>
            <button id="U" onclick="guess(this.id)" class="btn btn-default input">U</button>
            <button id="V" onclick="guess(this.id)" class="btn btn-default input">V</button>
            <button id="W" onclick="guess(this.id)" class="btn btn-default input">W</button>
            <button id="X" onclick="guess(this.id)" class="btn btn-default input">X</button>
            <button id="Y" onclick="guess(this.id)" class="btn btn-default input">Y</button>
            <button id="Z" onclick="guess(this.id)" class="btn btn-default input">Z</button>
        </div>
        <div id="winstate" class="container" style="display: none">
                <h2 id="message"></h2>
                <button id="reset" onclick="resetGame()" class="btn btn-primary input">continue</button>
                <button id="quit" onclick="endGame()" class="btn btn-danger input">quit</button>
        </div>
        </div>
        
        <div class="container"><?php include 'footer.php'; ?></div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>        
        </body>
</html>
<script>
    //Variables
    var score = 0;
    var word = ""; 
    var mult = 1;
    var guessedWord;
    var numWrong = 0;
    var life = 0; // goes up not down (images) 
    var inprogress = "";
    var flag = false;
    var index = [];
    var MAX; // word length
    
    init();
    function init()
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                word = xmlhttp.responseText;
                word = word.slice(0, word.length-2).toLocaleLowerCase(); // 2 extra characters for some reason.
                window.console.log("word = " + word + "\nlength = " + word.length); // for debugging 
                
                MAX = word.length;
                for(var i=0; i<MAX; i++)
                {
                    inprogress += "_";
                    index[i] = -1;
                }
                
                document.getElementById("display").innerHTML = inprogress;
            };
        };
        xmlhttp.open("GET", "words.php", true);
        xmlhttp.send();
    }
    
    function guess(str)
    {
        guessedWord = str.toLocaleLowerCase();
        $("#"+str).prop("disabled", true);
        window.console.log("guessedWord = " + str);// for debugging
        
        for(var i=0;i<MAX;i++) 
	{
            if (word.charAt(i) === guessedWord)
            {
		flag = true;
		index[i] = str;
            }	
	}
        
        if (flag === true)
        {
            var temp = inprogress;
            inprogress = "";
            
            var debug = "";
            
            for(var i=0; i<MAX; i++)
            {
                 debug += "[" + index[i] + "]";
                if(index[i] !== -1)
                {
                    inprogress += index[i];
                }
                else
                {
                    inprogress += temp.charAt(i);
                }
            }
            inprogress = inprogress.toLocaleLowerCase();
            $("#display").text(inprogress);
            score += (20 * (++mult));
            flag = false;
            window.console.log("score = " + score);//debug
            window.console.log(debug);
            
            if(word === inprogress)
            {
                $("#" + life).css("display","none");
                $("#win").css("display","inline");
                winState(word + ": Congratulations you win!");
            }
            else
            {
                window.console.log("done = " + word + " === " + inprogress + " = " + (word === inprogress));//debug
            }
        }
        else
        {
            window.console.log("life = " + life);//debug
            numWrong++;
            mult = 0; // multiplier reset
            $("#" + life).css("display","none");
            $("#" + (++life)).css("display","inline");
            score -= (5*numWrong);
            if(score < 0){score = 0;};
            window.console.log("score = " + score);//debug
            
            if(life === 8)
            {
                $("#" + life).css("display","none");
                $("#dead").css("display","inline");
                winState("Oh, so sorry but you lose! The word was " + word + ".");
            }
            else
            {
                window.console.log("dead = " + (life === 8));
            }
        }
    }
    
    function winState(str)
    {
        $("#message").text(str);
        $("#a-z-buttons").css("display","none");
        $("#winstate").css("display","inline");
    }
    
    function resetGame()
    {
        window.console.log("endGame()");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var response = xmlhttp.responseText;
                window.console.log(response);
                if (response === "true"){
                    location.reload();
                }
            };
        };
        xmlhttp.open("GET", "save_score.php?score=" + score, true);
        xmlhttp.send();
    }
    
    function endGame()
    {
        window.console.log("endGame()");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var response = xmlhttp.responseText;
                window.console.log(response);
                if (response === "true"){
                    location.replace("home.php");
                }
            };
        };
        xmlhttp.open("GET", "save_score.php?score=" + score, true);
        xmlhttp.send();
    }
</script>