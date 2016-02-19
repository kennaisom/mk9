/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";a(document).on("cycle-bootstrap",function(a,b,c){"carousel"===b.fx&&(c.getSlideIndex=function(a){var b=this.opts()._carouselWrap.children(),c=b.index(a);return c%b.length},c.next=function(){var a=b.reverse?-1:1;b.allowWrap===!1&&b.currSlide+a>b.slideCount-b.carouselVisible||(b.API.advanceSlide(a),b.API.trigger("cycle-next",[b]).log("cycle-next"))})}),a.fn.cycle.transitions.carousel={preInit:function(b){b.hideNonActive=!1,b.container.on("cycle-destroyed",a.proxy(this.onDestroy,b.API)),b.API.stopTransition=this.stopTransition;for(var c=0;c<b.startingSlide;c++)b.container.append(b.slides[0])},postInit:function(b){var c,d,e,f,g=b.carouselVertical;b.carouselVisible&&b.carouselVisible>b.slideCount&&(b.carouselVisible=b.slideCount-1);var h=b.carouselVisible||b.slides.length,i={display:g?"block":"inline-block",position:"static"};if(b.container.css({position:"relative",overflow:"hidden"}),b.slides.css(i),b._currSlide=b.currSlide,f=a('<div class="cycle-carousel-wrap"></div>').prependTo(b.container).css({margin:0,padding:0,top:0,left:0,position:"absolute"}).append(b.slides),b._carouselWrap=f,g||f.css("white-space","nowrap"),b.allowWrap!==!1){for(d=0;d<(void 0===b.carouselVisible?2:1);d++){for(c=0;c<b.slideCount;c++)f.append(b.slides[c].cloneNode(!0));for(c=b.slideCount;c--;)f.prepend(b.slides[c].cloneNode(!0))}f.find(".cycle-slide-active").removeClass("cycle-slide-active"),b.slides.eq(b.startingSlide).addClass("cycle-slide-active")}b.pager&&b.allowWrap===!1&&(e=b.slideCount-h,a(b.pager).children().filter(":gt("+e+")").hide()),b._nextBoundry=b.slideCount-b.carouselVisible,this.prepareDimensions(b)},prepareDimensions:function(b){var c,d,e,f,g=b.carouselVertical,h=b.carouselVisible||b.slides.length;if(b.carouselFluid&&b.carouselVisible?b._carouselResizeThrottle||this.fluidSlides(b):b.carouselVisible&&b.carouselSlideDimension?(c=h*b.carouselSlideDimension,b.container[g?"height":"width"](c)):b.carouselVisible&&(c=h*a(b.slides[0])[g?"outerHeight":"outerWidth"](!0),b.container[g?"height":"width"](c)),d=b.carouselOffset||0,b.allowWrap!==!1)if(b.carouselSlideDimension)d-=(b.slideCount+b.currSlide)*b.carouselSlideDimension;else for(e=b._carouselWrap.children(),f=0;f<b.slideCount+b.currSlide;f++)d-=a(e[f])[g?"outerHeight":"outerWidth"](!0);b._carouselWrap.css(g?"top":"left",d)},fluidSlides:function(b){function c(){clearTimeout(e),e=setTimeout(d,20)}function d(){b._carouselWrap.stop(!1,!0);var a=b.container.width()/b.carouselVisible;a=Math.ceil(a-g),b._carouselWrap.children().width(a),b._sentinel&&b._sentinel.width(a),h(b)}var e,f=b.slides.eq(0),g=f.outerWidth()-f.width(),h=this.prepareDimensions;a(window).on("resize",c),b._carouselResizeThrottle=c,d()},transition:function(b,c,d,e,f){var g,h={},i=b.nextSlide-b.currSlide,j=b.carouselVertical,k=b.speed;if(b.allowWrap===!1){e=i>0;var l=b._currSlide,m=b.slideCount-b.carouselVisible;i>0&&b.nextSlide>m&&l==m?i=0:i>0&&b.nextSlide>m?i=b.nextSlide-l-(b.nextSlide-m):0>i&&b.currSlide>m&&b.nextSlide>m?i=0:0>i&&b.currSlide>m?i+=b.currSlide-m:l=b.currSlide,g=this.getScroll(b,j,l,i),b.API.opts()._currSlide=b.nextSlide>m?m:b.nextSlide}else e&&0===b.nextSlide?(g=this.getDim(b,b.currSlide,j),f=this.genCallback(b,e,j,f)):e||b.nextSlide!=b.slideCount-1?g=this.getScroll(b,j,b.currSlide,i):(g=this.getDim(b,b.currSlide,j),f=this.genCallback(b,e,j,f));h[j?"top":"left"]=e?"-="+g:"+="+g,b.throttleSpeed&&(k=g/a(b.slides[0])[j?"height":"width"]()*b.speed),b._carouselWrap.animate(h,k,b.easing,f)},getDim:function(b,c,d){var e=a(b.slides[c]);return e[d?"outerHeight":"outerWidth"](!0)},getScroll:function(a,b,c,d){var e,f=0;if(d>0)for(e=c;c+d>e;e++)f+=this.getDim(a,e,b);else for(e=c;e>c+d;e--)f+=this.getDim(a,e,b);return f},genCallback:function(b,c,d,e){return function(){var c=a(b.slides[b.nextSlide]).position(),f=0-c[d?"top":"left"]+(b.carouselOffset||0);b._carouselWrap.css(b.carouselVertical?"top":"left",f),e()}},stopTransition:function(){var a=this.opts();a.slides.stop(!1,!0),a._carouselWrap.stop(!1,!0)},onDestroy:function(){var b=this.opts();b._carouselResizeThrottle&&a(window).off("resize",b._carouselResizeThrottle),b.slides.prependTo(b.container),b._carouselWrap.remove()}}}(jQuery);

/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";function b(b){return{preInit:function(a){a.slides.css(d)},transition:function(c,d,e,f,g){var h=c,i=a(d),j=a(e),k=h.speed/2;b.call(j,-90),j.css({display:"block",visibility:"visible","background-position":"-90px",opacity:1}),i.css("background-position","0px"),i.animate({backgroundPosition:90},{step:b,duration:k,easing:h.easeOut||h.easing,complete:function(){c.API.updateView(!1,!0),j.animate({backgroundPosition:0},{step:b,duration:k,easing:h.easeIn||h.easing,complete:g})}})}}}function c(b){return function(c){var d=a(this);d.css({"-webkit-transform":"rotate"+b+"("+c+"deg)","-moz-transform":"rotate"+b+"("+c+"deg)","-ms-transform":"rotate"+b+"("+c+"deg)","-o-transform":"rotate"+b+"("+c+"deg)",transform:"rotate"+b+"("+c+"deg)"})}}var d,e=document.createElement("div").style,f=a.fn.cycle.transitions,g=void 0!==e.transform||void 0!==e.MozTransform||void 0!==e.webkitTransform||void 0!==e.oTransform||void 0!==e.msTransform;g&&void 0!==e.msTransform&&(e.msTransform="rotateY(0deg)",e.msTransform||(g=!1)),g?(f.flipHorz=b(c("Y")),f.flipVert=b(c("X")),d={"-webkit-backface-visibility":"hidden","-moz-backface-visibility":"hidden","-o-backface-visibility":"hidden","backface-visibility":"hidden"}):(f.flipHorz=f.scrollHorz,f.flipVert=f.scrollVert||f.scrollHorz)}(jQuery);

/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";function b(a,b,c){if(a&&c.style.filter){b._filter=c.style.filter;try{c.style.removeAttribute("filter")}catch(d){}}else!a&&b._filter&&(c.style.filter=b._filter)}a.extend(a.fn.cycle.transitions,{fade:{before:function(c,d,e,f){var g=c.API.getSlideOpts(c.nextSlide).slideCss||{};c.API.stackSlides(d,e,f),c.cssBefore=a.extend(g,{opacity:0,visibility:"visible",display:"block"}),c.animIn={opacity:1},c.animOut={opacity:0},b(!0,c,e)},after:function(a,c,d){b(!1,a,d)}},fadeout:{before:function(c,d,e,f){var g=c.API.getSlideOpts(c.nextSlide).slideCss||{};c.API.stackSlides(d,e,f),c.cssAfter=a.extend(g,{opacity:0,visibility:"hidden"}),c.cssBefore=a.extend(g,{opacity:1,visibility:"visible",display:"block"}),c.animOut={opacity:0},b(!0,c,e)},after:function(a,c,d){b(!1,a,d)}}})}(jQuery);

/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";a.fn.cycle.transitions.scrollVert={before:function(a,b,c,d){a.API.stackSlides(a,b,c,d);var e=a.container.css("overflow","hidden").height();a.cssBefore={top:d?-e:e,left:0,opacity:1,display:"block",visibility:"visible"},a.animIn={top:0},a.animOut={top:d?e:-e}}}}(jQuery);

/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";a.fn.cycle.transitions.shuffle={transition:function(b,c,d,e,f){function g(a){this.stack(b,c,d,e),a()}a(d).css({display:"block",visibility:"visible"});var h=b.container.css("overflow","visible").width(),i=b.speed/2,j=e?c:d;b=b.API.getSlideOpts(e?b.currSlide:b.nextSlide);var k={left:-h,top:15},l=b.slideCss||{left:0,top:0};void 0!==b.shuffleLeft?k.left=k.left+parseInt(b.shuffleLeft,10)||0:void 0!==b.shuffleRight&&(k.left=h+parseInt(b.shuffleRight,10)||0),b.shuffleTop&&(k.top=b.shuffleTop),a(j).animate(k,i,b.easeIn||b.easing).queue("fx",a.proxy(g,this)).animate(l,i,b.easeOut||b.easing,f)},stack:function(b,c,d,e){var f,g;if(e)b.API.stackSlides(d,c,e),a(c).css("zIndex",1);else{for(g=1,f=b.nextSlide-1;f>=0;f--)a(b.slides[f]).css("zIndex",g++);for(f=b.slideCount-1;f>b.nextSlide;f--)a(b.slides[f]).css("zIndex",g++);a(d).css("zIndex",b.maxZ),a(c).css("zIndex",b.maxZ-1)}}}}(jQuery);

/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";a.fn.cycle.transitions.tileSlide=a.fn.cycle.transitions.tileBlind={before:function(b,c,d,e){b.API.stackSlides(c,d,e),a(c).css({display:"block",visibility:"visible"}),b.container.css("overflow","hidden"),b.tileDelay=b.tileDelay||"tileSlide"==b.fx?100:125,b.tileCount=b.tileCount||7,b.tileVertical=b.tileVertical!==!1,b.container.data("cycleTileInitialized")||(b.container.on("cycle-destroyed",a.proxy(this.onDestroy,b.API)),b.container.data("cycleTileInitialized",!0))},transition:function(b,c,d,e,f){function g(a){m.eq(a).animate(t,{duration:b.speed,easing:b.easing,complete:function(){(e?p-1===a:0===a)&&b._tileAniCallback()}}),setTimeout(function(){(e?p-1!==a:0!==a)&&g(e?a+1:a-1)},b.tileDelay)}b.slides.not(c).not(d).css("visibility","hidden");var h,i,j,k,l,m=a(),n=a(c),o=a(d),p=b.tileCount,q=b.tileVertical,r=b.container.height(),s=b.container.width();q?(i=Math.floor(s/p),k=s-i*(p-1),j=l=r):(i=k=s,j=Math.floor(r/p),l=r-j*(p-1)),b.container.find(".cycle-tiles-container").remove();var t,u={left:0,top:0,overflow:"hidden",position:"absolute",margin:0,padding:0};t=q?"tileSlide"==b.fx?{top:r}:{width:0}:"tileSlide"==b.fx?{left:s}:{height:0};var v=a('<div class="cycle-tiles-container"></div>');v.css({zIndex:n.css("z-index"),overflow:"visible",position:"absolute",top:0,left:0,direction:"ltr"}),v.insertBefore(d);for(var w=0;p>w;w++)h=a("<div></div>").css(u).css({width:p-1===w?k:i,height:p-1===w?l:j,marginLeft:q?w*i:0,marginTop:q?0:w*j}).append(n.clone().css({position:"relative",maxWidth:"none",width:n.width(),margin:0,padding:0,marginLeft:q?-(w*i):0,marginTop:q?0:-(w*j)})),m=m.add(h);v.append(m),n.css("visibility","hidden"),o.css({opacity:1,display:"block",visibility:"visible"}),g(e?0:p-1),b._tileAniCallback=function(){o.css({display:"block",visibility:"visible"}),n.css("visibility","hidden"),v.remove(),f()}},stopTransition:function(a){a.container.find("*").stop(!0,!0),a._tileAniCallback&&a._tileAniCallback()},onDestroy:function(){var a=this.opts();a.container.find(".cycle-tiles-container").remove()}}}(jQuery);