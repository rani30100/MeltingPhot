//page actions
const btn = document.querySelector('#bouton');

document.getElementById("my-dropdown2").addEventListener("change", function () {
var option = this.options[this.selectedIndex];
if (option.value == "option-3") {
window.location.href = "/actions/2022";
}
});

document.getElementById("my-dropdown2").addEventListener("change", function () {
var option = this.options[this.selectedIndex];
if (option.value == "option-2") {
window.location.href = "/actions/2023";
}
});

