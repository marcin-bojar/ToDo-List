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
<div class="todo-list__group" data-id=<?php echo get_the_ID(); ?>>
    <div class="todo-list__checkbox-container">
        <input id="item-todo" type="checkbox" <?php if (
          get_the_content() == 'DONE'
        ) {
          echo 'checked';
        } ?>>
    </div>
    <div id="title" class="todo-list__item">
        <span class="todo-list__description"><?php the_title(); ?></span>
        <div id="delete" class="todo-list__delete">&times;</div> <!-- Should be <button></button> -->
    </div>
</div>
<?php
    }
    wp_reset_postdata();
  }
}