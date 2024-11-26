<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="homepage.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <script src="homepage.js"></script>
<style>
-* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/4 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
</head>
<body>

 </head>
 <body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                <a href="Homepage.php"><img src="DogDash.png" alt="logo" width="75" height="75"/></a>
                </div>
                <div class="links">
                    <a  id="Home" href="homepage.php">Home</a>
                    <a href="About-us.php">About-Us</a>
                    <a href="Animals.php">Animals</a>
                    <a href="Contact.php">Contact</a>
                    <a href="Donate.php">Donate</a>
                    <a href="Admin_login.php">Admin</a>
                    <a href="register.php">Register</a>
                </div>
            </div>
            
        </div>
    </div>
    
     <div class="main-page">
       
    
</div>
   <div class="section-one">
        <h1>MEET OUR ADOPTABLE PETS</h1>
        <div class="description">
           <p>If you are looking for a new family member—dog, or puppy—you’ve come to the right place. We have a 
            good<br> selection of sizes, breed mixes, and ages among our homeless pets who are waiting patiently for you to adopt 
            and bring<br> them home.</p>
        </div>

<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="idog1.jpg" style="width:100%">
  <div class="text">Hyy</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="dog2.jpg" style="width:100%">
  <div class="text">Hii</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="dog3.jpg" style="width:100%">
  <div class="text">Hello</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="dog4.jpg" style="width:100%">
  <div class="text">bye</div>
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>
Dog Adoption System focuses on<br> saving at-risk dogs in pound<br> facilities. We save homeless dogss, <br>give them medical care and a <br>safe temporary home, 
            and<br> provide responsible adoption<br> services to those seeking dogs.
    <p>&copy; 2024 Dog Adoption System. All Rights Reserved.</p>
    <h2>Contact</h2>
        <div class="contact-info">
        <p>Dog Adoption System<br>Kuleshwor,ktm</p>
        <p>Monady-Friday:12:00 pm to 6:00 pm<br>Sunday:11:00 am to 4:00 pm<br>Saturday:Closed</p>
        <p>269-492-1010<br>info@Dogadoptionsystem.com</p>
        <ul type="none">
            <a href="https://www.facebook.com/"><li><i class="fa-brands fa-facebook"></i></li></a>
           <a href="https://www.instagram.com/"> <li><i class="fa-brands fa-instagram"></i></li></a>
           <a href="https://twitter.com/"><li><i class="fa-brands fa-twitter"></i></li></a> 
           <a href="https://www.youtube.com/"> <li><i class="fa-brands fa-youtube"></i></li></a>
        </ul>
    </div>
    </div>
    </div><div class="right" >
    <p text-align="centre">&copy; 2024 Dog Adoption System. All Rights Reserved.</p></div>

<script>
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html> 
