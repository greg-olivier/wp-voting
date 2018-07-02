// Defer loading Youtube API script
if (window.addEventListener)  // W3C DOM
  window.addEventListener('load', wpVotingYoutubeInit, false);
else if (window.attachEvent) { // IE DOM
  window.attachEvent('onload', wpVotingYoutubeInit);
}else{ //NO SUPPORT, lauching right now
  wpVotingYoutubeInit();
}

// Get data
try {
  var playerInfos = eval('wp_voting_item_yt');;
} catch (e) {
}


// Check if script tag already exits and create it if not
function wpVotingYoutubeInit(){
  var idScript = "youtube_api";

  if (document.getElementById(idScript) == null){
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    tag.id = idScript;
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }
}

//This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
function onYouTubeIframeAPIReady() {
  if(typeof playerInfos === 'undefined')
    return; 

  for(var i = 0; i < playerInfos.length;i++) {

    if(document.getElementById(playerInfos[i].id)){
      var curplayer = [];
      curplayer[i] = createPlayer(playerInfos[i]);
    };
  }   
}

// Create Player
function createPlayer(playerInfos) {
  if (isMobile() == true){
   return new YT.Player(playerInfos.id, {
    height: playerInfos.height_mobile,
    width: playerInfos.width_mobile,
    videoId: playerInfos.videoId,
    playerVars: {
     autoplay: 0,
     rel: 0,
     showinfo: 0
   },
   events: {
    'onReady': stopWhenClosePopIn,
    'onStateChange': onPlayerStateChange
  }
});
 } else {
   return new YT.Player(playerInfos.id, {
    height: playerInfos.height,
    width: playerInfos.width,
    videoId: playerInfos.videoId,
    playerVars: {
     autoplay: 0,
     rel: 0,
     showinfo: 0
   },
   events: {
    'onReady': stopWhenClosePopIn,
    'onStateChange': onPlayerStateChange
  }
});
 }
}

// Check Screen Width 
function isMobile(){
  var w = window,
  d = document,
  e = d.documentElement,
  g = d.getElementsByTagName("body")[0],
  x = w.innerWidth || e.clientWidth || g.clientWidth;

  if (x < 900)
    return true;
  else
    return false;
};

// If video ends, stop it
function onPlayerStateChange(event) {
  if (event.data == YT.PlayerState.ENDED ) {
   event.target.stopVideo();
 }
};

// Stop video when close pop-in
function stopWhenClosePopIn(event){
  var elements = document.getElementsByClassName('wp_voting_modal-close-button');
  Array.prototype.forEach.call(elements, function(element) {
   element.addEventListener("click", function(){

     var eventId = event.target.a.id;
     var evIdLocation = eventId.indexOf('-');
     eventId = eventId.substr(evIdLocation+1);

     var elementId = element.parentNode.attributes.id.nodeValue;
     var elIdLocation = elementId.indexOf('-');
     elementId = elementId.substr(elIdLocation+1);

     if(elementId == eventId) 
      event.target.stopVideo(); 

  });
 });
}
