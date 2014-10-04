/* Prettify dates */
jQuery(function($){
    // convert dates from 2009-06-10 to September 04, 2009
    $('.meta time').each(function(){
        var date = this.getAttribute('datetime');
        date = date.split('-');
        if (date.length != 3){
            return true;
        }
        
        var months = 'January, February, March, April, May, June, July, August, September, October, November, December'.split(', ');
        
        $(this).text(months[date[1] - 1] + ' ' + date[2] + ', ' + date[0]);
    });
});

/* Code Highlighting */
if (window.hljs){
    hljs.initHighlightingOnLoad();
}

/* BuySellAds.com ads */
(function(){
    var bsa = document.createElement('script');
    bsa.type = 'text/javascript';
    bsa.async = true;
    bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
    document.getElementsByTagName('head')[0].appendChild(bsa);
})();

/* Disqus comments */
jQuery(function($){
    if (document.body.getAttribute('data-slug') == 'about'){
        return;
    }
    
    var post_date = document.body.getAttribute('data-date');
    if (post_date <= '2010-02-10'){        
        return;    
    }    
    
    if (document.getElementById('disqus_thread')){

        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = 'http://valums.disqus.com/embed.js';
        
        document.getElementsByTagName('head')[0].appendChild(dsq);
    }
});

/* Google Analytics */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-6346996-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
