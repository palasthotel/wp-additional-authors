!function(){"use strict";window.document.addEventListener("DOMContentLoaded",(()=>{const e=document.querySelector(".wp-list-table.users"),t=e.querySelectorAll("tr[id^='user-']"),n=Array.from(t).map((e=>e.getAttribute("id").replace("user-","")));if(!n.length)return;const r=e.querySelector("#posts"),o=document.createElement("span");o.classList.add("spinner","is-active"),o.style.position="absolute",o.style.transform="translate(-34px, -4px)",r.prepend(o),fetch(window.AdditionalAuthors.ajaxUrl+"?action=additional_authors_count_posts&user_ids="+n.join(",")).then((e=>e.json())).then((t=>{for(const n in t){const r=e.querySelector("tr[id='user-"+n+"'] td.column-posts.num");if(r.querySelector("a"))r.querySelector("a > span:first-child").textContent=String(t[n]);else if(t[n]>0){const e=document.createElement("a");e.href=window.AdditionalAuthors.postsUrl+"?author="+n,e.innerText=String(t[n]),r.innerHTML="",r.append(e)}}})).finally((()=>{setTimeout((()=>{o.remove()}),1e3)}))}))}();
//# sourceMappingURL=users-table.js.map