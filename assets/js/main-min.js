!function(e,t,a){e(t).ready(function(){!function(e){e(t).ready(function(){e(".comment-reply-link").click(function(){e('input[name="comment_parent"]').val(e(this).data("commentid")),e("#reply-title").text(e(this).attr("aria-label"))})})}(jQuery),jQuery(".form-item--filter label").click(function(){var e=jQuery(this).parent();e.find("input:checked").length?e.removeClass("is-active"):e.addClass("is-active")}),jQuery(t).ready(function(){var t,a,i;t=e(".section .grid .tipkaart"),a=e("#buttons"),i={},t.each(function(){var t=this,a=e(this).data("tags");a&&a.split(",").forEach(function(e){null==i[e]&&(i[e]=[]),i[e].push(t)})}),e("<button/>",{text:"Alle tipkaarten",class:"active form-item--filter",click:function(){e(this).addClass("active").siblings().removeClass("active"),t.show()}}).appendTo(a),e.each(i,function(n){e("<button/>",{text:n+" ("+i[n].length+")",class:"form-item--filter cat--"+n,click:function(){e(this).addClass("active").siblings().removeClass("active"),t.hide().filter(i[n]).show()}}).appendTo(a)})});const i=1e3,n=t.getElementById("menu-primary"),r=t.querySelectorAll("li.main-menu__item--with-sub"),s=t.querySelectorAll(".btn--toggle-menu"),o=(t.querySelectorAll(".l-header-nav"),t.getElementById("mainnav"),t.getElementsByTagName("body"));function l(e,t){e.classList.contains("open")?(e.classList.remove("open"),e.querySelector("a").setAttribute("aria-expanded","false"),void 0!==e.querySelector("button")&&e.querySelector("button").setAttribute("aria-expanded","false"),e.querySelector("ul.main-menu__sublist").classList.add("visuallyhidden"),e.querySelector("ul.main-menu__sublist").setAttribute("aria-expanded","false")):(e.classList.add("open"),e.querySelector("a").setAttribute("aria-expanded","true"),void 0!==e.querySelector("button")&&e.querySelector("button").setAttribute("aria-expanded","true"),e.querySelector("ul.main-menu__sublist").classList.remove("visuallyhidden"),e.querySelector("ul.main-menu__sublist").setAttribute("aria-expanded","true"))}function u(){var e=a.innerWidth;t.querySelectorAll(".menu-item-has-children");Array.prototype.forEach.call(r,function(t,a){if(t.classList.remove("open"),t.querySelector("a").setAttribute("aria-expanded","false"),e>i){var n=t.querySelector("button");n&&void 0!==n&&(n.setAttribute("aria-expanded","false"),n.classList.remove("open-list")),t.querySelector("ul.main-menu__sublist").classList.add("visuallyhidden")}})}function c(e){t.querySelectorAll("button.main-menu__open-sub").forEach(function(e){e.remove()}),e<i?(Array.prototype.forEach.call(r,function(e,t){e.classList.add("open");var a=e.querySelector("ul.main-menu__sublist");a&&(a.classList.remove("visuallyhidden"),a.setAttribute("aria-expanded","true")),e.removeEventListener("pointerenter",function(e){l(this)}),e.removeEventListener("pointerleave",function(e){l(this)})}),s[0].addEventListener("click",function(e){this.classList.contains("active")?(this.classList.remove("active"),o[0].classList.remove("show-menu")):(this.classList.add("active"),o[0].classList.add("show-menu"))})):Array.prototype.forEach.call(r,function(e,t){var a=e,i=a.querySelector(".main-menu__sublist"),n=e.querySelector("a"),r='<button class="main-menu__open-sub"><span><span class="visuallyhidden">Submenu voor “'+n.text+"”</span></span></button>";n.insertAdjacentHTML("afterend",r),i.classList.add("visuallyhidden"),a.addEventListener("pointerenter",function(e){l(this)}),a.addEventListener("pointerleave",function(e){l(this)}),e.querySelector("button").addEventListener("click",function(e){this.parentNode.classList.contains("open")?(this.parentNode.classList.remove("open"),this.parentNode.querySelector("a").setAttribute("aria-expanded","false"),this.parentNode.querySelector("button").setAttribute("aria-expanded","false"),this.parentNode.querySelector("button").classList.remove("open-list"),this.parentNode.querySelector("ul.main-menu__sublist").classList.add("visuallyhidden"),this.parentNode.querySelector("ul.main-menu__sublist").setAttribute("aria-expanded","false")):(this.parentNode.classList.add("open"),this.parentNode.querySelector("a").setAttribute("aria-expanded","true"),this.parentNode.querySelector("button").setAttribute("aria-expanded","true"),this.parentNode.querySelector("button").classList.add("open-list"),this.parentNode.querySelector("ul.main-menu__sublist").classList.remove("visuallyhidden"),this.parentNode.querySelector("ul.main-menu__sublist").setAttribute("aria-expanded","true")),e.preventDefault()})})}t.onkeydown=function(e){27==(e=e||a.event).keyCode&&u()},t.addEventListener("click",function(e){n===e.target||n.contains(e.target)||u()}),!!a.MSInputMethodContext&&!!t.documentMode||(a.addEventListener("load",function(){c(a.innerWidth)}),a.addEventListener("resize",function(){c(a.innerWidth)})),function(e){"use strict";e.fn.multipleFilterMasonry=function(t){var i=[],n=[];"list"===t.selectorType&&e(t.filtersGroupSelector).children().each(function(){n.push(e(this).data("filter"))});var r=function(t){var a=[];return e(i).each(function(n){e(t).each(function(t,r){i[n].is(r)&&-1===e.inArray(i[n],a)&&a.push(i[n])})}),a},s=function(t,a){t.empty(),e(a).each(function(){e(t).append(e(this))}),t.masonry("reloadItems"),t.masonry()},o=function(o){var l=e(t.filtersGroupSelector).children();l.each(function(){e(this).click(function(){l.removeClass("selected"),a.location.hash=e(this).data("filter");var t=[];t.push("."+e(this).data("filter")),e(this).addClass("selected");var n=i;t.length>0&&(n=r(t)),s(o,n)})}),function(t){var i=a.location.hash.replace("#","");-1!==e.inArray(i,n)&&s(t,e("."+i))}(o),l.removeClass("selected"),e('.filters li[data-filter="'+a.location.hash.replace("#","")+'"]').addClass("selected")};return this.each(function(){var a,n=e(this);(a=n).find(t.itemSelector).each(function(){i.push(e(this))}),a.masonry(t),"list"===t.selectorType?o(n):function(a){var n=e(t.filtersGroupSelector).find('input[type="checkbox"]');n.each(function(){e(this).change(function(){var t=[];n.removeClass("selected"),n.each(function(){e(this).is(":checked")&&(e(this).addClass("selected"),t.push("."+e(this).val()))});var o=i;t.length>0&&(o=r(t)),s(a,o)})})}(n)})}}(a.jQuery);var d=!1,h=e(".btn--close");e(".stepchart__button").on("focus",function(t){d=!0;var a=e(this).parent().find(".stepchart__description");p(a)}).on("click",function(t){if(!1===d){var a=e(this).parent().find(".stepchart__description");p(a)}d=!1});var p=function(t){var i=e(a).width();"true"===t.attr("aria-hidden")?(i>=560&&(e(".stepchart__description[aria-hidden=false]").attr("aria-hidden","true"),e(".show-popover").removeClass("show-popover")),t.attr("aria-hidden","false"),t.parent().addClass("show-popover")):(t.attr("aria-hidden","true"),t.parent().removeClass("show-popover"))};h.on("click",function(){console.log("clickc"),e(this).parent().attr("aria-hidden","true")}),e(a).resize(function(){e(a).width()>=560&&(e(".stepchart__description[aria-hidden=false]").attr("aria-hidden","true"),e(".show-popover").removeClass("show-popover"))}),e(t).on("mouseup",function(t){var a=e(".stepchart__item.show-popover");a.is(t.target)||0!==a.has(t.target).length||(a.removeClass("show-popover"),a.find(".stepchart__description").attr("aria-hidden","true"))});const v=jQuery(".collapsetoggle button"),f=jQuery(".section--video");v.on("click",function(){const e=jQuery(this).parent().next();if("true"===jQuery(this).attr("aria-expanded")){console.log("ding is uitgeklapt");const t=jQuery('.collapsetoggle button[aria-expanded="true"]'),a=jQuery(".collapsible");t&&(t.attr("aria-expanded","false"),a.attr("hidden","hidden")),jQuery(this).attr("aria-expanded","true"),e.removeAttr("hidden"),f.hasClass("show-overlay")||f.addClass("show-overlay")}else console.log("ding NIET uitgeklapt"),jQuery(this).attr("aria-expanded","false"),e.attr("hidden","hidden"),f.removeClass("show-overlay")}),jQuery(t).on("mouseup",function(e){if(f.hasClass("show-overlay")){const t=jQuery(".video__video"),a=jQuery('.collapsetoggle button[aria-expanded="true"]'),i=jQuery(".collapsible");t.is(e.target)||0!==t.has(e.target).length||(f.removeClass("show-overlay"),a.attr("aria-expanded","false"),i.attr("hidden","hidden"))}})})}(jQuery,document,window);