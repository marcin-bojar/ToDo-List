console.log('ToDo List plugin loaded.....');

// const toDoInput = document.getElementById('add-todo-item');
// console.log(toDoInput);

document.addEventListener('submit', e => {
  e.preventDefault();
  console.log(new URLSearchParams(new FormData(e.target)).toString());
  if (e.target.id === 'add-todo-item') {
    fetch(call_data.ajax_url, {
      method: 'POST',
      data: {
        action: 'add_todo_item',
        _ajax_nonce: call_data.nonce,
      },
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Cache-Control': 'no-cache',
      },
      body: new URLSearchParams(new FormData(e.target)),
    })
      .then(response => {
        return response.json();
      })
      .then(data => {
        console.log(data);
      })
      .catch(error => {
        alert(error);
      });
  }
});
