// Add an event listener that changes the color of an element
// when the user clicks on it.

var colors = ["blue", "green", "red", "purple"];
var index = 0;

document.getElementById("example").addEventListener("click", function(event) {
    document.getElementById("example").style.color = colors[index];
    index++;
    index = index % 4;
});
