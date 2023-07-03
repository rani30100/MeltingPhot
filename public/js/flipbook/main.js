
    const prevBtn = document.querySelector(".prev-btn-flip");
    const nextBtn = document.querySelector(".next-btn-flip");
    const book = document.querySelector(".book");
    const paper1 = document.querySelector(".p1");
    const paper2 = document.querySelector(".p2");
    const paper3 = document.querySelector(".p3");
  

    // Sélectionnez l'élément sur lequel vous souhaitez activer le zoom par pincement
const zoomElement = document.getElementById("zoom");

// Créez une instance de Hammer.js pour l'élément sélectionné
const hammer = new Hammer(zoomElement);

// Ajoutez un gestionnaire pour le geste de pincement
hammer.get("pinch").set({ enable: true });

// Définissez les gestionnaires d'événements pour le geste de pincement
hammer.on("pinchstart pinchmove", function (event) {
  // Accédez à l'échelle du pincement
  const scale = event.scale;

  // Appliquez le zoom à l'élément en utilisant l'échelle
  zoomElement.style.transform = `scale(${scale})`;
});

// Réinitialisez le zoom lorsque le geste de pincement est terminé
hammer.on("pinchend", function () {
  zoomElement.style.transform = "scale(1)";
});

    // Event Listener
    prevBtn.addEventListener("click", goPrevPage);
    nextBtn.addEventListener("click", goNextPage);
  
    // Business Logic
    let currentLocation = 1;
    let numOfPapers = 3;
    let maxLocation = numOfPapers + 1;
  
    function openBook() {
      book.style.transform = "translateX(50%)";
      prevBtn.style.transform = "translateX(-30px)";
      nextBtn.style.transform = "translateX(30px)";
    }
  
    function closeBook(isAtBeginning) {
      if (isAtBeginning) {
        book.style.transform = "translateX(25%)";
      } else {
        book.style.transform = "translateX(77%)";
      }
  
      prevBtn.style.transform = "translateX(78px)";
      nextBtn.style.transform = "translateX(-56px)";
    }
  
    function goNextPage() {
      if (currentLocation < maxLocation) {
        switch (currentLocation) {
          case 1:
            openBook();
            paper1.classList.add("flipped");
            paper1.style.zIndex = 1;
            break;
          case 2:
            paper2.classList.add("flipped");
            paper2.style.zIndex = 2;
            break;
          case 3:
            paper3.classList.add("flipped");
            paper3.style.zIndex = 3;
            closeBook(false);
            break;
          default:
            throw new Error("Unknown state");
        }
        currentLocation++;
      }
    }
  
    function goPrevPage() {
      if (currentLocation > 1) {
        switch (currentLocation) {
          case 2:
            closeBook(true);
            paper1.classList.remove("flipped");
            paper1.style.zIndex = 3;
            break;
          case 3:
            paper2.classList.remove("flipped");
            paper2.style.zIndex = 2;
            break;
          case 4:
            openBook();
            paper3.classList.remove("flipped");
            paper3.style.zIndex = 1;
            break;
          default:
            throw new Error("Unknown state");
        }
  
        currentLocation--;
      }
      
 
      
    }

 