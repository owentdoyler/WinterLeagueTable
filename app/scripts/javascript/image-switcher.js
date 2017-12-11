// var bgImageArray = [
//     "1.jpg",
//     "2.jpg",
//     "3.jpg",
//     "4.jpg",
//     "5.jpg",
//     "6.jpg"
// ],

// base = "assets/backgrounds/",
// secs = 10;
// bgImageArray.forEach(function(img){
//     new Image().src = base + img; 
//     // caches images, avoiding white flash between background replacements
// });

// function backgroundSequence() {
// 	window.clearTimeout();
// 	var k = 0;
// 	for (i = 0; i < bgImageArray.length; i++) {
// 		setTimeout(function(){ 
// 			document.documentElement.style.background = "url(" + base + bgImageArray[k] + ") no-repeat center center fixed";
// 			document.documentElement.style.backgroundSize ="cover";
// 		if ((k + 1) === bgImageArray.length) { setTimeout(function() { backgroundSequence() }, (secs * 1000))} else { k++; }			
// 		}, (secs * 1000) * i)	
// 	}
// }
// backgroundSequence();

    var images = [
    "1.jpg",
    "2.jpg",
    "3.jpg",
    "4.jpg",
    "5.jpg",
	"6.jpg"];

	var base = "assets/backgrounds/";

	images.forEach(function(img){
    	new Image().src = base + img; 
    	// caches images, avoiding white flash between background replacements
	});


window.onload = function () {
    var i = 0;
	var secs = 10;	

    $('#bg').attr("src", base + images[i]);
    setInterval(function () {
        if (++i === images.length) {
            i = 0;
        }
        console.log(i);
        $('#bg-next').attr("src", base + images[i]);
        // transition animation: 2s
        $('#bg').fadeOut(3000, function () {
            $('#bg').attr("src", base + images[i]).show();
        });
        // slide change: 3s
    }, 10000);
};