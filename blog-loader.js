var blogs = [
	'solacingsavant',
	'gocookyourself',
	'moringmark',
	'rappersdoingnormalshit',
	'thisisnthappiness',
	'imremembering',
	'catsthatlooklikeronswanson',
	'hungoverowls',
	'fallontonight',
	'zooeydeschanel',
	'stussy',
	'idrawnintendo',
	'brotherbrain',
	'halloweenorwilliamsburg',
	'nbahipsters',
	'regularolty',
	'hitrecord',
	'azealiabanks',
	'radstronomical',
	'dumbrunningsonic',
	'art',
	'kicksoncards',
	'scottlava',
	'queenofantisocial',
	'networkawesome',
	'sportspage',
	'dailydot',
	'siphotos',
	'nestitlescreens',
	'microwhat',
	'wearethe99percent',
	'mrhipp',
	'funnyordie',
	'classickicksnyc',
	'dadsaretheoriginalhipster',
	'teenagemutantninjanoses',
	'dieworkwear',
	'awesomepeoplehangingouttogether',
	'gaws',
	'tumblrbot',
	'cookingwithskrillex',
	'kimjongillookingatthings',
	'terrysdiary',
	'everyhalloffamer',
	'thehundreds',
	'theimpossiblecool',
	'eyeonspringfield',
	'life',
	'supremeny',
	'cudlife',
	'thedailypothole',
	'radiomaru',
	'defjamblr',
	'azizisbored',
	'disconaivete',
	'pbstv',
	'garfieldminusgarfield',
	'dailyfrenchie',
	'nbaoffseason',
	'animalstalkinginallcaps',
	'accidentalchinesehipsters',
	'barackobama',
	'thingsorganizedneatly',
	'maddieonthings',
	'golfwang',
	'lunchbagart',
	'coolchicksfromhistory',
	'psarchives',
	'doctorswithoutborders',
	'wired',
	'nationalgeographicmagazine',
	'humansofnewyork',
	'todaysdocument',
	'theworstroom',
	'terminallyapostate-blog'
];
var blogCount = blogs.length;
var i = 0;
document.querySelector('#total').innerHTML = blogCount;
var counter = document.querySelector('#counter');
var iframe = document.querySelector('iframe');
var interval = setInterval(getNextBlog, 1500);
function getNextBlog(){
	iframe.src = 'tumblr-book.php?blog='+blogs[i];
	counter.innerHTML = i+1;
	i++;
	if(i >= blogCount){
		clearInterval(interval);
		document.querySelector('h1').innerHTML = 'Done';
	}
}