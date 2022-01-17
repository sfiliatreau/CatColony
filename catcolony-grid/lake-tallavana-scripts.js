/*
Sarah Howard
CSC 135
Assignment 5 - Grid
lake-tallavana-scripts.js
2020-04-18
*/

// I wrote this with the idea that it would find which dimenstion was smaller
// and set that to 100% so that no images in my gallery would have letterboxes.
// I'm 70% sure that it works...

let images = document.getElementsByTagName("img");
console.log( images );

for ( var i = 0; i < images.length; i++ ) {
  if ( images[i].width > images[i].height ) {
    images[i].style.maxHeight = "100%";
    console.log( "img" + i + " is landscape" );
  }
  else {
    images[i].style.maxWidth = "100%";
    console.log( "img" + i + " is portrait" );
  }
}