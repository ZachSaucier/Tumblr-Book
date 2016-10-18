var script = document.createElement('script'),
    offset = 0,
    limit = 10,
    longCharMin = 330,
    vidOrThumb = "thumbnail",
    videoSize = 1,
    photoSize = 1,
    siteURL = "https://solacingsavant.tumblr.com/",
    domain = getDomain(siteURL);

script.src = 'https://api.tumblr.com/v2/blog/' + domain + '/posts?api_key=Srhk9qkcJO69pAoB4ltM5uIqpwUBO7kgDqDEaCD9Jo8EafWyHE&limit=' + limit + '&offset=' + offset + '&callback=filter';
// offset += limit;
// Do it again
indentedAppend(document.getElementsByTagName('head')[0], script);

window.filter = function filter (data) {
    var downloader = document.createElement('button');
    downloader.id = "downloader";
    downloader.innerText = "Download the HTML";
    downloader.style.cursor = "pointer";
    downloader.onclick = function() { download('tester.html') };
    indentedAppend(document.body, downloader);
    
    var posts = data.response.posts;
    var ft = document.createElement('div');
    ft.setAttribute("id", "fromTumblr");
    indentedAppend(document.body, ft);
    addedSection = document.getElementById('fromTumblr');
    
    var avatar = document.createElement('img');
    avatar.id = "avatar";
    avatar.src = "https://api.tumblr.com/v2/blog/" + domain + "/avatar";
    indentedAppend(addedSection, avatar);
    
    var name = document.createElement('div');
    name.id = "blogName";
    name.innerText = data.response.blog.name;
    indentedAppend(addedSection, name);
    
    posts.forEach(function(obj, i) {
        if(posts[i].type == "text") {
            stripText(posts[i]);
        }
        else if(posts[i].type == "photo") {
            stripPhoto(posts[i]);
        }
        else if(posts[i].type == "audio") {
            stripAudio(posts[i]);
        }
        else if(posts[i].type == "video") {
            stripVideo(posts[i]);
        }
        else if(posts[i].type == "link")  {
            stripLink(posts[i]);
        }
        else if(posts[i].type == "chat")  {
            stripChat(posts[i]);
        }
        else if(posts[i].type == "quote") {
            stripQuote(posts[i]);
        }
        else {
            alert("UNKNOWN TYPE OF " + posts[i].type);
        }
    });
}

function stripText(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post text";
    if(post.title != null) { toAdd.innerHTML = post.title + "</br>" + post.body; }
    else { toAdd.innerHTML = post.body; }
    var charCount = post.body.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { toAdd.className = "post text big"; }
    indentedAppend(addedSection, toAdd);
}
function stripPhoto(post) {
    var toAdd = document.createElement('div');
    var charCount = post.caption.replace(/[^A-Z]/gi, "").length;
    if(photoSize == 2 || charCount >= longCharMin) {
        toAdd.className = "post photo big";
        toAdd.innerHTML = '<img src="' + post.photos[0].alt_sizes[1].url + '"/></br>' + post.caption;
    }
    else {
        toAdd.className = "post photo";
        toAdd.innerHTML = '<img src="' + post.photos[0].alt_sizes[3].url + '"/></br>' + post.caption;
    }
    indentedAppend(addedSection, toAdd);
}
function stripAudio(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post audio";
    toAdd.innerHTML = post.player + "</br>" + post.caption;
    var charCount = post.caption.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { toAdd.className = "post audio big"; }
    indentedAppend(addedSection, toAdd);
}
function stripVideo(post) {
    var toAdd = document.createElement('div'),
        videoPlayer;
    if(videoSize == 2) {
        toAdd.className = "post video";
        videoPlayer = post.player[0].embed_code;
    }
    else {
        toAdd.className = "post video big";
        videoPlayer = post.player[1].embed_code;
    }
    // For thumbnail image only
    if(vidOrThumb == "thumbnail") { 
        var youTube = /youtube/gi,
            vimeo = /vimeo/gi;
        if(youTube.exec(videoPlayer)) {
            toAdd.innerHTML = getThumbnail(videoPlayer) + "</br>" + post.caption; 
        }
        else if(vimeo.exec(videoPlayer)) {
            var idReg = /video\/([^]+)" w/,
                id = idReg.exec(videoPlayer)[1],
                url = "https://vimeo.com/api/v2/video/" + id + ".json?callback=showThumb";
                scripter = document.createElement('script');
            scripter.src = url;
            indentedAppend(document.body, scripter);
            setTimeout(function() {
                console.log("#vimeo" + id);
                toAdd.innerHTML = "<img src='" + document.querySelector("#vimeo" + id).innerHTML + "' /> </br>" + post.caption;
            }, 500);
        }
    }

    // For whole video
    else { toAdd.innerHTML = videoPlayer + "</br>" + post.caption; }
    var charCount = post.caption.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { toAdd.className = "post video big"; }
    indentedAppend(addedSection, toAdd);
}

function stripQuote(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post quote";
    if(post.source != null) { toAdd.innerHTML = post.text + "</br><span class='quoteAuthor'>" + post.source + "</span>"; }
    else { toAdd.innerHTML = post.text; }
    var charCount = post.text.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { toAdd.className = "post quote big"; }
    indentedAppend(addedSection, toAdd);
}

function stripLink(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post link";
    if(post.title != null && post.description != null) { toAdd.innerHTML = post.title + "</br>" + post.url + "</br>" + post.description; }
    else if(post.title != null) { toAdd.innerHTML = post.title + "</br>" + post.url; }
    else if(post.description != null) { toAdd.innerHTML = post.url + "</br>" + post.description; }
    else { toAdd.innerHTML = post.url; }
    var charCount = post.description.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { toAdd.className = "post link big"; }
    indentedAppend(addedSection, toAdd);
}

function stripChat(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post chat";
    toAdd.innerHTML = "<span class='chatTitle'>" + post.title + "</span></br>";
    for(var i = 0, j = post.dialogue.length; i < j; i++) {
        toAdd.innerHTML += "<span class='chatName'>" + post.dialogue[i].label + "</span> " + post.dialogue[i].phrase + "</br>";
    }
    var charCount = post.body.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { toAdd.className = "post chat big"; }
    indentedAppend(addedSection, toAdd);
}

function download(filename) {
	document.body.removeChild(document.body.getElementsByTagName("script")[0]);
	console.log(encodeURIComponent(document.documentElement.innerHTML))
    var pom = document.createElement('a');
    pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(document.documentElement.innerHTML));
    pom.setAttribute('download', filename);
    pom.click();
    pom.remove();
}

function indentedAppend(parent,child) {
    var indent = "",
        elem = parent;
      
    while (elem && elem !== document.body) {
        indent += "  ";
        elem = elem.parentNode;
    }
  
    if (parent.hasChildNodes() && parent.lastChild.nodeType === 3 && /^\s*[\r\n]\s*$/.test(parent.lastChild.textContent)) {
        //parent.insertBefore(document.createTextNode("\n" + indent), parent.lastChild);
        parent.insertBefore(document.createTextNode("\n" + indent), parent.childNodes[1].nextSibling);
        //parent.insertBefore(child, parent.lastChild);
        parent.insertBefore(child, parent.childNodes[1].nextSibling);
    } else {
        parent.appendChild(document.createTextNode("\n" + indent));
        parent.appendChild(child);
        parent.appendChild(document.createTextNode("\n" + indent.slice(0,-2)));
    }  
}

function getThumbnail(embedCode) {
    var expr = /embed\/([^*]+)?\?feature/;
    var alphanum = expr.exec(embedCode);
    return "<img src='https://i1.ytimg.com/vi/" + alphanum[1] + "/0.jpg' />";
}

function getDomain(src) {
    var expr = /https:\/\/([^]+)\//;
    var siteDomain = expr.exec(src);
    return siteDomain[1];
}
//setTimeout(function() { window.print() }, 10000);

function showThumb(data){
    var image = document.createElement('div');
    image.innerHTML = data[0].thumbnail_medium;
    image.id = "vimeo" + data[0].id;
    console.log("vimeo" + data[0].id)
    image.className = "hidden";
    indentedAppend(document.body, image);
}



function showThumb(data){
    document.querySelector("#vimeo" + data[0].id).src = data[0].thumbnail_medium;
}