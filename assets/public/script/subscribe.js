"use strict";function nx_focus_add_class(e,t){var n=document.querySelectorAll(e);if(n.length>0)for(var r=0;r<n.length;r++)n[r]&&(n[r].addEventListener("focus",s),n[r].addEventListener("blur",s));function s(){event.preventDefault();var e=this.parentElement;e&&e.classList.toggle(t)}}