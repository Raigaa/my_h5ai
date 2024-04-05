document.addEventListener("DOMContentLoaded", function () {
  let fileLinks = document.querySelectorAll("a[data-file]");
  fileLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      let filePath = this.getAttribute("data-file");
      fetchContent(filePath);
    });
  });

  let modal = document.getElementById("myModal");
  let modalContent = modal.querySelector(".modal-content");

  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      stopMedia();
    }
  });

  function fetchContent(filePath) {
    console.log("Fetching content for file:", filePath);
    fetch("?action=getContent&path=" + encodeURIComponent(filePath))
      .then((response) => response.text())
      .then((data) => {
        console.log("Content received:", data);
        modalContent.innerHTML = "<pre>" + data + "</pre>";
        modal.style.display = "block";
      })
      .catch((error) => console.error("Error fetching content:", error));
  }

  let searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("keyup", function () {
    let filter = this.value.toUpperCase();
    let rows = document.querySelectorAll("table tr");
    rows.forEach(function (row) {
      let cell = row.getElementsByTagName("td")[1];
      if (cell) {
        let text = cell.textContent.toUpperCase();
        if (text.indexOf(filter) > -1) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      }
    });
  });

  function stopMedia() {
    let myMedia = document.getElementById("media");
    myMedia.pause();
    myMedia.currentTime = 0;
  }
});


