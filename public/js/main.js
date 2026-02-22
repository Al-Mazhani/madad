function incrementDownload(download) {
  const idReadBook = download.dataset.id;

  fetch('/Madad/book_ditles', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'idDownloadBook=' + encodeURIComponent(idReadBook)
  })

}
function incrementReadBook(readBook) {
  const idReadBook = readBook.dataset.id;
  fetch('/Madad/book_ditles', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'idReadBook=' + encodeURIComponent(idReadBook)
  })
}
function deleteBook(id) {

  fetch('./homePageAdmin', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'idDeleteBook=' + encodeURIComponent(id)
  })
    .then(response => response.text())
    .then(data => {
      console.log('تم الإرسال', data);
    })
    .catch(error => console.error(error));
}


const inputs = document.querySelectorAll('input[id^="code"]');

inputs.forEach((input, index) => {

  input.addEventListener('input', () => {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value && inputs[index + 1]) {
      inputs[index + 1].focus();
    }
  });

  input.addEventListener('paste', e => {
    e.preventDefault();
    const paste = e.clipboardData.getData('text').replace(/\D/g, '');
    paste.split('').slice(0, 6).forEach((char, i) => {
      if (inputs[i]) inputs[i].value = char;
    });
  });

}); 
let btnREgister = document.getElementById("btn-register");
let GetInfoUser = document.getElementById("info-user");
function DisplayInfo(){
  GetInfoUser.style.display = "block";
}