import axios from 'axios';

console.log('ToDo List plugin loaded...');

const inputCheckbox = document.getElementById('todo');
const itemsCheckbox = document.querySelectorAll('#item-todo');
const itemsName = document.querySelectorAll('#title');

//Delete todo item
document.addEventListener('click', e => {
  if (e.target.id === 'delete') {
    const ID = e.target.closest('div[data-id]').dataset.id;

    //AJAX call
    axios({
      method: 'post',
      url: call_data.ajax_url,
      params: {
        action: 'delete_todo_item',
        _ajax_nonce: call_data.nonce,
      },
      data: {
        name,
        ID,
      },
    })
      .then(() => {
        // Reload the page to update the ToDo List (this is so unclean, I know but the time is running out. React would do the job here :))
        window.location.reload();
      })
      .catch(error => {
        alert('Something went wrong. Are you logged in?');
        console.log(error);
      });
  }
});

// Change the name of the task when clicked on it
itemsName.forEach(el => {
  el.addEventListener('click', e => {
    //Check if the delete button wasnt clicked
    if (e.target != el) {
      return;
    }

    const ID = e.target.closest('div[data-id]').dataset.id;
    const name = prompt('Please enter new name for this task:');

    //Check if name is not empty
    if (!name) {
      alert('The name can not be empty.');
    } else {
      //AJAX call
      axios({
        method: 'post',
        url: call_data.ajax_url,
        params: {
          action: 'change_todo_name',
          _ajax_nonce: call_data.nonce,
        },
        data: {
          name,
          ID,
        },
      })
        .then(() => {
          alert('Name of the task has been changed.');
          // Reload the page to update the ToDo List (this is so unclean, I know but the time is running out. React would do the job here :))
          window.location.reload();
        })
        .catch(error => {
          alert('Something went wrong. Are you logged in?');
          console.log(error);
        });
    }
  });
});

// Change the status of the task in the database when checkbox is clicked
itemsCheckbox.forEach(el =>
  el.addEventListener('change', e => {
    const ID = e.target.closest('div[data-id]').dataset.id;

    //AJAX call
    axios({
      method: 'post',
      url: call_data.ajax_url,
      params: {
        action: 'change_todo_status',
        _ajax_nonce: call_data.nonce,
      },
      data: {
        ID,
      },
    })
      .then(() => {
        alert("Status changed. Keep goin'!.");
      })
      .catch(error => {
        alert('Something went wrong. Are you logged in?');
        console.log(error);
      });
  })
);

//Submit the new task to the database
document.addEventListener('submit', e => {
  e.preventDefault();

  if (e.target.id === 'add-todo-item') {
    // Get the input value
    let taskName = document.getElementById('task').value;

    //Check if the input is not empty
    if (!taskName) {
      alert('Please provide the task name.');
    } else {
      //Verify the checkbox status
      let toDo = inputCheckbox.checked;
      toDo = toDo ? 'DONE' : 'UNDONE';

      //AJAX call
      axios({
        method: 'post',
        url: call_data.ajax_url,
        params: {
          action: 'add_todo_item',
          _ajax_nonce: call_data.nonce,
        },
        data: {
          taskName,
          toDo,
        },
      })
        .then(() => {
          taskName = '';
          alert('Task added. Have a nice day.');
          window.location.reload();
        })
        .catch(error => {
          alert('Something went wrong. Are you logged in?');
          console.log(error);
        });
    }
  }
});
