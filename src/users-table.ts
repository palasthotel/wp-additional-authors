// @ts-ignore
// @ts-ignore

window.document.addEventListener("DOMContentLoaded", () => {
    const table = document.querySelector(".wp-list-table.users")
    const rows = table.querySelectorAll("tr[id^='user-']");
    const ids = Array.from(rows).map(row => {
        return row.getAttribute("id").replace("user-", "");
    });
    if (!ids.length) return;

    const head = table.querySelector("#posts");
    const spinner = document.createElement("span");
    spinner.classList.add("spinner", "is-active");
    spinner.style.position = "absolute";
    spinner.style.transform = "translate(-34px, -4px)";
    head.prepend(spinner);

    fetch(
        window.AdditionalAuthors.ajaxUrl+"?action=additional_authors_count_posts&user_ids=" + ids.join(",")
    ).then(
        response => response.json()
    ).then(
        (json: Record<string, number>) => {
            for (const userId in json) {
                const item = table.querySelector("tr[id='user-"+userId+"'] td.column-posts.num");
                if(item.querySelector("a")){
                    item.querySelector("a > span:first-child").textContent = String(json[userId]);
                } else if(json[userId] > 0){
                    const a = document.createElement("a");
                    a.href = window.AdditionalAuthors.postsUrl+"?author="+userId;
                    a.innerText = String(json[userId]);
                    item.innerHTML = "";
                    item.append(a);
                }
            }
        }
    ).finally(
        ()=> {
            setTimeout(()=>{
                spinner.remove();
            }, 1000)
        }
    );

});

export {}

declare global {
    interface Window {
        AdditionalAuthors: {
            postsUrl: string
            ajaxUrl: string
        }
    }
}