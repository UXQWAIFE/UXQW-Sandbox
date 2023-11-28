let wordsToDefineEl = document.querySelectorAll("[data-def]");
let modal = document.querySelector(".rcn-modalOverlayedContainer");
let defButton = document.querySelector(".rcn-definition-modalButton");
let closeModalButton = document.querySelector(".rcn-modal__closeButton");
let modalTitle = document.querySelector(".rcn-modal__title");
let modalContent = document.querySelector(".rcn-modal__content");

window.addEventListener("load", (event) => {
  let defList = document.createElement("dl");

  wordsToDefineEl.forEach((el) => {
    //Find words to define in the page and give them attributes
    const word = el.innerHTML.toLowerCase();
    el.setAttribute("data-def", word);
    el.setAttribute("title", "Acceder à la definition");
    el.classList.add("rcn-definitionUnderlined");

    //Generate definitions
    const defTitle = document.createElement("dt");
    defTitle.classList.add("rcn-definition__def-title");
    defTitle.innerHTML = word;
    let defText = document.createElement("dd");
    defText.innerHTML = `<p>${generateLoremText(3, 15)}</p>`;
    defList.appendChild(defTitle);
    defList.appendChild(defText);
  });
  modalContent.append(defList);
});

function showModal() {
  modal.classList.add("rcn-modalOverlayedContainer--visible");
  modal.classList.remove("rcn-modalOverlayedContainer--invisible");
  modal.setAttribute("aria-hidden", false);
}

function hideModal() {
  modal.classList.add("rcn-modalOverlayedContainer--invisible");
  modal.classList.remove("rcn-modalOverlayedContainer--visible");
  modal.setAttribute("aria-hidden", true);
}

//generate lorem definition
function generateLoremText(numParagraphs, numWords) {
  var loremText = "";
  var words = [
    "Lorem",
    "ipsum",
    "dolor",
    "sit",
    "amet",
    "consectetur",
    "adipiscing",
    "elit",
    "sed",
    "do",
    "eiusmod",
    "tempor",
    "incididunt",
    "ut",
    "labore",
    "et",
    "dolore",
    "magna",
    "aliqua",
    "Ut",
    "enim",
    "ad",
    "minim",
    "veniam",
    "quis",
    "nostrud",
    "exercitation",
    "ullamco",
    "laboris",
    "nisi",
    "ut",
    "aliquip",
    "ex",
    "ea",
    "commodo",
    "consequat",
    "Duis",
    "aute",
    "irure",
    "dolor",
    "in",
    "reprehenderit",
    "in",
    "voluptate",
    "velit",
    "esse",
    "cillum",
    "dolore",
    "eu",
    "fugiat",
    "nulla",
    "pariatur",
    "Excepteur",
    "sint",
    "occaecat",
    "cupidatat",
    "non",
    "proident",
    "sunt",
    "in",
    "culpa",
    "qui",
    "officia",
    "deserunt",
    "mollit",
    "anim",
    "id",
    "est",
    "laborum",
  ];

  for (var i = 0; i < numParagraphs; i++) {
    var paragraph = "";
    for (var j = 0; j < numWords; j++) {
      var randomWord = words[Math.floor(Math.random() * words.length)];
      paragraph += randomWord + " ";
    }
    loremText += "" + paragraph + "";
  }
  return loremText;
}

defButton.addEventListener("click", (event) => {
  showModal();
});

closeModalButton.addEventListener("click", (event) => {
  hideModal();
});
