<?php

/**
 * Plugin Name: ToDo List Plugin
 * Description: Add and manage your tasks!
 * Version: 1.0
 * Author: Marcin Bojar
 */

// No direct access!
if (!defined('ABSPATH')) {
  exit();
}

require_once plugin_dir_path(__FILE__) . '/includes/todo-list-scripts.php';
require_once plugin_dir_path(__FILE__) . '/includes/todo-list-class.php';

//Register Widget
function register_todo_list()
{
  register_widget('ToDoList');
}

add_action('widgets_init', 'register_todo_list');

//Register custom post type
function create_todo_item()
{
  register_post_type('todo-item', [
    'labels' => [
      'name' => 'ToDo Items',
      'singular_name' => 'ToDO item',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New ToDo Item',
      'edit' => 'Edit',
      'edit_item' => 'Edit ToDo Item',
      'new_item' => 'New ToDo Item',
      'view' => 'View',
      'view_item' => 'View ToDo Item',
      'search_items' => 'Search ToDo Items',
      'not_found' => 'No ToDo Items found',
      'not_found_in_trash' => 'No ToDo Items found in Trash',
      'parent' => 'Parent ToDo Item',
    ],
    'description' => 'ToDo items are displayed In TodO List plugin.',
    'public' => true,
    'supports' => ['title', 'editor', 'custom-fields'],
    'menu_icon' => 'dashicons-editor-ul',
    'has_archive' => true,
  ]);
}

add_action('init', 'create_todo_item');

function add_todo_item()
{
  check_ajax_referer('nonce');

  $_POST = json_decode(file_get_contents('php://input'), true);
  $title = filter_var($_POST['taskName'], FILTER_SANITIZE_STRING);
  $toDo = $_POST['toDo'];

  $post_data = [
    'post_title' => $title,
    'post_content' => $toDo,
    'post_status' => 'publish',
    'post_type' => 'todo-item',
  ];

  $pid = wp_insert_post($post_data);

  echo 'Success';
  wp_die();
}

function change_todo_status()
{
  check_ajax_referer('nonce');

  $_POST = json_decode(file_get_contents('php://input'), true);
  $ID = $_POST['ID'];

  $post = get_post($ID, ARRAY_A);
  $post['post_content'] = $post['post_content'] == 'DONE' ? 'UNDONE' : 'DONE';
  $post['ID'] = $ID;
  wp_insert_post($post);

  echo 'Success';
  wp_die();
}

function change_todo_name()
{
  check_ajax_referer('nonce');

  $_POST = json_decode(file_get_contents('php://input'), true);
  $title = $_POST['name'];
  $ID = $_POST['ID'];

  $post = get_post($ID, ARRAY_A);
  $post['post_title'] = $title;
  $post['ID'] = $ID;
  wp_insert_post($post);

  echo 'Success';
  wp_die();
}

function delete_todo_item()
{
  check_ajax_referer('nonce');

  $_POST = json_decode(file_get_contents('php://input'), true);
  $ID = $_POST['ID'];

  wp_delete_post($ID);

  echo 'Success';
  wp_die();
}

// Only logged in users can add new ToDo Item the the plugin or modify existing one!
add_action('wp_ajax_add_todo_item', 'add_todo_item');
add_action('wp_ajax_change_todo_status', 'change_todo_status');
add_action('wp_ajax_change_todo_name', 'change_todo_name');
add_action('wp_ajax_delete_todo_item', 'delete_todo_item');

// add_action('wp_ajax_nopriv_add_todo_item', 'add_todo_item');