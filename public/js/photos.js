var modal = document.getElementById("myModal");
var img = document.getElementById("photo1");
var img2 = document.getElementById("photo2");
var img3 = document.getElementById("photo3");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

$(document).on("change", "#photo", function (e) {
    var id = $(this).data("id");
    document.getElementById("form").submit();
});

$(document).on("change", "#photo1", function (e) {
    var id = $(this).data("id");
    document.getElementById("form1").submit();
});

$(document).on("change", "#photo2", function (e) {
    var id = $(this).data("id");
    document.getElementById("form2").submit();
});

img.onclick = function () {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

img2.onclick = function () {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

img3.onclick = function () {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementById("close");

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}
