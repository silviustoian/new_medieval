!function(){"use strict";function c(){return window.innerWidth<=960}function u(e,n){for(var t=0;t<e.length;t++)n(e[t])}function s(e){return-1<e.indexOf("#")&&(e=e.substr(0,e.lastIndexOf("#"))),"/"===e.substr(-1)&&(e=e.substring(0,e.length-1)),e}function i(e,n,t){if(e instanceof NodeList)for(var o=0;o<e.length;o++)e[o].addEventListener(n,t);else(e instanceof Node||e instanceof Element)&&e.addEventListener(n,t)}function a(e,n){if(e instanceof NodeList)for(var t=0;t<e.length;t++)e[t].classList.toggle(n);else(e instanceof Node||e instanceof Element)&&e.classList.toggle(n)}function e(){var e,n,t,o,i,r;d=window.location.href,y(),function(){var e=document.querySelectorAll(".nv-nav-wrap a");if(0===e.length)return;u(e,function(e){e.addEventListener("click",function(e){var n=e.target.getAttribute("href");if(null===n)return!1;s(n)===s(d)&&window.HFG.toggleMenuSidebar(!1)})})}(),e=document.querySelectorAll(".caret-wrap"),u(e,function(t){t.addEventListener("click",function(e){e.preventDefault();var n=t.parentNode.parentNode.querySelector(".sub-menu");a(t,"dropdown-open"),a(n,"dropdown-open")})}),function(){var e=document.querySelectorAll(".nv-nav-search"),t=document.querySelectorAll(".menu-item-nav-search"),n=document.querySelectorAll(".close-responsive-search");document.querySelector("html");u(t,function(n){n.addEventListener("click",function(e){e.stopPropagation(),a(n,"active"),n.querySelector(".search-field").focus(),c()||function(e,n){var t=document.querySelector(".nav-clickaway-overlay");if(null!==t)return;t=document.createElement("div"),l(t,"nav-clickaway-overlay");var o=document.querySelector("header.header");o.parentNode.insertBefore(t,o),t.addEventListener("click",function(){f(e,n),t.parentNode.removeChild(t)})}(n,"active")})}),u(e,function(e){e.addEventListener("click",function(e){e.stopPropagation()})}),u(n,function(e){e.addEventListener("click",function(e){e.preventDefault(),u(t,function(e){f(e,"active")});var n=document.querySelector(".nav-clickaway-overlay");null!==n&&n.parentNode.removeChild(n)})})}(),!0==(t=window.navigator.userAgent,o=t.indexOf("MSIE "),i=t.indexOf("Edge/"),r=t.indexOf("Trident/"),0<o||0<r||0<i)&&(n=document.querySelectorAll('.header--row[data-show-on="desktop"] .sub-menu'),u(n,function(e){var n=e.parentNode;n.addEventListener("mouseenter",function(){l(e,"dropdown-open")}),n.addEventListener("mouseleave",function(){f(e,"dropdown-open")})}))}var d,l=function(e,n){if(e instanceof NodeList)for(var t=0;t<e.length;t++)e[t].classList.add(n);else(e instanceof Node||e instanceof Element)&&e.classList.add(n)},f=function(e,n){var t=n.split(" ");if(e instanceof NodeList)for(var o=0;o<e.length;o++)for(var i=0;i<t.length;i++)e[o].classList.remove(t[i]);else if(e instanceof Node||e instanceof Element)for(var r=0;r<t.length;r++)e.classList.remove(t[r])},n=null,t=null,v=2,o=function(){if("enabled"!==NeveProperties.masonry||NeveProperties.masonryColumns<2)return!1;t=document.querySelector(".nv-index-posts .posts-wrapper"),imagesLoaded(t,function(){n=new Masonry(t,{itemSelector:"article.layout-grid",columnWidth:"article.layout-grid",percentPosition:!0})})},r=function(){if("enabled"!==NeveProperties.infiniteScroll)return!1;!function(e,n,t){var o=2<arguments.length&&void 0!==t?t:.5;new IntersectionObserver(function(e){e[0].intersectionRatio<=o||n()}).observe(e)}(document.querySelector(".infinite-scroll-trigger"),function(){if(void 0!==parent.wp.customize)return parent.wp.customize.requestChangesetUpdate().then(function(){m()}),!1;m()})},m=function(){var e=document.querySelector(".infinite-scroll-trigger");if(null===e)return!1;if(document.querySelector(".nv-loader").style.display="block",v>NeveProperties.infiniteScrollMaxPages)return e.parentNode.removeChild(e),!(document.querySelector(".nv-loader").style.display="none");var n,t,o,i,r=document.querySelector(".nv-index-posts .posts-wrapper"),c=g(NeveProperties.infiniteScrollEndpoint+v);v++,n=c,t=function(e){r.innerHTML+=JSON.parse(e),p()},o=NeveProperties.infiniteScrollQuery,(i=new XMLHttpRequest).onload=function(){4===i.readyState&&200===i.status&&t(i.response)},i.onerror=function(e){console.error(e)},i.open("POST",n,!0),i.setRequestHeader("Content-Type","application/json; charset=UTF-8"),i.send(o)},p=function(){null!==n&&imagesLoaded(t).on("progress",function(e){n.layout(),n.reloadItems()})},g=function(e){return void 0===wp.customize?e:(e+="?customize_changeset_uuid="+wp.customize.settings.changeset.uuid+"&customize_autosaved=on","undefined"==typeof _wpCustomizeSettings?e:e+="&customize_preview_nonce="+_wpCustomizeSettings.nonce.preview)},y=function(){if(c())return!1;var e=document.querySelectorAll(".sub-menu .sub-menu");if(0===e.length)return!1;var o=window.innerWidth;u(e,function(e){var n=e.getBoundingClientRect(),t=n.left;/webkit.*mobile/i.test(navigator.userAgent)&&(n-=window.scrollX),t+n.width>=o&&(e.style.right="100%",e.style.left="auto")})};function h(){this.options={menuToggleDuration:300},this.init()}var w;function b(){window.HFG=new h,function(){if(null===document.querySelector(".blog.nv-index-posts"))return;o(),r()}(),e()}function S(){y()}h.prototype.init=function(){var e=".menu-mobile-toggle";!1===(0<arguments.length&&void 0!==arguments[0]&&arguments[0])&&(e+=", #header-menu-sidebar .close-panel, .close-sidebar-panel");function n(e){e.preventDefault(),this.toggleMenuSidebar()}var t=document.querySelectorAll(e);u(t,function(e){e.removeEventListener("click",n.bind(this))}.bind(this)),i(t,"click",n.bind(this));var o=document.querySelector(".header-menu-sidebar-overlay");i(o,"click",function(){this.toggleMenuSidebar(!1)}.bind(this))},h.prototype.toggleMenuSidebar=function(e){var n=document.querySelectorAll(".menu-mobile-toggle");f(document.body,"hiding-header-menu-sidebar"),document.body.classList.contains("is-menu-sidebar")||!1===e?(l(document.body,"hiding-header-menu-sidebar"),f(document.body,"is-menu-sidebar"),f(n,"is-active"),setTimeout(function(){f(document.body,"hiding-header-menu-sidebar")}.bind(this),1e3)):(l(document.body,"is-menu-sidebar"),l(n,"is-active"))},window.addEventListener("load",function(){b()}),window.addEventListener("resize",function(){clearTimeout(w),w=setTimeout(S,500)})}();