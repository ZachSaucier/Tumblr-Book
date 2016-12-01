var script = document.createElement('script'),
    offset = 0,
    limit = 10,
    longCharMin = 330,
    vidOrThumb = "thumbnail",
    useBigVideo = false,
    maxNumPhotosPerPost = 999,
//  `siteURL` and `theme` declarations are in tumblr-book.php
    domain = getDomain(siteURL),
    siteLoaded = false;

// Catch failed loads of Tumblr blogs
script.onload = function() {
    siteLoaded = true;
}
setTimeout(function() {
    // Blog failed to load, so send user back to index with error
    if(!siteLoaded) {
        alert("The Tumblr blog " + domain + " failed to load. Please check the name and try again.");
        window.location = "index.php";
    }
}, 1000);
script.src = 'https://api.tumblr.com/v2/blog/' + domain + '/posts?api_key=Srhk9qkcJO69pAoB4ltM5uIqpwUBO7kgDqDEaCD9Jo8EafWyHE&limit=' + limit + '&offset=' + offset + '&callback=filter';
// offset += limit;
// Do it again
indentedAppend(document.getElementsByTagName('head')[0], script);

window.filter = function filter (data) {
    var homeButton = document.createElement('a');
    homeButton.id = "home";
    homeButton.href = "index.php";

    // var logo = document.createElement("img");
    // logo.id = "logo";
    // logo.src = "icon.jpg";

    homeButton.innerText = "Home";
    indentedAppend(document.body, homeButton);

    var printButton = document.createElement('button');
    printButton.id = "printButton";
    printButton.innerText = "Print this Tumblr blog";
    printButton.onclick = function() { 
		printButton.style.display = "none";
		homeButton.style.display = "none";
		window.print();
		printButton.style.display = "block";
		homeButton.style.display = "inline";
	};
    indentedAppend(document.body, printButton);
    
    var posts = data.response.posts;
    var ft = document.createElement('div');
    ft.setAttribute("id", "fromTumblr");
    indentedAppend(document.body, ft);
    addedSection = document.getElementById('fromTumblr');
    
    var avatar = document.createElement('img');
    avatar.id = "avatar";
    avatar.src = "https://api.tumblr.com/v2/blog/" + domain + "/avatar";
    indentedAppend(addedSection, avatar);
    
    var name = document.createElement('h1');
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
            console.log("Unknown post type of: " + posts[i].type);
        }
    });
	
	$.ajax({
		type: 'POST',
		url: 'blog-data.php',
		data: {blogname: blogname, theme: theme, content: ft.innerHTML},
		success: function(resp){
			console.log('blog content sent to the database');
			console.log(resp);
		},
		error: function(){
			console.log('blog content could not be saved to the database');
		}
	});	
}

function stripText(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post text";
    if(post.title != null) { 
        toAdd.innerHTML = post.title + "<br/>" + post.body; 
    } else { 
        toAdd.innerHTML = post.body; 
    }

    var charCount = post.body.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { 
        toAdd.className = "post text big"; 
    }

    indentedAppend(addedSection, toAdd);
}
function stripPhoto(post) {
    var toAdd = document.createElement('div');
    var charCount = post.caption.replace(/[^A-Z]/gi, "").length;
    for(var i = 0; i < post.photos.length; i++) {
        if(i < maxNumPhotosPerPost) {
			var imgURL;
			if(post.photos[i].alt_sizes[3] !== undefined){
				imgURL = post.photos[i].alt_sizes[3].url;
			}else{
				imgURL = post.photos[i].alt_sizes[2].url;
			}
            toAdd.className = "post photo";
            if(charCount >= longCharMin) {
                toAdd.className += " big";
                imgURL = post.photos[i].alt_sizes[1].url;
            }
            if(theme === "Album") {
                imgURL = post.photos[i].alt_sizes[0].url;
            }
            toAdd.innerHTML += '<img src="' + imgURL + '"/><br/>';
        }
    }
    toAdd.innerHTML += "<br/>" + post.caption;
    
    indentedAppend(addedSection, toAdd);
}
function stripAudio(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post audio";
    toAdd.innerHTML = post.player + "<br/>" + post.caption;

    var charCount = post.caption.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { 
        toAdd.className = "post audio big"; 
    }

    indentedAppend(addedSection, toAdd);
}
function stripVideo(post) {
    var toAdd = document.createElement('div'),
        videoPlayer;
    if(!useBigVideo) {
        toAdd.className = "post video";
        videoPlayer = post.player[0].embed_code;
    } else {
        toAdd.className = "post video big";
        videoPlayer = post.player[2].embed_code;
    }

    // For thumbnail image only
    if(vidOrThumb == "thumbnail") { 
        var youTube = /youtube/gi,
            vimeo = /vimeo/gi;
        if(youTube.exec(videoPlayer)) {
            toAdd.innerHTML = getThumbnail(videoPlayer) + "<br/>" + post.caption; 
        } else if(vimeo.exec(videoPlayer)) {
            var idReg = /video\/([^]+)" w/,
                id = idReg.exec(videoPlayer)[1],
                url = "https://vimeo.com/api/v2/video/" + id + ".json?callback=showThumb";
                scripter = document.createElement('script');
            scripter.src = url;
            indentedAppend(document.body, scripter);
            setTimeout(function() {
                toAdd.innerHTML = "<img src='" + document.querySelector("#vimeo" + id).innerHTML + "' /> <br/>" + post.caption;
            }, 500);
        }
    } else { // For whole video
        toAdd.innerHTML = videoPlayer + "<br/>" + post.caption; 
    }

    var charCount = post.caption.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { 
        toAdd.className = "post video big"; 
    }
    indentedAppend(addedSection, toAdd);
}

function stripQuote(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post quote";

    if(post.source != null) { 
        toAdd.innerHTML = post.text + "<br/><span class='quoteAuthor'>" + post.source + "</span>"; 
    } else { 
        toAdd.innerHTML = post.text; 
    }

    var charCount = post.text.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { 
        toAdd.className = "post quote big"; 
    }
    indentedAppend(addedSection, toAdd);
}

function stripLink(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post link";

    if(post.title != null && post.description != null) { 
        toAdd.innerHTML = post.title + "<br/>" + post.url + "<br/>" + post.description; 
    } else if(post.title != null) { 
        toAdd.innerHTML = post.title + "<br/>" + post.url; 
    } else if(post.description != null) { 
        toAdd.innerHTML = post.url + "<br/>" + post.description; 
    } else { 
        toAdd.innerHTML = post.url; 
    }

    var charCount = post.description.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { 
        toAdd.className = "post link big"; 
    }
    indentedAppend(addedSection, toAdd);
}

function stripChat(post) {
    var toAdd = document.createElement('div');
    toAdd.className = "post chat";
    toAdd.innerHTML = "<span class='chatTitle'>" + post.title + "</span><br/>";
    for(var i = 0, j = post.dialogue.length; i < j; i++) {
        toAdd.innerHTML += "<span class='chatName'>" + post.dialogue[i].label + "</span> " + post.dialogue[i].phrase + "<br/>";
    }
    var charCount = post.body.replace(/[^A-Z]/gi, "").length;
    if(charCount >= longCharMin) { 
        toAdd.className = "post chat big"; 
    }
    indentedAppend(addedSection, toAdd);
}

// Append (prepend) the given child to the parent with white spacing (so when saved it's pretty)
function indentedAppend(parent, child) {
    var indent = "",
        elem = parent;
      
    while(elem && elem !== document.body) {
        indent += "  ";
        elem = elem.parentNode;
    }
  
    // Prepend the element (so the oldest posts are at the top, like a book would read)
    if(parent.hasChildNodes() && parent.lastChild.nodeType === 3 && /^\s*[\r\n]\s*$/.test(parent.lastChild.textContent)) {
        parent.insertBefore(document.createTextNode("\n" + indent), parent.childNodes[1].nextSibling);
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

function showThumb(data) {
    var image = document.createElement('div');
    image.innerHTML = data[0].thumbnail_medium;
    image.id = "vimeo" + data[0].id;
    console.log("vimeo" + data[0].id)
    image.className = "hidden";
    indentedAppend(document.body, image);
}



function showThumb(data) {
    document.querySelector("#vimeo" + data[0].id).src = data[0].thumbnail_medium;
}