"use strict";

const myCategories = document.querySelector("#myCategories");

myCategories?.addEventListener("click", (e) => {
    if (e.target.closest(".myCategoriesItem")) {
        const catId = e.target.closest(".myCategoriesItem").dataset.id;
        window.location.href = `/category.php?id=${catId}`;
    }

});

const addListTrigger = document.querySelector("#addListTrigger");

addListTrigger?.addEventListener("click", () => {
    alert("Feature to implement in public/scripts/categories.js")
});