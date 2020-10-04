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
    'supports' => ['title'],
    'menu_icon' => 'dashicons-editor-ul',
    'has_archive' => true,
  ]);
}

add_action('init', 'create_todo_item');

function add_todo_item()
{
  check_ajax_referer('nonce');

  echo 'success';
  //   $respone['success'] = true;
  //   $respone = json_encode($respone);
  //   echo $response;
  wp_die();
}

add_action('wp_ajax_add_todo_item', 'add_todo_item');
// add_action('wp_ajax_nopriv_add_todo_item', 'add_todo_item');