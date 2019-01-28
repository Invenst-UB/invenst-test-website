
// when the page is scrolled, check whether to display the top nav or not.
function scrollPage(){
  var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
  if (scrollTop > 500){
     document.getElementById('navbar').style.visibility = 'visible';
  }else{
     document.getElementById('navbar').style.visibility = 'hidden';
  }
}


// scroll to the top of the page
function topFunction(){
      scrollTo(document.body,  0, 1250); // for Safari
      scrollTo(document.documentElement, 0, 1250);  // For Chrome, Firefox, IE and Opera
}

// scroll to the top of an element
function scrollToElement(element){
      scrollTo(document.body,  getDistanceFromTop(element), 1250);
      scrollTo(document.documentElement, getDistanceFromTop(element), 1250);
}

//Loops through all parent nodes of an element to get it's distance from the top of the document
function getDistanceFromTop(element) {
    var yPos = 0;
    while(element) {
        yPos += (element.offsetTop);
        element = element.offsetParent;
    }
    return yPos;
}

// scroll to a specified position over a specified duration.  Thanks, Stack Overflow
function scrollTo(element, to, duration) {

    var start = element.scrollTop,
        change = to - start,
        currentTime = 0,
        increment = 20;

    var animateScroll = function(){
        currentTime += increment;
        var val = Math.easeInOutQuad(currentTime, start, change, duration);
        element.scrollTop = val;
        if(currentTime < duration) {
            setTimeout(animateScroll, increment);
        }
    };
    animateScroll();
}

//t = current time
//b = start value
//c = change in value
//d = duration
Math.easeInOutQuad = function (t, b, c, d) {
  t /= d/2;
	if (t < 1) return c/2*t*t + b;
	t--;
	return -c/2 * (t*(t-2) - 1) + b;
};

function setyear(year){
   if (year == 'S2018'){
     document.getElementById('spring2018').style.display = 'block';
     document.getElementById('fall2018').style.display = 'none';
    document.getElementById('s2019').style.display = 'none';
     document.getElementById('s2018tab').classList.add("selected");
     document.getElementById('f2018tab').classList.remove("selected");
     document.getElementById('s2019tab').classList.remove("selected");
   }else if (year == 'F2018'){
     document.getElementById('spring2018').style.display = 'none';
     document.getElementById('s2019').style.display = 'none';
     document.getElementById('fall2018').style.display = 'block';
     document.getElementById('f2018tab').classList.add("selected");
     document.getElementById('s2019tab').classList.remove("selected");
     document.getElementById('s2018tab').classList.remove("selected");
   }else{
     document.getElementById('spring2018').style.display = 'none';
     document.getElementById('fall2018').style.display = 'none';
     document.getElementById('s2019').style.display = 'block';
     document.getElementById('f2018tab').classList.remove("selected");
     document.getElementById('s2018tab').classList.remove("selected");
     document.getElementById('s2019tab').classList.add("selected");
   }
}
