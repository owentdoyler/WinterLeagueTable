var images = [
  "ice/ice-1.jpg",
  "ice/ice-2.jpg",
  "ice/ice-3.jpg",
  "ice/ice-4.jpg",
  "ice/ice-5.jpg",
  "ice/ice-6.jpg"
];

var base = "assets/backgrounds/";

images.forEach(function(img) {
  new Image().src = base + img;
  // caches images, avoiding white flash between background replacements
});

window.onload = function() {
  var i = 0;
  var secs = 10;

  $("#bg").attr("src", base + images[i]);
  setInterval(function() {
    if (++i === images.length) {
      i = 0;
    }
    console.log(i);
    $("#bg-next").attr("src", base + images[i]);
    // transition animation: 2s
    $("#bg").fadeOut(3000, function() {
      $("#bg")
        .attr("src", base + images[i])
        .show();
    });
    // slide change: 3s
  }, 10000);
};
