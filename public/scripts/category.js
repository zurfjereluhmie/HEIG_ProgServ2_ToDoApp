"use strict";

import { $, $$ } from "./modules/selectors.js";

$("input[name='showLateTask']").addEventListener("change", (e) => {
    $(".lateTaskContainer").style.display = (e.target.checked) ? "block" : "none";
});

$("input[name='showDoneTask']").addEventListener("change", (e) => {
    $(".doneTaskContainer").style.display = (e.target.checked) ? "block" : "none";
});

$("main").addEventListener("click", (e) => {
    // Handle done/undone task
    if (e.target.type === "checkbox" && e.target.dataset.taskid) {
        const id = e.target.dataset.taskid;
        const status = e.target.checked;

        fetch("/api/task/updateStatus.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id, status })
        })
            .then(res => {
                if (res.ok) location.reload();
                else throw new Error("Something went wrong");
            })
            .catch(err => console.error(err));
        return;
    }

    // Handle delete task
    if (e.target.closest(".taskTrash")) {
        const id = e.target.closest(".taskTrash").parentElement.parentElement.dataset.id;

        // ask for confirmation
        if (!confirm("Are you sure you want to delete this task?")) return;

        fetch("/api/task/delete.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id })
        })
            .then(res => {
                if (res.ok) location.reload();
                else throw new Error("Something went wrong");
            })
            .catch(err => console.error(err));
        return;
    }

    // Handle favourite task
    if (e.target.closest(".taskStar")) {

        const id = e.target.closest(".taskStar").parentElement.parentElement.dataset.id;
        const favourite = !(e.target.closest(".taskStar").dataset.isfav === "true");

        fetch("/api/task/updateFavourite.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id, favourite })
        })
            .then(res => {
                if (res.ok) location.reload();
                else throw new Error("Something went wrong");
            })
            .catch(err => console.error(err));
        return;
    }

    // Redirect to task edit page
    // TODO: add edit task page
    if (e.target.closest(".task")) {
        const id = e.target.closest(".task").dataset.id;
        location.href = `/task.php?id=${id}`;
    }

});