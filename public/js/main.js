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
  fetch('/Madad/homeAdimn', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'idDeleletBook=' + encodeURIComponent(id)
  })
    .then(response => response.text())
    .then(data => {
      console.log('تم الإرسال', data);
    })
    .catch(error => console.error(error));
}
let OFFSET = 0;
let LIMIT = 8;
function LoadloadMoreBooks() {
  fetch('/Madad/books/load-more', {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: new URLSearchParams({
      offset: OFFSET,
      limit: LIMIT
    })
  })
    .then(response => response.json())
    .then(data => {
      console.log(data); 
    })
    .catch(error => console.error(error));
}
// window.history.replaceState({}, document.title, window.location.pathname);
