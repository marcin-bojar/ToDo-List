<?php

//Add scripts
function todo_add_scripts()
{
  wp_enqueue_style(
    'todo-main-styles',
    plugins_url() . '/todo-list/public/css/style.css'
  );

  wp_enqueue_script(
    'todo-main-script',
    plugins_url() . '/todo-list/public/js/bundle.js'
  );

  wp_localize_script('todo-main-script', 'call_data', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('nonce'),
  ]);
}

add_action('wp_enqueue_scripts', 'todo_add_scripts');