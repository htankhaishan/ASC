document.addEventListener("DOMContentLoaded", function () {
    let buttons = document.querySelectorAll("button");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            alert("Button clicked! (Insecure JavaScript Example)");
        });
    });
});
