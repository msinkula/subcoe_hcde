
var curImage=numImages;
var how="f";

function swapSlide()
{
  if (document.images)
  {
	switch(how)
	{
	case "f":
		var nextImage=0;
		break;
	case "p":
		var nextImage=curImage-1;
		if (nextImage==0)
		  nextImage=numImages-1;
		break;
	case "n":
		var nextImage=curImage+1;
		if (nextImage>=numImages)
		  nextImage=0;
		break;
	case "l":
		var nextImage=numImages-1;
		break;
	default:
		var nextImage=0;
	}

	if (slideImgs[nextImage][0] && slideImgs[nextImage][0].complete)
	{
	  var target=0;
	  if (document.images.mySlide)
		target=document.images.mySlide;
	  if (document.all && document.getElementById("mySlide"))
		target=document.getElementById("mySlide");
  
	  // make sure target is valid.  It might not be valid
	  // if the page has not finished loading
	  if (target)
	  {
		target.src=slideImgs[nextImage][0].src;
		document.getElementById("counter").innerHTML=(nextImage+1) + " of " + numImages;
		document.getElementById("caption").innerHTML=slideImgs[nextImage][1];        
		curImage=nextImage;
	  }
    }
  }
}