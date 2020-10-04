<?php
class ToDoListLibrary
{
  public function fetch_Items()
  {
    $todo_items = new WP_Query([
      'post_type' => 'todo-item',
      'orderby' => [
        'date' => 'ASC',
      ],
    ]);
    return $todo_items;
  }

  public function display_items_in_UI($todo_items)
  {
    while ($todo_items->have_posts()) {
      $todo_items->the_post(); ?>
<div class="todo-list__group">
    <div class="todo-list__checkbox-container">
        <input type="checkbox" checked aria-checked="true">
    </div>
    <div class="todo-list__item">
        <span class="todo_list__description"><?php the_title(); ?></span>
    </div>
</div>
<?php
    }
    wp_reset_postdata();
  }
}
