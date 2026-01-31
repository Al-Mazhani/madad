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
  fetch('/Madad/homeAdmin', {
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


