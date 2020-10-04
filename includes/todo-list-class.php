<?php
require_once plugin_dir_path(__FILE__) . './todo-list-library-class.php';

class ToDoList extends WP_Widget
{
  public function __construct()
  {
    parent::__construct('ToDo List', esc_html__('ToDo List', 'todo_domain'), [
      'description' => esc_html__('Add and manage your tasks', 'todo_domain'),
    ]);
  }

  public function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    if (!empty($instance['title'])) {
      echo $before_title .
        apply_filters('widget_title', $instance['title']) .
        $after_title;
    } else {
      echo $before_title .
        apply_filters('widget_title', 'ToDo List') .
        $after_title;
    }
    ?>
<!-- Display widget in UI -->
<div class="todo-list">
    <form method="post" action="" id="add-todo-item" class="todo-list__form--input">
        <div class="todo-list__group todo-list__group--input">
            <div class="todo-list__checkbox-container">
                <input id="todo" type="checkbox">
            </div>
            <div class="todo-list__input-container">
                <input type="text" id="task" name="title" class="todo-list__input" placeholder="Enter new task here...">
            </div>
        </div>
    </form>
    <!-- Fetch the ToDo items from the database... -->
    <?php
    $todo_items = ToDoListLibrary::fetch_items();

    // ...and display them in the widget
    ToDoListLibrary::display_items_in_UI($todo_items);
    ?>

    <input name="action" type="hidden" value="add_todo_item" />

</div>

<?php echo $after_widget;
  }

  public function form($instance)
  {
    $title = !empty($instance['title'])
      ? $instance['title']
      : esc_html__('ToDo List', 'todo_domain'); ?>
<p>
    <label for="<?php echo esc_attr(
      $this->get_field_id('title')
    ); ?>"><?php esc_attr_e('Title:', 'todo_domain'); ?></label>
    <input class="widefat" id="<?php echo esc_attr(
      $this->get_field_id('title')
    ); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
        value="<?php echo esc_attr($title); ?>">
</p>
<?php
  }

  public function update($new_instance, $old_instance)
  {
    $instance = [];
    $instance['title'] = !empty($new_instance['title'])
      ? sanitize_text_field($new_instance['title'])
      : '';

    return $instance;
  }
}

?>
