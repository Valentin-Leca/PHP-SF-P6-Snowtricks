const newItem = (e) => {
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);

    const item = document.createElement("div");
    item.classList.add("col-4.d-flex.justify-content-center");
    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    item.querySelector(".btn-remove").addEventListener("click", () => item.remove());

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
};

// create and delete the new input at edition
document.querySelectorAll('.btn-new').forEach(btn => btn.addEventListener('click', newItem));
document.querySelectorAll('.btn-remove').forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest(".col-4").remove()));

// delete the input already existing at edition
document.querySelectorAll('.btn-remove').forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest(".div-input-images").remove()));
document.querySelectorAll('.btn-remove').forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest(".input-video").remove()));

document.getElementById('btn-trick').onclick = function(){
    this.disabled = true
    this.form.submit()
}