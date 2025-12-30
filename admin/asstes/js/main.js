function deleteBook(id) {
  fetch('/Madad/admin/home', {
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
